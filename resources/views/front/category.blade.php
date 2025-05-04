@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

    <body class="font-[Poppins] pb-[83px]">
        <x-navbar />

        <nav id="Category" class="max-w-[1130px] mx-auto flex justify-center items-center gap-4 mt-[30px] flex-wrap">
            @foreach ($kategori_beritas as $kat)
                <a href="{{ route('front.kategori', $kat->slug) }}"
                    class="rounded-full p-[12px_22px] flex gap-[10px] font-semibold transition-all duration-300 border border-[#EEF0F7] hover:ring-2 hover:ring-lime-600">
                    <span>{{ $kat->nama }}</span>
                </a>
            @endforeach
        </nav>
        <section id="Category-result" class="max-w-[1130px] mx-auto flex items-center flex-col gap-[30px] mt-[70px]">
            <h1 class="text-4xl leading-[45px] font-bold text-center">
                Jelajahi <br />
                {{ $kategori_berita->nama }}
            </h1>
            <div id="search-cards" class="grid grid-cols-3 gap-[30px]">
                @forelse ($kategori_berita->beritas as $berita)
                    <a href="{{ route('front.berita.detail', $berita->slug) }}" class="card">
                        <div
                            class="flex flex-col gap-4 p-[26px_20px] transition-all duration-300 ring-1 ring-[#EEF0F7] hover:ring-2 hover:ring-lime-600 rounded-[20px] overflow-hidden bg-white">
                            <div class="thumbnail-container h-[200px] relative rounded-[20px] overflow-hidden">
                                <div
                                    class="badge absolute left-5 top-5 bottom-auto right-auto flex p-[8px_18px] bg-white rounded-[50px]">
                                    <p class="text-xs leading-[18px] font-bold uppercase">
                                        {{ $berita->kategoriBerita->nama }}</p>
                                </div>
                                <img src="{{ Storage::url($berita->thumbnail) }}" alt="thumbnail photo"
                                    class="w-full h-full object-cover" />
                            </div>
                            <div class="flex flex-col gap-[6px]">
                                <h3 class="text-lg leading-[27px] font-bold">
                                    {{ substr($berita->judul, 0, 60) }}{{ strlen($berita->judul) > 60 ? '...' : '' }}
                                </h3>
                                <p class="text-sm leading-[21px] text-[#A3A6AE]">{{ $berita->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Belum ada berita terkait kategori berikut</p>
                @endforelse
            </div>
        </section>
    </body>
@endsection
