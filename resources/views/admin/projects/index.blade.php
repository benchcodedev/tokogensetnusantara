@extends('layouts.admin')

@section('title', 'Kelola Proyek')
@section('header_title', 'Daftar Portofolio Proyek')

@section('content')

<div class="space-y-6">
    
    <!-- TOP TOOLBAR -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-sm">
        
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.projects.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari judul, klien, lokasi..." 
                   class="px-3.5 py-2 rounded-xl text-xs sm:text-sm border border-stone-300 focus:outline-none focus:ring-2 focus:ring-brown-500 bg-stone-50 w-full sm:w-64">

            <select name="category" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl text-xs sm:text-sm border border-stone-300 focus:outline-none focus:ring-2 focus:ring-brown-500 bg-stone-50">
                <option value="all">Semua Kategori</option>
                <option value="PLTS / Solar" {{ request('category') === 'PLTS / Solar' ? 'selected' : '' }}>PLTS / Solar</option>
                <option value="BESS / Storage" {{ request('category') === 'BESS / Storage' ? 'selected' : '' }}>BESS / Storage</option>
                <option value="Infrastruktur & Substation" {{ request('category') === 'Infrastruktur & Substation' ? 'selected' : '' }}>Infrastruktur & Substation</option>
                <option value="O&M / Asset Management" {{ request('category') === 'O&M / Asset Management' ? 'selected' : '' }}>O&M / Asset Management</option>
            </select>

            @if(request('search') || request('category'))
                <a href="{{ route('admin.projects.index') }}" class="text-xs text-stone-500 hover:text-stone-700 underline">Reset</a>
            @endif
        </form>

        <!-- Add Button -->
        <a href="{{ route('admin.projects.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-brown-500 hover:bg-brown-600 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shrink-0">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Proyek Baru</span>
        </a>

    </div>

    <!-- PROJECTS TABLE -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-stone-50 text-stone-600 border-b border-stone-200">
                    <tr>
                        <th class="py-3.5 px-4 font-bold">Proyek & Klien</th>
                        <th class="py-3.5 px-4 font-bold">Kategori</th>
                        <th class="py-3.5 px-4 font-bold">Kapasitas</th>
                        <th class="py-3.5 px-4 font-bold">Lokasi / Tahun</th>
                        <th class="py-3.5 px-4 font-bold">Status</th>
                        <th class="py-3.5 px-4 font-bold text-center">Unggulan</th>
                        <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($projects as $p)
                        <tr class="hover:bg-stone-50 transition">
                            <!-- Title & Client -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $p->cover_image }}" alt="{{ $p->title }}" class="w-12 h-12 rounded-xl object-cover bg-stone-100 shrink-0">
                                    <div class="truncate max-w-xs">
                                        <div class="font-bold text-stone-900 truncate">{{ $p->title }}</div>
                                        <div class="text-xs text-stone-500 truncate">{{ $p->client }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="py-3.5 px-4 text-stone-600 font-medium">
                                {{ $p->category }}
                            </td>

                            <!-- Capacity -->
                            <td class="py-3.5 px-4 font-bold text-brown-600">
                                {{ $p->capacity }}
                            </td>

                            <!-- Location & Year -->
                            <td class="py-3.5 px-4 text-stone-500 text-xs">
                                <div>{{ $p->location }}</div>
                                <div class="font-semibold text-stone-700">{{ $p->year }}</div>
                            </td>

                            <!-- Status -->
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $p->status }}
                                </span>
                            </td>

                            <!-- Featured -->
                            <td class="py-3.5 px-4 text-center">
                                @if($p->is_featured)
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-600 font-bold" title="Proyek Unggulan">
                                        &starf;
                                    </span>
                                @else
                                    <span class="text-stone-300">&bull;</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.projects.edit', $p->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xs transition">
                                    Edit
                                </a>
                                <a href="{{ route('projects.show', $p->slug) }}" target="_blank" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-500 font-medium text-xs transition">
                                    Lihat
                                </a>
                                <form action="{{ route('admin.projects.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-400">
                                Tidak ada proyek yang terdaftar dalam database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-4 border-t border-stone-100 flex justify-center">
            {{ $projects->links() }}
        </div>
    </div>

</div>

@endsection
