<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GuestImportService
{
    public const MAX_ROWS = 1000;
    public const MAX_FILE_SIZE_KB = 5120; // 5 MB

    /**
     * Membaca dan memvalidasi file Excel sebelum disimpan ke database
     *
     * @param string|UploadedFile $filePath
     * @param int $eventId
     * @return array
     */
    public function preview($filePath, int $eventId): array
    {
        $realPath = is_string($filePath) ? $filePath : $filePath->getRealPath();

        if (!file_exists($realPath)) {
            throw new \Exception('File tidak ditemukan.');
        }

        // Cek ekstensi / format
        $spreadsheet = IOFactory::load($realPath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, false);

        if (empty($rows)) {
            throw new \Exception('File Excel kosong atau tidak dapat dibaca.');
        }

        // Ambil header di baris pertama
        $header = array_shift($rows);
        $headerMap = $this->mapHeaders($header);

        // Ambil daftar nama tamu yang sudah ada di event ini (case-insensitive)
        $existingNames = Guest::where('event_id', $eventId)
            ->pluck('nama')
            ->map(fn($n) => strtolower(trim($n)))
            ->flip()
            ->toArray();

        $previewRows = [];
        $namesInFile = [];
        $rowCount = 0;

        foreach ($rows as $rowIndex => $row) {
            // Abaikan baris yang seluruh kolomnya kosong
            $allEmpty = true;
            foreach ($row as $cell) {
                if (!is_null($cell) && trim((string)$cell) !== '') {
                    $allEmpty = false;
                    break;
                }
            }
            if ($allEmpty) {
                continue;
            }

            $rowCount++;
            if ($rowCount > self::MAX_ROWS) {
                throw new \Exception('Jumlah baris melebihi batas maksimal (' . self::MAX_ROWS . ' baris).');
            }

            $nama = trim((string)($row[$headerMap['nama']] ?? ''));
            $rawPax = $row[$headerMap['pax']] ?? null;
            $rawHp = $row[$headerMap['no_hp']] ?? null;
            $kategori = trim((string)($row[$headerMap['kategori']] ?? ''));

            // Validasi Pax
            $parsedPax = GuestHelper::parsePax($rawPax);
            $paxError = false;
            if (is_null($parsedPax)) {
                $paxError = true;
                $parsedPax = 1; // Default fallback jika dipaksa simpan, tapi statusnya error
            }

            // Validasi Nama
            $namaError = empty($nama);

            // Cek duplikasi
            $isDuplicateInDb = false;
            $isDuplicateInFile = false;
            $duplicateReason = null;

            if (!$namaError) {
                $lowerNama = strtolower($nama);

                if (isset($existingNames[$lowerNama])) {
                    $isDuplicateInDb = true;
                    $duplicateReason = 'Sudah terdaftar di acara ini';
                }

                if (isset($namesInFile[$lowerNama])) {
                    $isDuplicateInFile = true;
                    $duplicateReason = $duplicateReason ? $duplicateReason . ' & duplikat dalam file' : 'Duplikat dalam file Excel';
                } else {
                    $namesInFile[$lowerNama] = true;
                }
            }

            $isDuplicate = $isDuplicateInDb || $isDuplicateInFile;

            // Status baris
            if ($namaError) {
                $status = 'error';
                $statusText = 'Nama Kosong';
                $defaultAction = 'lewati';
            } elseif ($paxError) {
                $status = 'error';
                $statusText = 'Pax Tidak Terbaca (Harus angka ≥ 1)';
                $defaultAction = 'lewati';
            } elseif ($isDuplicate) {
                $status = 'warning';
                $statusText = $duplicateReason;
                $defaultAction = 'lewati'; // Penyesuaian #3: diberi pilihan simpan atau lewati, default lewati untuk duplikat
            } else {
                $status = 'valid';
                $statusText = 'Siap Diimpor';
                $defaultAction = 'simpan';
            }

            $previewRows[] = [
                'index' => $rowIndex + 2, // Baris pada Excel (1-indexed + header)
                'nama' => $nama,
                'pax_raw' => (string)$rawPax,
                'pax' => $parsedPax,
                'no_hp_raw' => (string)$rawHp,
                'no_hp_normalized' => GuestHelper::normalizePhoneNumber((string)$rawHp),
                'kategori' => $kategori ?: '-',
                'status' => $status,
                'status_text' => $statusText,
                'is_duplicate' => $isDuplicate,
                'is_error' => $namaError || $paxError,
                'action' => $defaultAction, // 'simpan' atau 'lewati'
            ];
        }

        return $previewRows;
    }

    /**
     * Menyimpan baris-baris valid ke database dalam DB Transaction
     *
     * @param int $eventId
     * @param array $rows
     * @return array
     */
    public function executeImport(int $eventId, array $rows): array
    {
        $event = Event::findOrFail($eventId);

        return DB::transaction(function () use ($event, $rows) {
            $importedCount = 0;
            $skippedCount = 0;

            foreach ($rows as $item) {
                // Abaikan jika user memilih 'lewati' atau data error
                if (($item['action'] ?? 'simpan') === 'lewati' || !empty($item['is_error'])) {
                    $skippedCount++;
                    continue;
                }

                if (empty(trim($item['nama']))) {
                    $skippedCount++;
                    continue;
                }

                Guest::create([
                    'event_id' => $event->id,
                    'nama' => trim($item['nama']),
                    'pax' => (int)($item['pax'] ?? 1),
                    'no_hp' => !empty($item['no_hp_normalized']) ? $item['no_hp_normalized'] : ($item['no_hp_raw'] ?: null),
                    'kategori' => !empty($item['kategori']) && $item['kategori'] !== '-' ? trim($item['kategori']) : null,
                    'slug_unik' => GuestHelper::generateUniqueSlug(10),
                ]);

                $importedCount++;
            }

            return [
                'imported' => $importedCount,
                'skipped' => $skippedCount,
            ];
        });
    }

    /**
     * Map header Excel ke index kolom
     */
    protected function mapHeaders(array $header): array
    {
        $map = [
            'nama' => 0,
            'pax' => 1,
            'no_hp' => 2,
            'kategori' => 3,
        ];

        foreach ($header as $idx => $colName) {
            $colLower = strtolower(trim((string)$colName));
            if (str_contains($colLower, 'nama')) {
                $map['nama'] = $idx;
            } elseif (str_contains($colLower, 'pax') || str_contains($colLower, 'jumlah') || str_contains($colLower, 'kuota')) {
                $map['pax'] = $idx;
            } elseif (str_contains($colLower, 'hp') || str_contains($colLower, 'wa') || str_contains($colLower, 'telepon') || str_contains($colLower, 'phone')) {
                $map['no_hp'] = $idx;
            } elseif (str_contains($colLower, 'kategori') || str_contains($colLower, 'group') || str_contains($colLower, 'kelompok')) {
                $map['kategori'] = $idx;
            }
        }

        return $map;
    }
}
