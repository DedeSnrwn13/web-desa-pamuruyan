@extends('layouts.main')

@section('title', 'Berita')

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
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Berita Terkini</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Informasi dan berita terbaru seputar Desa Pamuruyan
                    </p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($beritas as $berita)
                            <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-200 overflow-hidden hover:ring-2 hover:ring-lime-500 transition-all duration-300">
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ Storage::url($berita->thumbnail) }}" 
                                         alt="{{ $berita->judul }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                        <span>{{ $berita->created_at->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $berita->kategoriBerita->nama }}</span>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                                        {{ $berita->judul }}
                                    </h3>
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-8 h-8 rounded-full overflow-hidden bg-lime-600 flex items-center justify-center text-white text-sm font-semibold">
                                            @php
                                                $nama = explode(' ', $berita->admin->name);
                                                $inisial = '';
                                                if (count($nama) >= 2) {
                                                    foreach ($nama as $kata) {
                                                        $inisial .= strtoupper(substr($kata, 0, 1));
                                                    }
                                                } else {
                                                    $inisial = strtoupper(substr($berita->admin->name, 0, 1));
                                                }
                                            @endphp
                                            {{ $inisial }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900">{{ $berita->admin->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $berita->admin->jabatan }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('front.berita.detail', $berita->slug) }}" 
                                       class="inline-flex items-center justify-center rounded-md bg-lime-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-lime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-600 w-full">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                                </svg>
                                <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak ada berita</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada berita yang dipublikasikan.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($beritas->hasPages())
                        <div class="mt-10">
                            <div class="flex items-center justify-center gap-2">
                                @if ($beritas->onFirstPage())
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $beritas->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
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
                                    <a href="{{ $beritas->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </div>
    </div>
@endsection 