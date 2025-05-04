@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <body class="font-[Poppins] pb-[72px]">
        <x-navbar />

        <nav id="category" class="max-w-[1130px] mx-auto flex justify-center items-center gap-4 mt-[30px] flex-wrap">
            @foreach ($kategori_beritas as $kategori_berita)
                <a href="{{ route('front.kategori', $kategori_berita->slug) }}"
                    class="rounded-full p-[12px_22px] flex gap-[10px] font-semibold transition-all duration-300 border border-[#EEF0F7] hover:ring-2 hover:ring-lime-600">
                    <span>{{ $kategori_berita->nama }}</span>
                </a>
            @endforeach
        </nav>
        <section id="Featured" class="mt-[30px]">
            <div class="main-carousel w-full">
                @forelse ($berita_terbarus as $berita_terbaru)
                    <div class="featured-news-card relative w-full h-[550px] flex shrink-0 overflow-hidden">
                        <img src="{{ Storage::url($berita_terbaru->thumbnail) }}"
                            class="thumbnail absolute w-full h-full object-cover" alt="icon" />
                        <div class="w-full h-full bg-gradient-to-b from-[rgba(0,0,0,0)] to-[rgba(0,0,0,0.9)] absolute z-10">
                        </div>
                        <div
                            class="card-detail max-w-[1130px] w-full mx-auto flex items-end justify-between pb-10 relative z-20">
                            <div class="flex flex-col gap-[10px]">
                                <p class="text-white">Featured</p>
                                <a href="{{ route('front.berita.detail', $berita_terbaru->slug) }}"
                                    class="font-bold text-4xl leading-[45px] text-white two-lines hover:underline transition-all duration-300">{{ $berita_terbaru->name }}</a>
                                <p class="text-white">{{ $berita_terbaru->created_at->format('M d, Y') }} •
                                    {{ $berita_terbaru->kategoriBerita->nama }}</p>
                            </div>
                            <div class="prevNextButtons flex items-center gap-4 mb-[60px]">
                                <button
                                    class="button--previous appearance-none w-[38px] h-[38px] flex items-center justify-center rounded-full shrink-0 ring-1 ring-white hover:ring-2 hover:ring-[#FF6B18] transition-all duration-300">
                                    <img src="images/arrow.svg" alt="arrow" />
                                </button>
                                <button
                                    class="button--next appearance-none w-[38px] h-[38px] flex items-center justify-center rounded-full shrink-0 ring-1 ring-white hover:ring-2 hover:ring-[#FF6B18] transition-all duration-300 rotate-180">
                                    <img src="images/arrow.svg" alt="arrow" />
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Belum ada data terbaru</p>
                @endforelse
            </div>
        </section>
        <section id="Up-to-date" class="max-w-[1130px] mx-auto flex flex-col gap-[30px] mt-[70px]">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-[26px] leading-[39px]">
                    Berita Hangat Terbaru
                </h2>
                <p
                    class="badge-orange rounded-full p-[8px_18px] bg-[#FFECE1] font-bold text-sm leading-[21px] text-[#FF6B18] w-fit">
                    UP TO DATE</p>
            </div>
            <div class="grid grid-cols-3 gap-[30px]">
                @forelse ($beritas as $berita)
                    <a href="{{ route('front.berita.detail', $berita->slug) }}" class="card-news">
                        <div
                            class="rounded-[20px] ring-1 ring-[#EEF0F7] p-[26px_20px] flex flex-col gap-4 hover:ring-2 hover:ring-[#FF6B18] transition-all duration-300 bg-white">
                            <div
                                class="thumbnail-container w-full h-[200px] rounded-[20px] flex shrink-0 overflow-hidden relative">
                                <p
                                    class="badge-white absolute top-5 left-5 rounded-full p-[8px_18px] bg-white font-bold text-xs leading-[18px]">
                                    {{ $berita->kategoriBerita->nama }}</p>
                                <img src="{{ Storage::url($berita->thumbnail) }}" class="object-cover w-full h-full"
                                    alt="thumbnail" />
                            </div>
                            <div class="card-info flex flex-col gap-[6px]">
                                <h3 class="font-bold text-lg leading-[27px]">{{ $berita->judul }}</h3>
                                <p class="text-sm leading-[21px] text-[#A3A6AE]">
                                    {{ $berita->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Belum ada data terbaru...</p>
                @endforelse

            </div>
        </section>
    </body>
@endsection
