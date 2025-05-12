@extends('layouts.main')

@section('title', 'Galeri Foto')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css" rel="stylesheet">
    <style>
        .gallery-item {
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.02);
        }

        .gallery-container {
            columns: 1;
            column-gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .gallery-container {
                columns: 2;
            }
        }

        @media (min-width: 1024px) {
            .gallery-container {
                columns: 3;
            }
        }

        .tab-active {
            color: rgb(63 98 18);
            border-color: rgb(63 98 18);
        }
    </style>
@endpush

@section('content')
    <div class="bg-white">
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Galeri Foto</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Dokumentasi Kegiatan dan Informasi Desa Pamuruyan
                    </p>
                </div>

                <!-- Tabs -->
                <div class="mt-16 border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'semua']) }}"
                            class="tab-button {{ $activeTab === 'semua' ? 'tab-active' : '' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium {{ $activeTab === 'semua' ? 'border-lime-600 text-lime-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            Semua Foto
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'berita']) }}"
                            class="tab-button {{ $activeTab === 'berita' ? 'tab-active' : '' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium {{ $activeTab === 'berita' ? 'border-lime-600 text-lime-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            Berita
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'keuangan']) }}"
                            class="tab-button {{ $activeTab === 'keuangan' ? 'tab-active' : '' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium {{ $activeTab === 'keuangan' ? 'border-lime-600 text-lime-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            Keuangan
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'kegiatan']) }}"
                            class="tab-button {{ $activeTab === 'kegiatan' ? 'tab-active' : '' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium {{ $activeTab === 'kegiatan' ? 'border-lime-600 text-lime-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            Kegiatan
                        </a>
                    </nav>
                </div>

                <!-- Gallery Content -->
                <div class="mt-8">
                    <!-- Berita Section -->
                    <div id="tab-berita" class="tab-content {{ $activeTab === 'berita' ? '' : 'hidden' }}">
                        <div class="gallery-container">
                            @forelse($beritas as $berita)
                                <div class="gallery-item break-inside-avoid mb-6">
                                    <a href="{{ Storage::url($berita->thumbnail) }}" class="gallery-link">
                                        <div
                                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                            <img src="{{ Storage::url($berita->thumbnail) }}" alt="{{ $berita->judul }}"
                                                class="w-full h-64 object-cover">
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                                    {{ $berita->judul }}</h3>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    {{ $berita->tanggal_post ? $berita->tanggal_post->format('d F Y') : '-' }}
                                                </p>
                                                <span
                                                    class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Berita
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Tidak ada foto berita</p>
                                </div>
                            @endforelse
                        </div>
                        @if ($beritas->hasPages())
                            <div class="mt-8">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($beritas->onFirstPage())
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $beritas->previousPageUrl() }}"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    @foreach ($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                                        <a href="{{ $url }}"
                                            class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg px-4 {{ $page == $beritas->currentPage()
                                                ? 'bg-lime-600 text-white hover:bg-lime-500 focus:outline-offset-0'
                                                : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    @if ($beritas->hasMorePages())
                                        <a href="{{ $beritas->nextPageUrl() }}"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Keuangan Section -->
                    <div id="tab-keuangan" class="tab-content {{ $activeTab === 'keuangan' ? '' : 'hidden' }}">
                        <div class="gallery-container">
                            @forelse($keuangans as $keuangan)
                                <div class="gallery-item break-inside-avoid mb-6">
                                    <a href="{{ Storage::url($keuangan->file_bukti) }}" class="gallery-link">
                                        <div
                                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                            <img src="{{ Storage::url($keuangan->file_bukti) }}"
                                                alt="{{ $keuangan->nama_program }}" class="w-full h-64 object-cover">
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                                    {{ $keuangan->nama_program }}</h3>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Tahun Anggaran: {{ $keuangan->tahun_anggaran }}
                                                </p>
                                                <span
                                                    class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Keuangan
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Tidak ada foto keuangan</p>
                                </div>
                            @endforelse
                        </div>
                        @if ($keuangans->hasPages())
                            <div class="mt-8">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($keuangans->onFirstPage())
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $keuangans->previousPageUrl() }}"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    @foreach ($keuangans->getUrlRange(1, $keuangans->lastPage()) as $page => $url)
                                        <a href="{{ $url }}"
                                            class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg px-4 {{ $page == $keuangans->currentPage()
                                                ? 'bg-lime-600 text-white hover:bg-lime-500 focus:outline-offset-0'
                                                : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    @if ($keuangans->hasMorePages())
                                        <a href="{{ $keuangans->nextPageUrl() }}"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Kegiatan Section -->
                    <div id="tab-kegiatan" class="tab-content {{ $activeTab === 'kegiatan' ? '' : 'hidden' }}">
                        <div class="gallery-container">
                            @forelse($jadwals as $jadwal)
                                <div class="gallery-item break-inside-avoid mb-6">
                                    <a href="{{ Storage::url($jadwal->foto_kegiatan) }}" class="gallery-link">
                                        <div
                                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                            <img src="{{ Storage::url($jadwal->foto_kegiatan) }}"
                                                alt="{{ $jadwal->nama_kegiatan }}" class="w-full h-64 object-cover">
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                                    {{ $jadwal->nama_kegiatan }}</h3>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    {{ $jadwal->waktu ? $jadwal->waktu->format('d F Y H:i') : '-' }}
                                                </p>
                                                <span
                                                    class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Kegiatan
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Tidak ada foto kegiatan</p>
                                </div>
                            @endforelse
                        </div>
                        @if ($jadwals->hasPages())
                            <div class="mt-8">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($jadwals->onFirstPage())
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $jadwals->previousPageUrl() }}"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    @foreach ($jadwals->getUrlRange(1, $jadwals->lastPage()) as $page => $url)
                                        <a href="{{ $url }}"
                                            class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg px-4 {{ $page == $jadwals->currentPage()
                                                ? 'bg-lime-600 text-white hover:bg-lime-500 focus:outline-offset-0'
                                                : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    @if ($jadwals->hasMorePages())
                                        <a href="{{ $jadwals->nextPageUrl() }}"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- All Photos Section -->
                    <div id="tab-semua" class="tab-content {{ $activeTab === 'semua' ? '' : 'hidden' }}">
                        <div class="gallery-container">
                            @if ($beritas->isEmpty() && $keuangans->isEmpty() && $jadwals->isEmpty())
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Tidak ada foto yang tersedia</p>
                                </div>
                            @else
                                @foreach ($beritas as $berita)
                                    <div class="gallery-item break-inside-avoid mb-6">
                                        <a href="{{ Storage::url($berita->thumbnail) }}" class="gallery-link">
                                            <div
                                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                                <img src="{{ Storage::url($berita->thumbnail) }}"
                                                    alt="{{ $berita->judul }}" class="w-full h-64 object-cover">
                                                <div class="p-4">
                                                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                                        {{ $berita->judul }}</h3>
                                                    <p class="mt-2 text-sm text-gray-600">
                                                        {{ $berita->tanggal_post ? $berita->tanggal_post->format('d F Y') : '-' }}
                                                    </p>
                                                    <span
                                                        class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Berita
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                @foreach ($keuangans as $keuangan)
                                    <div class="gallery-item break-inside-avoid mb-6">
                                        <a href="{{ Storage::url($keuangan->file_bukti) }}" class="gallery-link">
                                            <div
                                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                                <img src="{{ Storage::url($keuangan->file_bukti) }}"
                                                    alt="{{ $keuangan->nama_program }}" class="w-full h-64 object-cover">
                                                <div class="p-4">
                                                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                                        {{ $keuangan->nama_program }}</h3>
                                                    <p class="mt-2 text-sm text-gray-600">
                                                        Tahun Anggaran: {{ $keuangan->tahun_anggaran }}
                                                    </p>
                                                    <span
                                                        class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Keuangan
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                @foreach ($jadwals as $jadwal)
                                    <div class="gallery-item break-inside-avoid mb-6">
                                        <a href="{{ Storage::url($jadwal->foto_kegiatan) }}" class="gallery-link">
                                            <div
                                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                                <img src="{{ Storage::url($jadwal->foto_kegiatan) }}"
                                                    alt="{{ $jadwal->nama_kegiatan }}" class="w-full h-64 object-cover">
                                                <div class="p-4">
                                                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                                        {{ $jadwal->nama_kegiatan }}</h3>
                                                    <p class="mt-2 text-sm text-gray-600">
                                                        {{ $jadwal->waktu ? $jadwal->waktu->format('d F Y H:i') : '-' }}
                                                    </p>
                                                    <span
                                                        class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Kegiatan
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js"></script>
    <script>
        new SimpleLightbox('.gallery-link', {
            captionsData: 'alt',
            captionDelay: 250,
            animationSpeed: 250,
            fadeSpeed: 150,
            nav: true,
            close: true,
            loadingText: 'Memuat...',
        });
    </script>
@endpush
