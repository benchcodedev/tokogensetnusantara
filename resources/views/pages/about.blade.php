@extends('layouts.app')

@section('title', 'Tentang Kami — Abadi Jaya Furniture Jakarta')
@section('meta_description', 'Cerita perjalanan Abadi Jaya Furniture sebagai kontraktor interior & custom furniture bergaya luxury di Jakarta dengan pengalaman lebih dari 12 tahun.')

@section('content')

<!-- Header Banner -->
<section class="bg-[#14100A] text-[#F6EFE0] py-20 lg:py-24 border-b border-[#B58A12]/30 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-xs uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block mb-3">
            Dedikasi & Filosofi
        </span>
        <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-light tracking-tight text-white mb-6">
            Tentang Abadi Jaya Furniture
        </h1>
        <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mb-6"></div>
        <p class="text-sm sm:text-base text-[#F6EFE0]/80 font-light max-w-2xl mx-auto leading-relaxed">
            Perpaduan seni kriya kayu tradisional dengan teknologi arsitektur modern untuk menciptakan ruang hidup yang anggun dan abadi.
        </p>
    </div>
</section>

<!-- Company Story -->
<section class="py-20 lg:py-28 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <div class="space-y-6">
                <span class="text-xs uppercase tracking-[0.25em] text-[#B58A12] font-semibold block">
                    Kisah Kami
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-light text-[#1A1308] leading-tight">
                    Membangun Standar Baru Kemewahan Interior di Jakarta
                </h2>
                <div class="w-16 h-0.5 bg-[#B58A12]"></div>
                <div class="text-sm sm:text-base text-[#1A1308]/75 leading-relaxed font-light space-y-4">
                    <p>
                        Berawal dari kecintaan mendalam terhadap keindahan kriya kayu dan arsitektur klasik, <strong>Abadi Jaya Furniture</strong> (Instagram: <em>@abadijaya.id</em>) telah bertransformasi menjadi salah satu kontraktor interior custom luxury terkemuka di Jakarta.
                    </p>
                    <p>
                        Selama lebih dari 12 tahun, kami telah dipercaya menyelesaikan lebih dari 350 proyek bergengsi — mulai dari rumah tinggal megah di Bukit Golf Pondok Indah, penthouse di Senopati, villa tropis modern di PIK 2, hingga kantor direksi di SCBD Sudirman.
                    </p>
                    <p>
                        Bagi kami, furniture custom bukan sekadar pengisi ruang, melainkan cerminan identitas dan warisan keanggunan pemiliknya. Itulah mengapa kami mengelola workshop produksi mandiri untuk memastikan setiap sambungan kayu, profil moulding, dan kilau marmer mencapai presisi milimeter.
                    </p>
                </div>

                <div class="pt-4 flex items-center space-x-6">
                    <div>
                        <span class="font-heading text-3xl font-light text-[#B58A12]">12+</span>
                        <span class="block text-xs text-gray-500 uppercase tracking-wider">Tahun Pengalaman</span>
                    </div>
                    <div class="w-px h-10 bg-gray-300"></div>
                    <div>
                        <span class="font-heading text-3xl font-light text-[#B58A12]">350+</span>
                        <span class="block text-xs text-gray-500 uppercase tracking-wider">Proyek Selesai</span>
                    </div>
                    <div class="w-px h-10 bg-gray-300"></div>
                    <div>
                        <span class="font-heading text-3xl font-light text-[#B58A12]">3</span>
                        <span class="block text-xs text-gray-500 uppercase tracking-wider">Showroom Jakarta</span>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="relative rounded-md overflow-hidden aspect-[4/3] shadow-2xl border-4 border-white">
                    <img 
                        src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80" 
                        alt="Workshop & Craftsmanship Abadi Jaya Furniture" 
                        class="w-full h-full object-cover"
                    />
                </div>
                <!-- Small Inset Floating Badge -->
                <div class="absolute -bottom-6 -left-6 bg-[#14100A] text-white p-6 rounded-md shadow-2xl border border-[#B58A12]/40 hidden sm:block max-w-xs">
                    <p class="font-logo text-lg text-[#C9A24B]">"Keanggunan yang Abadi"</p>
                    <p class="text-xs text-white/80 font-light mt-1">Pengerjaan dengan integritas dan material grade A.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Our 4 Core Values -->
<section class="py-20 lg:py-24 bg-[#14100A] text-[#F6EFE0] border-t border-[#B58A12]/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block mb-2">
                Pilar Keunggulan
            </span>
            <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-light text-white tracking-tight">
                Nilai-Nilai Fundamental Kami
            </h2>
            <div class="w-16 h-0.5 bg-[#C9A24B] mx-auto mt-4 mb-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <div class="bg-[#1A1308] p-8 rounded-md border border-[#B58A12]/30 hover:border-[#C9A24B] transition">
                <div class="w-12 h-12 rounded-full bg-[#B58A12]/20 flex items-center justify-center text-[#C9A24B] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-heading text-2xl font-normal text-white mb-2">Material Grade A</h3>
                <p class="text-xs sm:text-sm text-[#F6EFE0]/75 font-light leading-relaxed">
                    Hanya menggunakan kayu olahan Meranti oven bebas rayap, marmer slab asli, dan hardware bersertifikasi internasional (Blum & Hafele).
                </p>
            </div>

            <div class="bg-[#1A1308] p-8 rounded-md border border-[#B58A12]/30 hover:border-[#C9A24B] transition">
                <div class="w-12 h-12 rounded-full bg-[#B58A12]/20 flex items-center justify-center text-[#C9A24B] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                </div>
                <h3 class="font-heading text-2xl font-normal text-white mb-2">Presisi Milimeter</h3>
                <p class="text-xs sm:text-sm text-[#F6EFE0]/75 font-light leading-relaxed">
                    Setiap potongan dan sudut profil diproduksi dengan toleransi presisi tinggi agar menghasilkan sambungan yang mulus dan kokoh.
                </p>
            </div>

            <div class="bg-[#1A1308] p-8 rounded-md border border-[#B58A12]/30 hover:border-[#C9A24B] transition">
                <div class="w-12 h-12 rounded-full bg-[#B58A12]/20 flex items-center justify-center text-[#C9A24B] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="font-heading text-2xl font-normal text-white mb-2">Workshop Mandiri</h3>
                <p class="text-xs sm:text-sm text-[#F6EFE0]/75 font-light leading-relaxed">
                    Kami bukan perantara. Seluruh tahapan pengerjaan diawasi langsung di bengkel workshop mandiri kami dengan standar QC berlapis.
                </p>
            </div>

            <div class="bg-[#1A1308] p-8 rounded-md border border-[#B58A12]/30 hover:border-[#C9A24B] transition">
                <div class="w-12 h-12 rounded-full bg-[#B58A12]/20 flex items-center justify-center text-[#C9A24B] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-heading text-2xl font-normal text-white mb-2">Garansi Purna Jual</h3>
                <p class="text-xs sm:text-sm text-[#F6EFE0]/75 font-light leading-relaxed">
                    Perlindungan garansi resmi konstruksi hingga 3 tahun dan respon teknisi sigap untuk memberikan rasa tenang jangka panjang.
                </p>
            </div>

        </div>

    </div>
</section>

<!-- Material Partners & Coverage Area -->
<section class="py-20 lg:py-24 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Materials & Partners -->
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-[#B58A12] font-semibold block mb-2">
                    Kemitraan Terpercaya
                </span>
                <h3 class="font-heading text-3xl font-light text-[#1A1308] mb-6">
                    Material & Komponen Kelas Dunia
                </h3>
                <p class="text-sm text-gray-600 font-light leading-relaxed mb-6">
                    Kami bermitra dengan merek-merek ternama dunia untuk memastikan setiap engsel, lembaran laminasi, cat, dan marmer memiliki daya tahan puluhan tahun:
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-center">
                    <div class="p-4 rounded-md border border-gray-100 bg-gray-50 flex items-center justify-center font-heading text-lg font-semibold text-gray-800">
                        BLUM Jerman
                    </div>
                    <div class="p-4 rounded-md border border-gray-100 bg-gray-50 flex items-center justify-center font-heading text-lg font-semibold text-gray-800">
                        HÃ„FELE
                    </div>
                    <div class="p-4 rounded-md border border-gray-100 bg-gray-50 flex items-center justify-center font-heading text-lg font-semibold text-gray-800">
                        CARTA Laminates
                    </div>
                    <div class="p-4 rounded-md border border-gray-100 bg-gray-50 flex items-center justify-center font-heading text-lg font-semibold text-gray-800">
                        LAMITAK
                    </div>
                    <div class="p-4 rounded-md border border-gray-100 bg-gray-50 flex items-center justify-center font-heading text-lg font-semibold text-gray-800">
                        Italian Marble
                    </div>
                    <div class="p-4 rounded-md border border-gray-100 bg-gray-50 flex items-center justify-center font-heading text-lg font-semibold text-gray-800">
                        PU Paint Auto
                    </div>
                </div>
            </div>

            <!-- Service Area -->
            <div class="bg-[#FAF7F2] p-8 sm:p-10 rounded-md border border-[#B58A12]/30">
                <span class="text-xs uppercase tracking-[0.25em] text-[#B58A12] font-semibold block mb-2">
                    Jangkauan Layanan
                </span>
                <h3 class="font-heading text-3xl font-light text-[#1A1308] mb-4">
                    Area Cakupan Proyek
                </h3>
                <p class="text-sm text-[#1A1308]/75 font-light leading-relaxed mb-6">
                    Fokus utama pengerjaan kami meliputi seluruh wilayah Jabodetabek, dengan proyek khusus residensial dan villa di kota-kota besar Indonesia:
                </p>
                <div class="grid grid-cols-2 gap-3 text-xs sm:text-sm text-[#1A1308]/85 font-medium">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#B58A12]"></span>
                        <span>Jakarta Selatan (PIM, Senopati, Dharmawangsa)</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#B58A12]"></span>
                        <span>Jakarta Utara (PIK, PIK 2, Kelapa Gading)</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#B58A12]"></span>
                        <span>Jakarta Pusat (Menteng, Thamrin, Sudirman)</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#B58A12]"></span>
                        <span>Jakarta Barat & Tangerang (Puri, BSD City, Alam Sutera)</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#B58A12]"></span>
                        <span>Surabaya & Jawa Timur</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-[#B58A12]"></span>
                        <span>Bali (Villa & Resort Projects)</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection
