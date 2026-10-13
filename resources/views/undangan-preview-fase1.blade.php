<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan - {{ $event->nama_mempelai_pria }} & {{ $event->nama_mempelai_wanita }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center border border-stone-200">
        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full mb-4">
            Undangan Pernikahan Digital
        </span>
        <h1 class="text-3xl font-serif text-stone-800 mb-2">
            {{ $event->nama_mempelai_pria }} & {{ $event->nama_mempelai_wanita }}
        </h1>
        <div class="my-6 p-4 bg-stone-50 rounded-xl border border-dashed border-stone-300">
            <p class="text-xs uppercase tracking-wider text-stone-500 mb-1">Kepada Yth.</p>
            <p class="text-xl font-bold text-stone-800">{{ $guest->nama }}</p>
            <p class="text-sm text-stone-600 mt-1">Alokasi: <span class="font-semibold">{{ $guest->pax }} Tamu</span></p>
            @if($guest->kategori)
                <span class="inline-block mt-2 px-2.5 py-0.5 text-xs bg-stone-200 text-stone-700 rounded-md">
                    {{ $guest->kategori }}
                </span>
            @endif
        </div>
        <p class="text-xs text-stone-400">
            Halaman publik interaktif lengkap akan diimplementasikan pada FASE 2.
        </p>
    </div>
</body>
</html>
