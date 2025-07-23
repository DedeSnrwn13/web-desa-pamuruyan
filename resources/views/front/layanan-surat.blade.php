@extends("layouts.main")

@section("title", "Pelayanan Surat")

@section("content")
    <div class="bg-white">
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Layanan Surat</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Silahkan pilih jenis surat yang Anda butuhkan. Untuk mengajukan surat, Anda perlu login terlebih
                        dahulu.
                    </p>
                </div>

                <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($jenisSurat as $surat)
                        <div class="relative flex flex-col gap-6 rounded-2xl bg-white p-8 shadow-lg ring-1 ring-gray-200">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-lime-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold leading-8 text-gray-900">{{ $surat->nama }}</h3>
                                <p class="mt-2 text-sm leading-6 text-gray-600">Kode: {{ $surat->kode }}</p>
                            </div>
                            <a href="{{ auth()->guard("warga")->check() ? route("filament.warga.resources.surats.create", ["kode-surat" => $surat->kode]) : route("filament.warga.auth.login") }}"
                                class="mt-auto inline-flex items-center justify-center rounded-md bg-lime-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-lime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-600">
                                {{ auth()->guard("warga")->check() ? "Ajukan Surat" : "Login untuk Ajukan" }}
                            </a>
                        </div>
                    @endforeach
                </div>

                @if ($jenisSurat->hasPages())
                    <div class="mt-10">
                        <div class="flex items-center justify-center gap-2">
                            @if ($jenisSurat->onFirstPage())
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
                                <a href="{{ $jenisSurat->previousPageUrl() }}"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            @foreach ($jenisSurat->getUrlRange(1, $jenisSurat->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg px-4 {{ $page == $jenisSurat->currentPage()
                                        ? "bg-lime-600 text-white hover:bg-lime-500 focus:outline-offset-0"
                                        : "bg-white text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-lime-50 hover:text-lime-600" }}">
                                    {{ $page }}
                                </a>
                            @endforeach

                            @if ($jenisSurat->hasMorePages())
                                <a href="{{ $jenisSurat->nextPageUrl() }}"
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

            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </div>
    </div>
@endsection
