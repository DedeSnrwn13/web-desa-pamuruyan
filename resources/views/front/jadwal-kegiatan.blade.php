@extends('layouts.main')

@section('title', 'Jadwal & Kegiatan')

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
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Jadwal Kegiatan</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Berikut adalah daftar kegiatan yang akan dan sedang berlangsung di Desa Pamuruyan
                    </p>
                </div>

                <div class="mt-16">
                    @if($groupedJadwals->isEmpty())
                        <div class="text-center mt-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak ada jadwal</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada jadwal kegiatan yang terdaftar saat ini.</p>
                        </div>
                    @else
                        @foreach($groupedJadwals as $bulan => $kegiatanPerBulan)
                            <div class="mb-12">
                                <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                                    @php
                                        try {
                                            $tanggal = \Carbon\Carbon::createFromFormat('Y-m', $bulan);
                                            echo $tanggal->isoFormat('MMMM Y');
                                        } catch (\Exception $e) {
                                            echo $bulan;
                                        }
                                    @endphp
                                </h2>
                                <div class="space-y-8">
                                    @foreach ($kegiatanPerBulan as $jadwal)
                                        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-200 p-6">
                                            <div class="flex items-start gap-x-4">
                                                <div class="min-w-0 flex-auto">
                                                    <div class="flex items-start justify-between gap-x-3">
                                                        <p class="text-sm font-semibold leading-6 text-gray-900">
                                                            {{ $jadwal->nama_kegiatan }}</p>
                                                        <p
                                                            class="rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset
                                                        @if ($jadwal->status_kegiatan === 'Belum Dimulai') text-yellow-700 bg-yellow-50 ring-yellow-600/20
                                                        @elseif($jadwal->status_kegiatan === 'Berjalan')
                                                            text-green-700 bg-green-50 ring-green-600/20
                                                        @elseif($jadwal->status_kegiatan === 'Selesai')
                                                            text-blue-700 bg-blue-50 ring-blue-600/20
                                                        @else
                                                            text-red-700 bg-red-50 ring-red-600/20 @endif">
                                                            {{ $jadwal->status_kegiatan }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                                        <p class="whitespace-nowrap">
                                                            <time
                                                                datetime="{{ $jadwal->waktu }}">{{ $jadwal->waktu->isoFormat('dddd, D MMMM Y - HH:mm') }}</time>
                                                        </p>
                                                        @if ($jadwal->waktu_selesai)
                                                            <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                                                                <circle cx="1" cy="1" r="1" />
                                                            </svg>
                                                            <p class="truncate">s/d <time
                                                                    datetime="{{ $jadwal->waktu_selesai }}">{{ $jadwal->waktu_selesai->format('H:i') }}</time>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="mt-3 flex items-center gap-x-2.5 text-xs leading-5 text-gray-500">
                                                        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span>{{ $jadwal->lokasi }}</span>
                                                    </div>
                                                    @if ($jadwal->deskripsi)
                                                        <div class="mt-3 text-sm text-gray-700">
                                                            {{ $jadwal->deskripsi }}
                                                        </div>
                                                    @endif
                                                    <div class="mt-3 flex flex-wrap gap-3">
                                                        @if ($jadwal->penanggung_jawab)
                                                            <div class="flex items-center gap-x-2 text-xs leading-5">
                                                                <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                                                </svg>
                                                                <span class="text-gray-500">PJ:
                                                                    {{ $jadwal->penanggung_jawab }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($jadwal->jumlah_peserta)
                                                            <div class="flex items-center gap-x-2 text-xs leading-5">
                                                                <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 9a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 017 18a9.953 9.953 0 01-5.385-1.572zM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 00-1.588-3.755 4.502 4.502 0 015.874 2.636.818.818 0 01-.36.98A7.465 7.465 0 0114.5 16z" />
                                                                </svg>
                                                                <span class="text-gray-500">{{ $jadwal->jumlah_peserta }}
                                                                    Peserta</span>
                                                            </div>
                                                        @endif
                                                        @if ($jadwal->anggaran)
                                                            <div class="flex items-center gap-x-2 text-xs leading-5">
                                                                <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="text-gray-500">Rp
                                                                    {{ number_format($jadwal->anggaran, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if ($jadwal->foto_kegiatan)
                                                        <div class="mt-4">
                                                            <img src="{{ Storage::url($jadwal->foto_kegiatan) }}"
                                                                alt="Foto {{ $jadwal->nama_kegiatan }}"
                                                                class="rounded-lg w-full h-48 object-cover">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if ($jadwals->hasPages())
                        <div class="mt-10">
                            <div class="flex items-center justify-center gap-2">
                                @if ($jadwals->onFirstPage())
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-300 ring-1 ring-inset ring-gray-200">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $jadwals->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
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
                                    <a href="{{ $jadwals->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
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

            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </div>
    </div>
@endsection
