@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Proyek: ' . $project->title : 'Tambah Proyek Baru')
@section('header_title', $isEdit ? 'Edit Proyek' : 'Tambah Proyek Baru')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Top Breadcrumb/Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.projects.index') }}" class="text-xs font-bold text-stone-500 hover:text-stone-800 inline-flex items-center transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Proyek</span>
        </a>
        <span class="text-xs text-stone-400 font-medium">{{ $isEdit ? 'Mengedit ID #' . $project->id : 'Entri Baru' }}</span>
    </div>

    <!-- Error Summary -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
            <div class="font-bold text-sm mb-1">Periksa kembali formulir Anda:</div>
            @foreach($errors->all() as $error)
                <div>&bull; {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm p-6 sm:p-10">
        
        <form action="{{ $isEdit ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Title -->
            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Judul Proyek <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $project->title) }}" 
                       required 
                       placeholder="Contoh: PLTS Atap Fasilitas Manufaktur Cikarang" 
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500">
            </div>

            <!-- Category, Capacity, Status in 3 cols -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500 bg-white">
                        <option value="PLTS / Solar" {{ old('category', $project->category) === 'PLTS / Solar' ? 'selected' : '' }}>PLTS / Solar</option>
                        <option value="BESS / Storage" {{ old('category', $project->category) === 'BESS / Storage' ? 'selected' : '' }}>BESS / Storage</option>
                        <option value="Infrastruktur & Substation" {{ old('category', $project->category) === 'Infrastruktur & Substation' ? 'selected' : '' }}>Infrastruktur & Substation</option>
                        <option value="O&M / Asset Management" {{ old('category', $project->category) === 'O&M / Asset Management' ? 'selected' : '' }}>O&M / Asset Management</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Kapasitas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="capacity" 
                           value="{{ old('capacity', $project->capacity) }}" 
                           required 
                           placeholder="Contoh: 3.2 MWp / 500 kWp" 
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500 bg-white">
                        <option value="Operasional" {{ old('status', $project->status) === 'Operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="Selesai" {{ old('status', $project->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Konstruksi" {{ old('status', $project->status) === 'Konstruksi' ? 'selected' : '' }}>Konstruksi</option>
                    </select>
                </div>
            </div>

            <!-- Client, Location, Year in 3 cols -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Nama Klien / Fasilitas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="client" 
                           value="{{ old('client', $project->client) }}" 
                           required 
                           placeholder="PT Indotech Mandiri Perkasa" 
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Lokasi Proyek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="location" 
                           value="{{ old('location', $project->location) }}" 
                           required 
                           placeholder="Cikarang, Jawa Barat" 
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Tahun Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="year" 
                           value="{{ old('year', $project->year ?? date('Y')) }}" 
                           required 
                           min="2010" 
                           max="2035" 
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500">
                </div>
            </div>

            <!-- Is Featured Toggle -->
            <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 flex items-center justify-between">
                <div>
                    <div class="font-bold text-sm text-stone-900">Jadikan Proyek Unggulan</div>
                    <div class="text-xs text-stone-500">Proyek unggulan akan ditampilkan di bagian Beranda (Homepage).</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-stone-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brown-500"></div>
                </label>
            </div>

            <!-- Cover Image Upload & URL -->
            <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">
                        Foto Sampul Utama (Cover Image)
                    </label>
                    <p class="text-xs text-stone-500 mb-3">Upload file foto dari komputer atau masukkan link URL gambar.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-[11px] font-semibold text-stone-600 mb-1">Upload File (JPG, PNG, WebP maks 10MB)</label>
                        <input type="file" 
                               name="cover_image_file" 
                               accept="image/*" 
                               class="w-full text-xs text-stone-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brown-500 file:text-white hover:file:bg-brown-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-stone-600 mb-1">Atau Gunakan URL Gambar</label>
                        <input type="url" 
                               name="cover_image_url" 
                               value="{{ old('cover_image_url', $project->cover_image) }}" 
                               placeholder="https://images.unsplash.com/..." 
                               class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                    </div>
                </div>

                @if($project->cover_image)
                    <div class="pt-2 flex items-center space-x-3">
                        <img src="{{ $project->cover_image }}" alt="Preview" class="w-20 h-14 rounded-lg object-cover border border-stone-300 shadow-sm">
                        <span class="text-xs text-stone-500">Foto sampul saat ini aktif.</span>
                    </div>
                @endif
            </div>

            <!-- Additional Gallery Photos -->
            <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">
                        Foto Galeri Tambahan (Multiple Upload)
                    </label>
                    <p class="text-xs text-stone-500">Anda dapat memilih beberapa foto sekaligus untuk menambah galeri dokumentasi.</p>
                </div>

                <input type="file" 
                       name="gallery_files[]" 
                       multiple 
                       accept="image/*" 
                       class="w-full text-xs text-stone-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-stone-800 file:text-white hover:file:bg-stone-900">

                <!-- Existing Gallery Photos Management (for Edit) -->
                @if($isEdit && $project->images && $project->images->count() > 0)
                    <div class="pt-3 border-t border-stone-200">
                        <div class="text-xs font-semibold text-stone-700 mb-2">Foto Galeri Tersimpan (Centang kotak merah untuk menghapus):</div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($project->images as $img)
                                <div class="relative rounded-xl overflow-hidden border border-stone-200 group bg-stone-100 p-1">
                                    <img src="{{ $img->image_url }}" alt="Gallery" class="w-full h-24 object-cover rounded-lg">
                                    <label class="mt-1 flex items-center space-x-1.5 text-[11px] text-red-600 font-semibold cursor-pointer">
                                        <input type="checkbox" name="delete_gallery_images[]" value="{{ $img->id }}" class="rounded text-red-600 focus:ring-red-500">
                                        <span>Hapus</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                    Deskripsi Lengkap & Lingkup Pekerjaan <span class="text-red-500">*</span>
                </label>
                <textarea name="description" 
                          rows="6" 
                          required 
                          placeholder="Jelaskan spesifikasi teknis, teknologi modul surya & inverter yang digunakan, tantangan konstruksi, serta manfaat efisiensi listrik bagi fasilitas klien..." 
                          class="w-full px-4 py-3 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-brown-500 focus:border-brown-500 leading-relaxed">{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-stone-200 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.projects.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-700 hover:bg-stone-50 font-semibold text-sm transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brown-500 hover:bg-brown-600 text-white font-bold text-sm shadow-md transition">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Proyek Baru' }}
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
