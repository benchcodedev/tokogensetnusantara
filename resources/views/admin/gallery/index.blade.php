@extends('admin.layout')

@section('title', 'Kelola Galeri')

@section('content')
<div class="admin-header">
    <div>
        <h1 style="font-size: 2rem; margin-bottom: 4px;">Galeri &amp; Dokumentasi</h1>
        <p style="font-size: 0.95rem; color: var(--muted);">Dokumentasi gudang, pengiriman, unit forklift, dan unit terjual (Sold).</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        + Unggah Foto Galeri
    </a>
</div>

<div class="admin-card" style="padding: 0; overflow: hidden;">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Foto</th>
                    <th>Judul Dokumentasi</th>
                    <th>Kategori</th>
                    <th>Urutan Tampil</th>
                    <th>Path Foto</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            <div style="width: 64px; height: 48px; border-radius: 4px; overflow: hidden; border: var(--border-thin);">
                                <x-image-box :src="$item->foto" :alt="$item->judul" aspect="4/3" />
                            </div>
                        </td>
                        <td>
                            <strong>{{ $item->judul }}</strong>
                        </td>
                        <td>
                            <span class="admin-badge admin-badge-muted">{{ ucfirst($item->kategori) }}</span>
                        </td>
                        <td>{{ $item->urutan }}</td>
                        <td style="font-size: 0.8125rem; color: var(--muted);">{{ $item->foto }}</td>
                        <td style="text-align: right; white-space: nowrap;">
                            <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-secondary btn-sm" style="margin-right: 6px;">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $item->id) }}" style="display: inline-block;" onsubmit="return confirm('Hapus item galeri ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--muted); padding: 36px;">
                            Belum ada foto dalam galeri.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 24px; display: flex; justify-content: center;">
    {{ $items->links() }}
</div>
@endsection
