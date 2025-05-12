@extends('layouts.main')

@section('title', 'Informasi APBDes')

@push('styles')
    <style>
        select {
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
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
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Informasi APBDes</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Transparansi Anggaran Pendapatan dan Belanja Desa Pamuruyan
                    </p>

                    <!-- Year Filter -->
                    <div class="mt-8">
                        <form id="tahunForm" action="{{ route('front.apbdes') }}" method="GET"
                            class="flex items-center justify-center space-x-4">
                            <label for="tahun" class="text-sm font-medium text-gray-700">Tahun Anggaran:</label>
                            <select name="tahun" id="tahun"
                                class="block w-32 rounded-md border-0 py-2 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-lime-600 sm:text-sm sm:leading-6 cursor-pointer hover:bg-gray-50">
                                @forelse($tahunTersedia as $tahun)
                                    <option value="{{ $tahun }}" {{ $tahun == $tahunAnggaran ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @empty
                                    <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500">
                                Tampilkan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Overview Cards -->
                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Total Pendapatan -->
                    <div
                        class="relative overflow-hidden rounded-lg bg-white px-6 py-8 shadow ring-1 ring-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <dt>
                            <div class="absolute rounded-md bg-lime-500 p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Pendapatan</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-6">
                            <p class="text-2xl font-semibold text-gray-900">Rp
                                {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        </dd>
                    </div>

                    <!-- Total Belanja -->
                    <div
                        class="relative overflow-hidden rounded-lg bg-white px-6 py-8 shadow ring-1 ring-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <dt>
                            <div class="absolute rounded-md bg-lime-500 p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.171-.879-1.172-2.303 0-3.182C10.536 7.719 11.768 7.5 12 7.5c.725 0 1.45.22 2.003.659" />
                                </svg>
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Belanja</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-6">
                            <p class="text-2xl font-semibold text-gray-900">Rp
                                {{ number_format($totalBelanja, 0, ',', '.') }}</p>
                        </dd>
                    </div>

                    <!-- Total Pembiayaan -->
                    <div
                        class="relative overflow-hidden rounded-lg bg-white px-6 py-8 shadow ring-1 ring-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <dt>
                            <div class="absolute rounded-md bg-lime-500 p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Pembiayaan</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-6">
                            <p class="text-2xl font-semibold text-gray-900">Rp
                                {{ number_format($totalPembiayaan, 0, ',', '.') }}</p>
                        </dd>
                    </div>
                </div>

                <!-- Detailed Sections -->
                <div class="mt-16 grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <!-- Sumber Pendapatan -->
                    <div
                        class="bg-white rounded-lg shadow ring-1 ring-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sumber Pendapatan</h3>
                            <div class="space-y-4">
                                @forelse($sumberPendapatan as $sumber)
                                    <div
                                        class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                                        <span class="text-sm text-gray-600">{{ $sumber->sumber_dana }}</span>
                                        <span class="text-sm font-medium text-gray-900">Rp
                                            {{ number_format($sumber->total, 0, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Belum ada data sumber pendapatan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Belanja -->
                    <div
                        class="bg-white rounded-lg shadow ring-1 ring-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Jenis Belanja</h3>
                            <div class="space-y-4">
                                @forelse($jenisBelanja as $belanja)
                                    <div
                                        class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                                        <span class="text-sm text-gray-600">{{ $belanja->sub_kategori }}</span>
                                        <span class="text-sm font-medium text-gray-900">Rp
                                            {{ number_format($belanja->total, 0, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Belum ada data jenis belanja</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembiayaan Section -->
                <div class="mt-8">
                    <div
                        class="bg-white rounded-lg shadow ring-1 ring-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Pembiayaan</h3>
                            <div class="space-y-4">
                                @forelse($jenisPembiayaan as $pembiayaan)
                                    <div
                                        class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                                        <span class="text-sm text-gray-600">{{ $pembiayaan->sub_kategori }}</span>
                                        <span class="text-sm font-medium text-gray-900">Rp
                                            {{ number_format($pembiayaan->total, 0, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Belum ada data pembiayaan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Details Sections -->
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Detail Program dan Realisasi</h2>

                    <!-- Pendapatan Programs -->
                    <div class="mb-12">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Program Pendapatan</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Program</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pagu Anggaran</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Realisasi</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Progress</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($programPendapatan as $program)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $program->nama_program }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $program->sub_kategori }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                                {{ number_format($program->pagu_anggaran, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                                {{ number_format($program->realisasi_anggaran, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-lime-600 h-2.5 rounded-full"
                                                            style="width: {{ $program->persentase_realisasi }}%"></div>
                                                    </div>
                                                    <span
                                                        class="ml-2 text-sm text-gray-500">{{ number_format($program->persentase_realisasi, 1) }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($program->status_realisasi)
                                                    @case('Selesai')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Selesai
                                                        </span>
                                                    @break

                                                    @case('Sedang Berjalan')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Sedang Berjalan
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            Belum Realisasi
                                                        </span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    Belum ada program pendapatan yang tercatat
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Belanja Programs -->
                        <div class="mb-12">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Program Belanja</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Program</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kategori</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pagu Anggaran</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Realisasi</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Progress</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($programBelanja as $program)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $program->nama_program }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $program->sub_kategori }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                                    {{ number_format($program->pagu_anggaran, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                                    {{ number_format($program->realisasi_anggaran, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                            <div class="bg-lime-600 h-2.5 rounded-full"
                                                                style="width: {{ $program->persentase_realisasi }}%"></div>
                                                        </div>
                                                        <span
                                                            class="ml-2 text-sm text-gray-500">{{ number_format($program->persentase_realisasi, 1) }}%</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @switch($program->status_realisasi)
                                                        @case('Selesai')
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                Selesai
                                                            </span>
                                                        @break

                                                        @case('Sedang Berjalan')
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                Sedang Berjalan
                                                            </span>
                                                        @break

                                                        @default
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                Belum Realisasi
                                                            </span>
                                                    @endswitch
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                                        Belum ada program belanja yang tercatat
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pembiayaan Programs -->
                            <div class="mb-12">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">Program Pembiayaan</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Program</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Kategori</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Pagu Anggaran</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Realisasi</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Progress</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($programPembiayaan as $program)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $program->nama_program }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $program->sub_kategori }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                                        {{ number_format($program->pagu_anggaran, 0, ',', '.') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                                        {{ number_format($program->realisasi_anggaran, 0, ',', '.') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                                <div class="bg-lime-600 h-2.5 rounded-full"
                                                                    style="width: {{ $program->persentase_realisasi }}%"></div>
                                                            </div>
                                                            <span
                                                                class="ml-2 text-sm text-gray-500">{{ number_format($program->persentase_realisasi, 1) }}%</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @switch($program->status_realisasi)
                                                            @case('Selesai')
                                                                <span
                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    Selesai
                                                                </span>
                                                            @break

                                                            @case('Sedang Berjalan')
                                                                <span
                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                    Sedang Berjalan
                                                                </span>
                                                            @break

                                                            @default
                                                                <span
                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                    Belum Realisasi
                                                                </span>
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                                            Belum ada program pembiayaan yang tercatat
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="mt-16">
                                    <div class="bg-lime-50 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold text-lime-800 mb-4">Informasi Tambahan</h3>
                                        <div class="prose prose-lime max-w-none">
                                            <p class="text-lime-700">
                                                APBDes (Anggaran Pendapatan dan Belanja Desa) adalah rencana keuangan tahunan pemerintah
                                                desa yang dibahas dan disetujui bersama oleh Pemerintah Desa dan Badan Permusyawaratan
                                                Desa, yang ditetapkan dengan Peraturan Desa.
                                            </p>
                                            <p class="text-lime-700 mt-4">
                                                Data yang ditampilkan di atas merupakan realisasi anggaran desa yang telah divalidasi.
                                                Untuk informasi lebih lanjut, silakan menghubungi kantor desa atau datang langsung ke
                                                Balai Desa Pamuruyan.
                                            </p>
                                        </div>
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
                <script>
                    // Backup script jika onchange pada select tidak berfungsi
                    document.getElementById('tahun').addEventListener('change', function() {
                        document.getElementById('tahunForm').submit();
                    });
                </script>
            @endpush
