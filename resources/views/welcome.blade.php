@extends('layouts.main')

@section('title', 'Beranda')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-lime-600 text-white">
        <div class="absolute inset-0 bg-gradient-to-r from-lime-800 to-lime-600 opacity-90"></div>
        <div class="container mx-auto px-4 md:px-6 py-16 md:py-24 relative z-10">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Selamat Datang di Website Resmi Desa Pamuruyan</h1>
                <p class="text-lg md:text-xl opacity-90 mb-8">Mewujudkan desa yang mandiri, sejahtera dan berbudaya
                    melalui pelayanan prima dan pemberdayaan masyarakat.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('front.layanan-surat') }}"
                        class="bg-white text-lime-600 hover:bg-lime-50 px-6 py-3 rounded-md font-medium">Layanan
                        Online</a>
                    <a href="{{ route('front.berita.index') }}"
                        class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-lime-600 px-6 py-3 rounded-md font-medium">Berita
                        Terkini</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Berita Terbaru -->
    <section class="py-16 px-4 md:px-8 lg:px-16 bg-white">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Berita Terbaru</h2>
                <a href="{{ route('front.berita.index') }}" class="text-lime-600 hover:text-lime-700 flex items-center">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($beritaTerbaru as $berita)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <a href="{{ route('front.berita.detail', $berita->slug) }}">
                            <img src="{{ ImageHelper::getImage($berita->thumbnail, $berita->judul) }}"
                                alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                            <div class="p-5">
                                <div class="flex items-center mb-2">
                                    <span
                                        class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($berita->tanggal_post)->isoFormat('D MMM Y') }}</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span
                                        class="text-xs bg-lime-100 text-lime-600 px-2 py-1 rounded">{{ $berita->kategoriBerita->nama }}</span>
                                </div>
                                <h3 class="text-lg font-semibold mb-2 line-clamp-2">{{ $berita->judul }}</h3>
                                <p class="text-gray-600 mb-4 text-sm line-clamp-3">
                                    {{ Str::limit(strip_tags($berita->isi), 120) }}</p>
                                <a href="{{ route('front.berita.detail', $berita->slug) }}"
                                    class="text-lime-600 hover:text-lime-700 font-medium">Baca Selengkapnya</a>
                            </div>
                        </a>
                    </div>
                    @empty
                        @foreach (range(1, 3) as $i)
                            <div class="mt-2 text-lg text-gray-600 text-center">
                                Informasi berita desa akan segera diperbarui.
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Section 3: Kepengurusan -->
        <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-50">
            <div class="container mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Struktur Kepengurusan Desa</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Kenali para pemimpin dan pengurus desa yang berkomitmen untuk
                        memajukan desa dan melayani masyarakat dengan sepenuh hati.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Kepala Desa -->
                    <div class="text-center">
                        <div
                            class="relative mb-4 mx-auto w-40 h-40 rounded-full overflow-hidden border-4 border-lime-600 shadow-md">
                            <img src="{{ ImageHelper::getImage('images/pengurus/kades.jpg', 'Foto Kepala Desa') }}" alt="Kepala Desa"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold">Budi Santoso</h3>
                        <p class="text-lime-600 font-medium mb-2">Kepala Desa</p>
                        <p class="text-gray-600 text-sm">Masa Jabatan: 2020 - 2026</p>
                    </div>

                    <!-- Sekretaris Desa -->
                    <div class="text-center">
                        <div
                            class="relative mb-4 mx-auto w-40 h-40 rounded-full overflow-hidden border-4 border-lime-500 shadow-md">
                            <img src="{{ ImageHelper::getImage('images/pengurus/sekdes.jpg', 'Foto Sekretaris Desa') }}" alt="Sekretaris Desa"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold">Siti Aminah</h3>
                        <p class="text-lime-600 font-medium mb-2">Sekretaris Desa</p>
                        <p class="text-gray-600 text-sm">Masa Jabatan: 2020 - 2026</p>
                    </div>

                    <!-- Bendahara Desa -->
                    <div class="text-center">
                        <div
                            class="relative mb-4 mx-auto w-40 h-40 rounded-full overflow-hidden border-4 border-lime-500 shadow-md">
                            <img src="{{ ImageHelper::getImage('images/pengurus/bendahara.jpg', 'Foto Bendahara Desa') }}" alt="Bendahara Desa"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold">Agus Wijaya</h3>
                        <p class="text-lime-600 font-medium mb-2">Bendahara Desa</p>
                        <p class="text-gray-600 text-sm">Masa Jabatan: 2020 - 2026</p>
                    </div>

                    <!-- Kaur Perencanaan -->
                    <div class="text-center">
                        <div
                            class="relative mb-4 mx-auto w-40 h-40 rounded-full overflow-hidden border-4 border-lime-500 shadow-md">
                            <img src="{{ ImageHelper::getImage('images/pengurus/kaur.jpg', 'Foto Kaur Perencanaan') }}" alt="Kaur Perencanaan"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold">Dewi Lestari</h3>
                        <p class="text-lime-600 font-medium mb-2">Kaur Perencanaan</p>
                        <p class="text-gray-600 text-sm">Masa Jabatan: 2020 - 2026</p>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('front.kepengurusan') }}"
                        class="inline-block px-6 py-3 rounded-lg bg-lime-600 text-white hover:bg-lime-700 transition">
                        Lihat Struktur Lengkap
                    </a>
                </div>
            </div>
        </section>

        <!-- Section 4: Visi Misi -->
        <section class="py-16 px-4 md:px-8 lg:px-16 bg-lime-600 text-white">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-6">Visi & Misi Desa</h2>

                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-3">Visi</h3>
                            <p class="text-lime-100">"Terwujudnya Desa yang Mandiri, Sejahtera, dan Berkeadilan dengan
                                Berlandaskan Nilai Kearifan Lokal"</p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold mb-3">Misi</h3>
                            <ul class="space-y-2 text-lime-100">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-1 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Meningkatkan kualitas pelayanan publik dan tata kelola pemerintahan desa yang
                                        transparan dan akuntabel</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-1 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Mengembangkan ekonomi kerakyatan berbasis potensi lokal untuk meningkatkan
                                        kesejahteraan masyarakat</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-1 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Membangun infrastruktur desa yang memadai untuk mendukung aktivitas ekonomi dan sosial
                                        masyarakat</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-1 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Meningkatkan kualitas pendidikan dan kesehatan masyarakat desa</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-1 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Melestarikan dan mengembangkan nilai-nilai budaya dan kearifan lokal</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        <img src="{{ ImageHelper::getImage('images/visi-misi.svg', 'Ilustrasi Visi Misi') }}" alt="Visi Misi" class="w-full max-w-md mx-auto">
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 5: Jadwal & Pelayanan -->
        <section class="py-16 px-4 md:px-8 lg:px-16 bg-white">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Jadwal Kegiatan -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Jadwal Kegiatan Desa</h2>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <ul class="divide-y divide-gray-200">
                                @forelse($jadwalKegiatan as $jadwal)
                                    <li class="py-4 first:pt-0 last:pb-0">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-lime-100 text-lime-600 rounded-lg p-3 text-center">
                                                <span
                                                    class="block font-bold text-lg">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('d') }}</span>
                                                <span
                                                    class="text-xs uppercase">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('M Y') }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-lg font-semibold text-gray-800">{{ $jadwal->nama_kegiatan }}
                                                </h4>
                                                <div class="flex items-center text-gray-500 text-sm mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB
                                                </div>
                                                <div class="flex items-center text-gray-500 text-sm mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $jadwal->lokasi }}
                                                </div>
                                                <div class="mt-2 text-sm text-gray-600">
                                                    {{ Str::limit($jadwal->deskripsi, 100) }}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    @foreach (range(1, 3) as $i)
                                        <div class="mt-2 text-lg text-gray-600 text-center">
                                            Informasi kegiatan desa akan segera diperbarui.
                                        </div>
                                    @endforeach
                                @endforelse
                            </ul>
                            <div class="mt-6 text-center">
                                <a href="{{ route('front.jadwal-kegiatan') }}"
                                    class="inline-block px-4 py-2 bg-lime-600 text-white rounded hover:bg-lime-700 transition">Lihat
                                    Semua Jadwal</a>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Desa -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Layanan Surat Desa</h2>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <p class="text-gray-600 mb-6">Berikut adalah beberapa layanan surat yang dapat diurus di kantor
                                desa. Silakan datang dengan membawa persyaratan yang dibutuhkan.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse ($layananSurat as $layanan)
                                    <div class="p-4 rounded-md bg-lime-50 border border-lime-100">
                                        <div class="flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-lime-600 mr-2"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h4 class="font-medium text-gray-800">{{ $layanan->nama }}</h4>
                                        </div>
                                        <p class="text-sm text-gray-600">Waktu proses: 1-2 hari kerja</p>
                                    </div>
                                @empty
                                    <div class="mt-2 text-lg text-gray-600 text-center">
                                        Informasi layanan surat desa akan segera diperbarui.
                                    </div>
                                @endforelse
                            </div>

                            <div class="mt-6 text-center">
                                <a href="{{ route('front.layanan-surat') }}"
                                    class="inline-block px-4 py-2 bg-lime-600 text-white rounded hover:bg-lime-700 transition">Lihat
                                    Semua Layanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 6: APBDes Singkat -->
        <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-50">
            <div class="container mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Transparansi APBDes {{ date('Y') }}</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Informasi ringkas mengenai Anggaran Pendapatan dan Belanja Desa
                        sebagai bentuk transparansi dan akuntabilitas kepada masyarakat.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Pendapatan -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full bg-green-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Pendapatan</h3>
                        </div>
                        <p class="text-green-600 text-2xl font-bold mb-2">Rp
                            {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        <div class="mt-4">
                            @if (isset($sumberPendapatan))
                                @foreach ($sumberPendapatan as $sumber => $nominal)
                                    <div class="flex justify-between items-center mb-2 text-sm">
                                        <span class="text-gray-600">{{ $sumber }}</span>
                                        <span class="text-gray-800 font-medium">Rp
                                            {{ number_format($nominal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center mb-2 text-md">
                                    <span class="text-gray-600">Informasi pendapatan akan segera diperbarui.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Belanja -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full bg-red-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Belanja</h3>
                        </div>
                        <p class="text-red-600 text-2xl font-bold mb-2">Rp
                            {{ number_format($totalBelanja, 0, ',', '.') }}</p>
                        <div class="mt-4">
                            @if (isset($jenisbelanja))
                                @foreach ($jenisBelanja as $jenis => $nominal)
                                    <div class="flex justify-between items-center mb-2 text-sm">
                                        <span class="text-gray-600">{{ $jenis }}</span>
                                        <span class="text-gray-800 font-medium">Rp
                                            {{ number_format($nominal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center mb-2 text-md">
                                    <span class="text-gray-600">Informasi belenja akan segera diperbarui.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pembiayaan -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full bg-lime-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-lime-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Pembiayaan</h3>
                        </div>
                        <p class="text-lime-600 text-2xl font-bold mb-2">Rp
                            {{ number_format($totalPembiayaan, 0, ',', '.') }}</p>
                        <div class="mt-4">
                            @if (isset($jenisPembiayaan))
                                @foreach ($jenisPembiayaan as $jenis => $nominal)
                                    <div class="flex justify-between items-center mb-2 text-sm">
                                        <span class="text-gray-600">{{ $jenis }}</span>
                                        <span class="text-gray-800 font-medium">Rp
                                            {{ number_format($nominal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center mb-2 text-md">
                                    <span class="text-gray-600">Informasi pembiayaan akan segera diperbarui.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-gray-600 mb-4">Berdasarkan Peraturan Desa Nomor 01 Tahun {{ date('Y') }} tentang APBDes
                    </p>
                    <a href="{{ route('front.apbdes') }}"
                        class="inline-block px-6 py-3 rounded-lg bg-lime-600 text-white hover:bg-lime-700 transition">Lihat
                        Detail APBDes</a>
                </div>
            </div>
        </section>
    @endsection
