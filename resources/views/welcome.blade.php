@extends('layouts.main')

@section('title', 'Beranda')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')
    <!-- Hero Section -->
    <section class="relative text-white bg-lime-600">
        <div class="absolute inset-0 bg-gradient-to-r from-lime-800 to-lime-600 opacity-90"></div>
        <div class="container relative z-10 px-4 py-16 mx-auto md:px-6 md:py-24">
            <div class="max-w-2xl">
                <h1 class="mb-4 text-3xl font-bold md:text-4xl">Selamat Datang di Website Resmi Desa Pamuruyan</h1>
                <p class="mb-8 text-lg opacity-90 md:text-xl">Mewujudkan desa yang mandiri, sejahtera dan berbudaya
                    melalui pelayanan prima dan pemberdayaan masyarakat.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('front.layanan-surat') }}"
                        class="px-6 py-3 font-medium text-lime-600 bg-white rounded-md hover:bg-lime-50">Layanan
                        Online</a>
                    <a href="{{ route('front.berita.index') }}"
                        class="px-6 py-3 font-medium text-white bg-transparent rounded-md border-2 border-white hover:bg-white hover:text-lime-600">Berita
                        Terkini</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Berita Terbaru -->
    <section class="px-4 py-16 bg-white md:px-8 lg:px-16">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 md:text-3xl">Berita Terbaru</h2>
                <a href="{{ route('front.berita.index') }}" class="flex items-center text-lime-600 hover:text-lime-700">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($beritaTerbaru as $berita)
                    <div
                        class="overflow-hidden bg-white rounded-lg shadow-md transition-shadow duration-300 hover:shadow-xl">
                        <a href="{{ route('front.berita.detail', $berita->slug) }}">
                            <img src="{{ ImageHelper::getImage($berita->thumbnail, $berita->judul) }}"
                                alt="{{ $berita->judul }}" class="object-cover w-full h-48">
                            <div class="p-5">
                                <div class="flex items-center mb-2">
                                    <span
                                        class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($berita->tanggal_post)->isoFormat('D MMM Y') }}</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span
                                        class="px-2 py-1 text-xs text-lime-600 bg-lime-100 rounded">{{ $berita->kategoriBerita->nama }}</span>
                                </div>
                                <h3 class="mb-2 text-lg font-semibold line-clamp-2">{{ $berita->judul }}</h3>
                                <p class="mb-4 text-sm text-gray-600 line-clamp-3">
                                    {{ Str::limit(strip_tags($berita->isi), 120) }}</p>
                                <a href="{{ route('front.berita.detail', $berita->slug) }}"
                                    class="font-medium text-lime-600 hover:text-lime-700">Baca Selengkapnya</a>
                            </div>
                        </a>
                    </div>
                @empty
                    @foreach (range(1, 3) as $i)
                        <div class="mt-2 text-lg text-center text-gray-600">
                            Informasi berita desa akan segera diperbarui.
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section 3: Kepengurusan -->
    <section class="px-4 py-16 bg-gray-50 md:px-8 lg:px-16">
        <div class="container mx-auto">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-2xl font-bold text-gray-800 md:text-3xl">Struktur Kepengurusan Desa</h2>
                <p class="mx-auto max-w-2xl text-gray-600">Kenali para pemimpin dan pengurus desa yang berkomitmen untuk
                    memajukan desa dan melayani masyarakat dengan sepenuh hati.</p>
            </div>

            <!-- Kepala Desa -->
            @if($kepalaDesa)
            <div class="mb-12">
                <h3 class="mb-6 text-xl font-semibold text-center text-lime-700">Kepala Desa</h3>
                <div class="flex justify-center">
                    <div class="text-center w-64">
                        <div class="overflow-hidden relative mx-auto mb-4 w-40 h-40 rounded-full border-4 border-lime-600 shadow-md">
                            <img src="{{ ImageHelper::getImage($kepalaDesa->foto, 'Foto Kepala Desa') }}"
                                alt="Foto {{ $kepalaDesa->nama }}" class="object-cover w-full h-full">
                        </div>
                        <h3 class="text-xl font-semibold">{{ $kepalaDesa->nama }}</h3>
                        <p class="mb-2 font-medium text-lime-600">{{ $kepalaDesa->jabatan }}</p>
                        <p class="text-sm text-gray-600">Masa Jabatan: {{ \Carbon\Carbon::parse($kepalaDesa->masa_jabatan_mulai)->format('Y') }} - {{ \Carbon\Carbon::parse($kepalaDesa->masa_jabatan_selesai)->format('Y') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Sekretariat Desa -->
            @if($sekretariatDesa && $sekretariatDesa->count() > 0)
            <div class="mb-12">
                <h3 class="mb-6 text-xl font-semibold text-center text-lime-700">Sekretariat Desa</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($sekretariatDesa as $pengurus)
                    <div class="text-center">
                        <div class="overflow-hidden relative mx-auto mb-4 w-40 h-40 rounded-full border-4 border-lime-500 shadow-md">
                            <img src="{{ ImageHelper::getImage($pengurus->foto, 'Foto Pengurus') }}"
                                alt="Foto {{ $pengurus->nama }}" class="object-cover w-full h-full">
                        </div>
                        <h3 class="text-xl font-semibold">{{ $pengurus->nama }}</h3>
                        <p class="mb-2 font-medium text-lime-600">{{ $pengurus->jabatan }}</p>
                        <p class="text-sm text-gray-600">Masa Jabatan: {{ \Carbon\Carbon::parse($pengurus->masa_jabatan_mulai)->format('Y') }} - {{ \Carbon\Carbon::parse($pengurus->masa_jabatan_selesai)->format('Y') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Pelaksana Teknis -->
            @if($pelaksanaTeknis && $pelaksanaTeknis->count() > 0)
            <div class="mb-12">
                <h3 class="mb-6 text-xl font-semibold text-center text-lime-700">Pelaksana Teknis</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($pelaksanaTeknis as $pengurus)
                    <div class="text-center">
                        <div class="overflow-hidden relative mx-auto mb-4 w-40 h-40 rounded-full border-4 border-lime-500 shadow-md">
                            <img src="{{ ImageHelper::getImage($pengurus->foto, 'Foto Pengurus') }}"
                                alt="Foto {{ $pengurus->nama }}" class="object-cover w-full h-full">
                        </div>
                        <h3 class="text-xl font-semibold">{{ $pengurus->nama }}</h3>
                        <p class="mb-2 font-medium text-lime-600">{{ $pengurus->jabatan }}</p>
                        <p class="text-sm text-gray-600">Masa Jabatan: {{ \Carbon\Carbon::parse($pengurus->masa_jabatan_mulai)->format('Y') }} - {{ \Carbon\Carbon::parse($pengurus->masa_jabatan_selesai)->format('Y') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Kepala Dusun -->
            @if($kepalaDusun && $kepalaDusun->count() > 0)
            <div class="mb-12">
                <h3 class="mb-6 text-xl font-semibold text-center text-lime-700">Kepala Dusun</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($kepalaDusun as $pengurus)
                    <div class="text-center">
                        <div class="overflow-hidden relative mx-auto mb-4 w-40 h-40 rounded-full border-4 border-lime-500 shadow-md">
                            <img src="{{ ImageHelper::getImage($pengurus->foto, 'Foto Pengurus') }}"
                                alt="Foto {{ $pengurus->nama }}" class="object-cover w-full h-full">
                        </div>
                        <h3 class="text-xl font-semibold">{{ $pengurus->nama }}</h3>
                        <p class="mb-2 font-medium text-lime-600">{{ $pengurus->jabatan }}</p>
                        <p class="text-sm text-gray-600">Masa Jabatan: {{ \Carbon\Carbon::parse($pengurus->masa_jabatan_mulai)->format('Y') }} - {{ \Carbon\Carbon::parse($pengurus->masa_jabatan_selesai)->format('Y') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Section 4: Visi Misi -->
    <section class="px-4 py-16 text-white bg-lime-600 md:px-8 lg:px-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 gap-12 items-center lg:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-2xl font-bold md:text-3xl">Visi & Misi Desa</h2>
                    @if ($visiMisi)
                        <div class="mb-8">
                            <h3 class="mb-3 text-xl font-semibold">Visi</h3>
                            <p class="text-lime-100">{{ $visiMisi->visi }}</p>
                        </div>

                        <div>
                            <h3 class="mb-3 text-xl font-semibold">Misi</h3>
                            <ul class="space-y-2 text-lime-100">
                                @foreach ($visiMisi->misi as $index => $item)
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mt-1 mr-2 w-5 h-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $item['misi_item'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="mb-8">
                            <p class="text-lime-100">Data visi & misi belum tersedia.</p>
                        </div>
                    @endif
                </div>

                <div class="hidden lg:block">
                    <img src="{{ ImageHelper::getImage($visiMisi->gambar, 'Ilustrasi Visi Misi') }}" alt="Visi Misi"
                        class="mx-auto w-full max-w-md">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Jadwal & Pelayanan -->
    <section class="px-4 py-16 bg-white md:px-8 lg:px-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                <!-- Jadwal Kegiatan -->
                <div>
                    <h2 class="mb-6 text-2xl font-bold text-gray-800">Jadwal Kegiatan Desa</h2>
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <ul class="divide-y divide-gray-200">
                            @forelse($jadwalKegiatan as $jadwal)
                                <li class="py-4 first:pt-0 last:pb-0">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 p-3 text-center text-lime-600 bg-lime-100 rounded-lg">
                                            <span
                                                class="block text-lg font-bold">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('d') }}</span>
                                            <span
                                                class="text-xs uppercase">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('M Y') }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $jadwal->nama_kegiatan }}
                                            </h4>
                                            <div class="flex items-center mt-1 text-sm text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB
                                            </div>
                                            <div class="flex items-center mt-1 text-sm text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4"
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
                                    <div class="mt-2 text-lg text-center text-gray-600">
                                        Informasi kegiatan desa akan segera diperbarui.
                                    </div>
                                @endforeach
                            @endforelse
                        </ul>
                        <div class="mt-6 text-center">
                            <a href="{{ route('front.jadwal-kegiatan') }}"
                                class="inline-block px-4 py-2 text-white bg-lime-600 rounded transition hover:bg-lime-700">Lihat
                                Semua Jadwal</a>
                        </div>
                    </div>
                </div>

                <!-- Layanan Desa -->
                <div>
                    <h2 class="mb-6 text-2xl font-bold text-gray-800">Layanan Surat Desa</h2>
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <p class="mb-6 text-gray-600">Berikut adalah beberapa layanan surat yang dapat diurus di kantor
                            desa. Silakan datang dengan membawa persyaratan yang dibutuhkan.</p>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @forelse ($layananSurat as $layanan)
                                <div class="p-4 bg-lime-50 rounded-md border border-lime-100">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5 text-lime-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h4 class="font-medium text-gray-800">{{ $layanan->nama }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Waktu proses: 1-2 hari kerja</p>
                                </div>
                            @empty
                                <div class="mt-2 text-lg text-center text-gray-600">
                                    Informasi layanan surat desa akan segera diperbarui.
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('front.layanan-surat') }}"
                                class="inline-block px-4 py-2 text-white bg-lime-600 rounded transition hover:bg-lime-700">Lihat
                                Semua Layanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: APBDes Singkat -->
    <section class="px-4 py-16 bg-gray-50 md:px-8 lg:px-16">
        <div class="container mx-auto">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-2xl font-bold text-gray-800 md:text-3xl">Transparansi APBDes {{ date('Y') }}</h2>
                <p class="mx-auto max-w-2xl text-gray-600">Informasi ringkas mengenai Anggaran Pendapatan dan Belanja Desa
                    sebagai bentuk transparansi dan akuntabilitas kepada masyarakat.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Pendapatan -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="p-3 mr-4 bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Pendapatan</h3>
                    </div>
                    <p class="mb-2 text-2xl font-bold text-green-600">Rp
                        {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <div class="mt-4">
                        @if (isset($sumberPendapatan))
                            @foreach ($sumberPendapatan as $sumber => $nominal)
                                <div class="flex justify-between items-center mb-2 text-sm">
                                    <span class="text-gray-600">{{ $sumber }}</span>
                                    <span class="font-medium text-gray-800">Rp
                                        {{ number_format($nominal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2 text-center text-md">
                                <span class="text-gray-600">Informasi pendapatan akan segera diperbarui.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Belanja -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="p-3 mr-4 bg-red-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Belanja</h3>
                    </div>
                    <p class="mb-2 text-2xl font-bold text-red-600">Rp
                        {{ number_format($totalBelanja, 0, ',', '.') }}</p>
                    <div class="mt-4">
                        @if (isset($jenisbelanja))
                            @foreach ($jenisBelanja as $jenis => $nominal)
                                <div class="flex justify-between items-center mb-2 text-sm">
                                    <span class="text-gray-600">{{ $jenis }}</span>
                                    <span class="font-medium text-gray-800">Rp
                                        {{ number_format($nominal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2 text-center text-md">
                                <span class="text-gray-600">Informasi belenja akan segera diperbarui.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pembiayaan -->
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="p-3 mr-4 bg-lime-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Pembiayaan</h3>
                    </div>
                    <p class="mb-2 text-2xl font-bold text-lime-600">Rp
                        {{ number_format($totalPembiayaan, 0, ',', '.') }}</p>
                    <div class="mt-4">
                        @if (isset($jenisPembiayaan))
                            @foreach ($jenisPembiayaan as $jenis => $nominal)
                                <div class="flex justify-between items-center mb-2 text-sm">
                                    <span class="text-gray-600">{{ $jenis }}</span>
                                    <span class="font-medium text-gray-800">Rp
                                        {{ number_format($nominal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2 text-center text-md">
                                <span class="text-gray-600">Informasi pembiayaan akan segera diperbarui.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('front.apbdes') }}"
                    class="inline-block px-6 py-3 text-white bg-lime-600 rounded-lg transition hover:bg-lime-700">Lihat
                    Detail APBDes</a>
            </div>
        </div>
    </section>
@endsection
