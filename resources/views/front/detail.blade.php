@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')

    <body class="font-[Poppins]">
        <x-navbar />
        <nav id="Category" class="max-w-[1130px] mx-auto flex justify-center items-center gap-4 mt-[30px]">
            @foreach ($kategori_beritas as $kategori_berita)
                <a href="{{ route('front.kategori', $kategori_berita->slug) }}"
                    class="rounded-full p-[12px_22px] flex gap-[10px] font-semibold transition-all duration-300 border border-[#EEF0F7] hover:ring-2 hover:ring-[#FF6B18]">
                    <span>{{ $kategori_berita->nama }}</span>
                </a>
            @endforeach
        </nav>
        <header class="flex flex-col items-center gap-[50px] mt-[70px]">
            <div id="Headline" class="max-w-[1130px] mx-auto flex flex-col gap-4 items-center">
                <p class="w-fit text-[#A3A6AE]">{{ $berita->created_at->format('M  d, Y') }} •
                    {{ $berita->kategoriBerita->nama }}</p>
                <h1 id="Title" class="font-bold text-[46px] leading-[60px] text-center two-lines">
                    {{ $berita->judul }}</h1>
                <div class="flex items-center justify-center gap-[70px]">
                    <a id="Author" href="{{ route('front.author', $berita->author->slug) }}" class="w-fit h-fit">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                <img src="{{ Storage::url($berita->admin->avatar) }}" class="object-cover w-full h-full"
                                    alt="avatar">
                            </div>
                            <div class="flex flex-col">
                                <p class="font-semibold text-sm leading-[21px]">{{ $berita->admin->nama }}</p>
                                <p class="text-xs leading-[18px] text-[#A3A6AE]">{{ $berita->admin->jabatan }}</p>
                            </div>
                        </div>
                    </a>
                    <div id="Rating" class="flex items-center gap-1">
                        <div class="flex items-center">
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" alt="star">
                            </div>
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" alt="star">
                            </div>
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" alt="star">
                            </div>
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" alt="star">
                            </div>
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" alt="star">
                            </div>
                        </div>
                        <p class="font-semibold text-xs leading-[18px]">(12,490)</p>
                    </div>
                </div>
            </div>
            <div class="w-full h-[500px] flex shrink-0 overflow-hidden">
                <img src="{{ Storage::url($berita->thumbnail) }}" class="object-cover w-full h-full" alt="cover thumbnail">
            </div>
        </header>
        <section id="Article-container" class="max-w-[1130px] mx-auto flex gap-20 mt-[50px]">
            <article id="Content-wrapper">
                {!! $berita->content !!}
            </article>
            <div class="side-bar flex flex-col w-[300px] shrink-0 gap-10">
                <div id="More-from-author" class="flex flex-col gap-4">
                    <p class="font-bold">More From Author</p>
                    @forelse ($berita->admin->beritas as $ber)
                        <a href="{{ route('front.berita.detail', $ber->slug) }}" class="card-from-author">
                            <div
                                class="rounded-[20px] ring-1 ring-[#EEF0F7] p-[14px] flex gap-4 hover:ring-2 hover:ring-[#FF6B18] transition-all duration-300">
                                <div class="w-[70px] h-[70px] flex shrink-0 overflow-hidden rounded-2xl">
                                    <img src="{{ Storage::url($ber->thumbnail) }}" class="object-cover w-full h-full"
                                        alt="thumbnail">
                                </div>
                                <div class="flex flex-col gap-[6px]">
                                    <p class="line-clamp-2 font-bold">
                                        {{ substr($ber->judul, 0, 50) }}{{ strlen($ber->judul) > 50 ? '...' : '' }}
                                    </p>
                                    <p class="text-xs leading-[18px] text-[#A3A6AE]">
                                        {{ $ber->created_at->format('M d, Y') }} • {{ $ber->kategoriBerita->nama }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Belum ada artikel terbaru lainnya</p>
                    @endforelse
                </div>
            </div>
        </section>
    </body>
@endsection
