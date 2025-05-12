@extends('layouts.main')

@section('title', 'Detail Berita')

@php
    use App\Helpers\ImageHelper;
@endphp

@section('content')

    <body class="font-[Poppins]">
        <div class=" py-16">
            <header class="flex flex-col items-center gap-[50px]">
                <div id="Headline" class="max-w-[1130px] mx-auto flex flex-col gap-4 items-center">
                    <p class="w-fit text-[#A3A6AE]">{{ $berita->created_at->format('M  d, Y') }} •
                        {{ $berita->kategoriBerita->nama }}</p>
                    <h1 id="Title" class="font-bold text-[46px] leading-[60px] text-center two-lines">
                        {{ $berita->judul }}</h1>
                    <div class="flex items-center justify-center gap-[70px]">
                        <a id="Author" href="#" class="w-fit h-fit">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full overflow-hidden bg-lime-600 flex items-center justify-center text-white font-semibold">
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
                                    <p class="font-semibold text-sm leading-[21px]">{{ $berita->admin->nama }}</p>
                                    <p class="text-xs leading-[18px] text-[#A3A6AE]">{{ $berita->admin->jabatan }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="w-full h-[500px] flex shrink-0 overflow-hidden">
                    <img src="{{ ImageHelper::getImage($berita->thumbnail, $berita->judul) }}"
                        class="object-cover w-full h-full" alt="cover thumbnail">
                </div>
            </header>
            <section id="Article-container" class="max-w-[1130px] mx-auto flex gap-20 mt-[50px]">
                <article id="Content-wrapper">
                    {!! $berita->isi !!}
                </article>
                <div class="side-bar flex flex-col w-[300px] shrink-0 gap-10">
                    <div id="More-from-author" class="flex flex-col gap-4">
                        <p class="font-bold">Lebih Banyak dari {{ $berita->admin->nama }}</p>
                        @forelse ($berita->admin->beritas->take(15) as $ber)
                            <a href="{{ route('front.berita.detail', $ber->slug) }}" class="card-from-author">
                                <div
                                    class="rounded-[20px] ring-1 ring-[#EEF0F7] p-[14px] flex gap-4 hover:ring-2 hover:ring-[#FF6B18] transition-all duration-300">
                                    <div class="w-[70px] h-[70px] flex shrink-0 overflow-hidden rounded-2xl">
                                        <img src="{{ ImageHelper::getImage($ber->thumbnail, $ber->judul) }}"
                                            class="object-cover w-full h-full" alt="thumbnail">
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
        </div>
    </body>
@endsection
