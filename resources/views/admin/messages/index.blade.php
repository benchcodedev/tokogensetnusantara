@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('header_title', 'Kotak Pesan & Konsultasi Klien')

@section('content')

<div class="space-y-6">
    
    <!-- TOOLBAR & FILTERS -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-stone-200 shadow-sm">
        
        <!-- Filter Tabs -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.messages.index', ['status' => 'all', 'search' => request('search')]) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition {{ ($filter === 'all' || !$filter) ? 'bg-brown-500 text-white shadow-md' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                Semua Pesan
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread', 'search' => request('search')]) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center space-x-1.5 {{ $filter === 'unread' ? 'bg-amber-500 text-stone-900 shadow-md font-bold' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                <span>Belum Dibaca</span>
                @if($unreadCount > 0)
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full bg-red-600 text-white font-bold">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read', 'search' => request('search')]) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition {{ $filter === 'read' ? 'bg-stone-800 text-white shadow-md' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                Sudah Dibaca
            </a>
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('admin.messages.index') }}" class="w-full sm:w-72 relative">
            <input type="hidden" name="status" value="{{ $filter }}">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari pengirim, email, isi..." 
                   class="w-full pl-9 pr-4 py-2 rounded-xl text-xs sm:text-sm border border-stone-300 focus:outline-none focus:ring-2 focus:ring-brown-500 bg-stone-50">
            <svg class="w-4 h-4 text-stone-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </form>

    </div>

    <!-- MESSAGES LIST -->
    <div class="space-y-4">
        @forelse($messages as $msg)
            <div class="bg-white rounded-2xl border {{ !$msg->is_read ? 'border-amber-400 shadow-md bg-amber-50/10' : 'border-stone-200 shadow-sm' }} p-6 transition-all duration-200 hover:border-brown-400">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 pb-3 border-b border-stone-100">
                    <div class="flex items-center space-x-3">
                        @if(!$msg->is_read)
                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-500 text-stone-900 uppercase">
                                Baru
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-stone-100 text-stone-500">
                                Dibaca
                            </span>
                        @endif
                        <h3 class="font-extrabold text-stone-900 text-base">{{ $msg->name }}</h3>
                        @if($msg->company)
                            <span class="text-xs text-stone-500 font-medium">&bull; {{ $msg->company }}</span>
                        @endif
                    </div>
                    
                    <div class="text-xs text-stone-400">
                        {{ $msg->created_at->format('d M Y, H:i') }} ({{ $msg->created_at->diffForHumans() }})
                    </div>
                </div>

                <!-- Contact Meta -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs text-stone-600 my-3">
                    <div class="flex items-center space-x-1.5 truncate">
                        <svg class="w-3.5 h-3.5 text-stone-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $msg->email }}" class="hover:text-brown-600 truncate">{{ $msg->email }}</a>
                    </div>
                    @if($msg->phone)
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-stone-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $msg->phone }}</span>
                        </div>
                    @endif
                    @if($msg->service)
                        <div class="flex items-center space-x-1.5">
                            <span class="text-stone-400">Minat:</span>
                            <span class="font-semibold text-brown-600">{{ $msg->service }}</span>
                        </div>
                    @endif
                </div>

                <!-- Subject & Message Body -->
                <div class="bg-stone-50 p-4 rounded-xl text-stone-700 text-xs sm:text-sm leading-relaxed border border-stone-100 space-y-1">
                    @if($msg->subject)
                        <div class="font-bold text-stone-900 text-xs uppercase tracking-wider text-brown-600 mb-1">
                            Subjek: {{ $msg->subject }}
                        </div>
                    @endif
                    <p class="whitespace-pre-line">{{ $msg->message }}</p>
                </div>

                <!-- Actions -->
                <div class="mt-4 pt-3 border-t border-stone-100 flex flex-wrap items-center justify-between gap-2 text-xs">
                    
                    <!-- Toggle Read Action -->
                    <form action="{{ route('admin.messages.toggle', $msg->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="font-semibold text-stone-600 hover:text-brown-600 inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $msg->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}</span>
                        </button>
                    </form>

                    <div class="flex items-center space-x-3">
                        <!-- Direct WhatsApp reply if phone exists -->
                        @if($msg->phone)
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $msg->phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20Bapak%2FIbu%20{{ urlencode($msg->name) }},%20kami%20dari%20PT%20Surya%20Karya%20Energi%20menindaklanjuti%20pesan%20konsultasi%20Anda." 
                               target="_blank" 
                               class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center transition shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 0C5.401 0 0 5.401 0 12.04c0 2.12.553 4.19 1.606 6.012L0 24.08l6.19-1.624c1.765.962 3.76 1.47 5.85 1.47 6.638 0 12.04-5.402 12.04-12.04C24.08 5.4 18.678 0 12.04 0z"/></svg>
                                <span>Balas via WhatsApp</span>
                            </a>
                        @endif

                        <!-- Direct Email Reply -->
                        <a href="mailto:{{ $msg->email }}?subject=Tanggapan%20PT%20Surya%20Karya%20Energi%20-%20{{ urlencode($msg->subject ?? 'Konsultasi PLTS') }}" 
                           class="px-3 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold text-xs inline-flex items-center transition">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>Kirim Email</span>
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-stone-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition" title="Hapus Pesan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-stone-200 p-12 text-center text-stone-400">
                <svg class="w-12 h-12 mx-auto text-stone-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <p class="text-sm font-semibold">Tidak ada pesan masuk.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center pt-4">
        {{ $messages->links() }}
    </div>

</div>

@endsection
