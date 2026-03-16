@extends('layouts.app')

@section('title', 'Pergeseran')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }

    .select2-dropdown {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
</style>
@endpush

@section('content')
<!--====== NOTIFICATIONS ======-->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
    <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
</div>
@endif

<!--====== PERGESERAN CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Pergeseran Anggaran</h1>
                    <p class="text-purple-100">Lihat perubahan alokasi anggaran sebelum dan sesudah pergeseran</p>
                </div>
                <a href="{{ route('skpd.pengajuan') }}"
                    class="bg-white text-purple-600 hover:bg-purple-50 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Two Column Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left Card: Sebelum Berubah -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-blue-100 text-blue-600 rounded-lg p-2 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sebelum Berubah</h3>
                            <p class="text-sm text-gray-500">Data alokasi anggaran semula</p>
                        </div>
                    </div>
                    <button onclick="openModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors {{ $pengajuan->status == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $pengajuan->status == 1 ? 'disabled' : '' }}>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Tambah</span>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rekening Awal</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis SSH</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Spesifikasi</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Koefisien</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if($sebelumData->count() > 0)
                                @foreach($sebelumData as $index => $item)
                                @php
                                // Get SSH data for spesifikasi display
                                $sshData = \App\Models\Ssh::where('kode_barang', $item->kode_komponen)
                                ->where('kode_rekening', $item->kode_rekening)
                                ->first();
                                $uraian = $sshData->uraian_barang ?? $item->kode_komponen;

                                // Format currency
                                $formattedHarga = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
                                $formattedHarga->setTextAttribute(\NumberFormatter::CURRENCY_CODE, 'IDR');
                                $formattedHargaValue = $formattedHarga->format($item->harga);

                                // Calculate total koefisien
                                $totalKoefisien = 1;
                                if ($item->koefisien1 > 0) $totalKoefisien *= $item->koefisien1;
                                if ($item->koefisien2 > 0) $totalKoefisien *= $item->koefisien2;
                                if ($item->koefisien3 > 0) $totalKoefisien *= $item->koefisien3;

                                $formattedTotal = $formattedHarga->format($item->total);
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{
                                        $item->kode_rekening }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->jenis_ssh }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $uraian }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $item->satuan }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">{{
                                        $formattedHargaValue }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">{{
                                        $totalKoefisien }}</td>
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        {{ $formattedTotal }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-center">
                                        <button onclick="deleteSebelum({{ $item->id }})"
                                            class="text-red-600 hover:text-red-800 transition-colors p-1 rounded hover:bg-red-50 {{ $pengajuan->status == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $pengajuan->status == 1 ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2">Belum ada data pergeseran</p>
                                        <p class="text-xs">Klik tombol "Tambah" untuk menambahkan data</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Card: Sesudah Berubah -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-green-100 text-green-600 rounded-lg p-2 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sesudah Berubah</h3>
                            <p class="text-sm text-gray-500">Data alokasi anggaran setelah pergeseran</p>
                        </div>
                    </div>
                    <button onclick="openSesudahModal()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors {{ $pengajuan->status == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $pengajuan->status == 1 ? 'disabled' : '' }}>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Tambah</span>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rekening Baru</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis SSH</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Spesifikasi</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Koefisien</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($sesudahData) && $sesudahData->count() > 0)
                                @foreach($sesudahData as $index => $item)
                                @php
                                // Get SSH data for spesifikasi display
                                $sshData = \App\Models\Ssh::where('kode_barang', $item->kode_komponen)
                                ->where('kode_rekening', $item->kode_rekening)
                                ->first();
                                $uraian = $sshData->uraian_barang ?? $item->kode_komponen;

                                // Format currency
                                $formattedHarga = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
                                $formattedHarga->setTextAttribute(\NumberFormatter::CURRENCY_CODE, 'IDR');
                                $formattedHargaValue = $formattedHarga->format($item->harga);

                                // Calculate total koefisien
                                $totalKoefisien = 1;
                                if ($item->koefisien1 > 0) $totalKoefisien *= $item->koefisien1;
                                if ($item->koefisien2 > 0) $totalKoefisien *= $item->koefisien2;
                                if ($item->koefisien3 > 0) $totalKoefisien *= $item->koefisien3;

                                $formattedTotal = $formattedHarga->format($item->total);
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{
                                        $item->kode_rekening }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->jenis_ssh }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $uraian }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $item->satuan }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">{{
                                        $formattedHargaValue }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">{{
                                        $totalKoefisien }}</td>
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        {{ $formattedTotal }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-center">
                                        <button onclick="deleteSesudah({{ $item->id }})"
                                            class="text-red-600 hover:text-red-800 transition-colors p-1 rounded hover:bg-red-50 {{ $pengajuan->status == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $pengajuan->status == 1 ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2">Belum ada data pergeseran</p>
                                        <p class="text-xs">Klik tombol "Tambah" untuk menambahkan data</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Summary Card -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Ringkasan Pergeseran</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                // Calculate total from Sebelum data
                $totalSebelum = $sebelumData->sum('total');

                // Calculate total from Sesudah data
                $totalSesudah = isset($sesudahData) ? $sesudahData->sum('total') : 0;

                // Calculate netral (selisih)
                $netral = $totalSebelum - $totalSesudah;

                // Format currency
                $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
                $formatter->setTextAttribute(\NumberFormatter::CURRENCY_CODE, 'IDR');
                $formattedTotalSebelum = $formatter->format($totalSebelum);
                $formattedTotalSesudah = $formatter->format($totalSesudah);
                $formattedNetral = $formatter->format($netral);
                @endphp
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-500 text-white rounded-full p-2 mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Total Sebelum</span>
                    </div>
                    <p class="text-2xl font-bold text-blue-600">{{ $formattedTotalSebelum }}</p>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-center mb-2">
                        <div class="bg-green-500 text-white rounded-full p-2 mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Total Sesudah</span>
                    </div>
                    <p class="text-2xl font-bold text-green-600">{{ $formattedTotalSesudah }}</p>
                </div>

                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                    <div class="flex items-center mb-2">
                        <div class="bg-purple-500 text-white rounded-full p-2 mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2 9-5-7-7-2 5 7 14 2 5 7 7 14 2 5-7-7-2 5 7-14 2 5 7-7-7 7-14 2"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Aksi</span>
                    </div>
                    <button onclick="kirimPergeseran()"
                        class="w-full mt-3 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors {{ in_array($pengajuan->status, [1, 2, 3, 4]) ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ in_array($pengajuan->status, [1, 2, 3, 4]) ? 'disabled' : '' }}
                        data-total-sebelum="{{ $totalSebelum }}"
                        data-total-sesudah="{{ $totalSesudah }}">
                        Kirim Pergeseran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Data -->
    <div id="modalForm" class="fixed inset-0 backdrop-blur-sm bg-white/30 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 rounded-t-xl bg-gradient-to-r from-blue-600 to-indigo-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Tambah Data Pergeseran</h3>
                    <button onclick="closeModal()" class="text-white hover:text-blue-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="sebelumForm" class="p-6 space-y-4">
                <input type="hidden" id="pengajuanId" value="{{ $pengajuan->id }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rekening Awal</label>
                    <select id="rekeningSelect"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Rekening Awal</option>
                        @foreach($rekeningOptions as $rekening)
                        <option value="{{ $rekening->kode_rekening }}">{{ $rekening->kode_rekening }} -{{
                            $rekening->nama_rekening }} - {{
                            $rekening->jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang - uraian -
                        Spesifikasi</label>
                    <select id="spesifikasiSelect"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Spesifikasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="text" id="satuanInput" placeholder="Masukkan satuan" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="text" id="hargaInput" placeholder="Masukkan harga" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Koefisien</label>
                    <div class="space-y-3">
                        <!-- Row 1 -->
                        <div class="flex space-x-3">
                            <input type="number" id="koefisienAngka1" placeholder="0"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <input type="text" placeholder="-"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <!-- Row 2 -->
                        <div class="flex space-x-3">
                            <input type="number" id="koefisienAngka2" placeholder="0"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <input type="text" placeholder="-"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <!-- Row 3 -->
                        <div class="flex space-x-3">
                            <input type="number" id="koefisienAngka3" placeholder="0"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <input type="text" placeholder="-"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                    <input type="text" id="totalInput" placeholder="Masukkan total" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="saveBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Tambah Data Sesudah -->
    <div id="modalFormSesudah"
        class="fixed inset-0 backdrop-blur-sm bg-white/30 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 rounded-t-xl bg-gradient-to-r from-green-600 to-teal-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Tambah Data Sesudah Pergeseran</h3>
                    <button onclick="closeSesudahModal()" class="text-white hover:text-green-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="sesudahForm" class="p-6 space-y-4">
                <input type="hidden" id="pengajuanIdSesudah" value="{{ $pengajuan->id }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rekening Baru</label>
                    <select id="rekeningSelectSesudah"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Pilih Rekening Baru</option>
                        @foreach($rekeningOptions as $rekening)
                        <option value="{{ $rekening->kode_rekening }}">{{ $rekening->kode_rekening }} -{{
                            $rekening->nama_rekening }} - {{
                            $rekening->jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang - uraian -
                        Spesifikasi</label>
                    <select id="spesifikasiSelectSesudah"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Pilih Spesifikasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="text" id="satuanInputSesudah" placeholder="Masukkan satuan" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="text" id="hargaInputSesudah" placeholder="Masukkan harga" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Koefisien</label>
                    <div class="space-y-3">
                        <!-- Row 1 -->
                        <div class="flex space-x-3">
                            <input type="number" id="koefisienAngka1Sesudah" placeholder="0"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <input type="text" placeholder="-"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <!-- Row 2 -->
                        <div class="flex space-x-3">
                            <input type="number" id="koefisienAngka2Sesudah" placeholder="0"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <input type="text" placeholder="-"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <!-- Row 3 -->
                        <div class="flex space-x-3">
                            <input type="number" id="koefisienAngka3Sesudah" placeholder="0"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <input type="text" placeholder="-"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                    <input type="text" id="totalInputSesudah" placeholder="Masukkan total" readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50">
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeSesudahModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="saveBtnSesudah"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function openModal() {
            const modal = document.getElementById('modalForm');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modalForm');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openSesudahModal() {
            const modal = document.getElementById('modalFormSesudah');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeSesudahModal() {
            const modal = document.getElementById('modalFormSesudah');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Function to send pergeseran
        function kirimPergeseran() {
            // Get button element
            const button = document.querySelector('button[onclick="kirimPergeseran()"]');
            
            // Get totals from data attributes
            const totalSebelum = parseFloat(button.getAttribute('data-total-sebelum')) || 0;
            const totalSesudah = parseFloat(button.getAttribute('data-total-sesudah')) || 0;
            
            // Validate that totals are equal
            if (totalSebelum !== totalSesudah) {
                // Format totals for display
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });
                
                const formattedTotalSebelum = formatter.format(totalSebelum);
                const formattedTotalSesudah = formatter.format(totalSesudah);
                
                alert('Total Sebelum dan Total Sesudah harus sama!\n\nTotal Sebelum: ' + formattedTotalSebelum + '\nTotal Sesudah: ' + formattedTotalSesudah);
                return;
            }
            
            if (confirm('Apakah Anda yakin ingin mengirim pergeseran anggaran ini?')) {
                $.ajax({
                    url: '/kirim-pergeseran',
                    type: 'POST',
                    data: {
                        pengajuan_id: '{{ $pengajuan->id }}',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Pergeseran berhasil dikirim!');
                            location.reload();
                        } else {
                            alert('Gagal mengirim pergeseran: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat mengirim pergeseran';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            }
        }

        // Function to delete Sesudah data (globally accessible)
        function deleteSesudah(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '/sesudah/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil dihapus!');
                            location.reload();
                        } else {
                            alert('Gagal menghapus data: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            }
        }

        // Function to delete Sebelum data (globally accessible)
        function deleteSebelum(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '/sebelum/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil dihapus!');
                            location.reload();
                        } else {
                            alert('Gagal menghapus data: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            }
        }

        // Store data for lookup
        let sshData = [];
        let rawHarga = 0;

        // Initialize Select2 on rekening dropdown
        $(document).ready(function() {
            $('#rekeningSelect').select2({
                placeholder: 'Pilih Rekening Awal',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });

            // Initialize Select2 on spesifikasi dropdown
            $('#spesifikasiSelect').select2({
                placeholder: 'Pilih Spesifikasi',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });

            // Handle rekening change to load spesifikasi
            $('#rekeningSelect').on('change', function() {
                const kodeRekening = $(this).val();
                
                // Clear spesifikasi dropdown and inputs
                $('#spesifikasiSelect').empty();
                $('#spesifikasiSelect').append('<option value="">Pilih Spesifikasi</option>');
                $('#satuanInput').val('');
                $('#hargaInput').val('');
                sshData = [];
                
                if (kodeRekening) {
                    // AJAX request to get kode_barang based on kode_rekening
                    $.ajax({
                        url: '/get-kode-barang',
                        type: 'GET',
                        data: { kode_rekening: kodeRekening },
                        dataType: 'json',
                        success: function(data) {
                            // Store data for lookup
                            sshData = data;
                            
                            $.each(data, function(index, item) {
                                const uraian = item.uraian_barang || '';
                                const spesifikasi = item.spesifikasi || '';
                                $('#spesifikasiSelect').append(
                                    `<option value="${item.kode_barang}">${item.kode_barang} - ${uraian} - ${spesifikasi}</option>`
                                );
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading kode_barang:', error);
                        }
                    });
                }
            });

            // Handle spesifikasi change to auto-fill satuan and harga
            $('#spesifikasiSelect').on('change', function() {
                const kodeBarang = $(this).val();
                
                // Find the selected item in stored data
                const selectedItem = sshData.find(item => item.kode_barang === kodeBarang);
                
                if (selectedItem) {
                    // Store raw harga for calculation
                    rawHarga = selectedItem.harga || 0;
                    
                    // Format harga with currency
                    const formattedHarga = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(rawHarga);
                    
                    $('#satuanInput').val(selectedItem.satuan || '');
                    $('#hargaInput').val(formattedHarga);
                    
                    // Calculate total
                    calculateTotal();
                } else {
                    $('#satuanInput').val('');
                    $('#hargaInput').val('');
                    rawHarga = 0;
                    $('#totalInput').val('');
                }
            });

            // Handle koefisien change to calculate total
            $('#koefisienAngka1, #koefisienAngka2, #koefisienAngka3').on('input', function() {
                calculateTotal();
            });

            // Function to calculate total
            function calculateTotal() {
                const koefisien1 = parseFloat($('#koefisienAngka1').val()) || 0;
                const koefisien2 = parseFloat($('#koefisienAngka2').val()) || 0;
                const koefisien3 = parseFloat($('#koefisienAngka3').val()) || 0;
                
                // Filter out null/0 values and multiply them
                let totalKoefisien = 1;
                let hasValidKoefisien = false;
                
                if (koefisien1 > 0) {
                    totalKoefisien *= koefisien1;
                    hasValidKoefisien = true;
                }
                if (koefisien2 > 0) {
                    totalKoefisien *= koefisien2;
                    hasValidKoefisien = true;
                }
                if (koefisien3 > 0) {
                    totalKoefisien *= koefisien3;
                    hasValidKoefisien = true;
                }
                
                // Calculate total
                const total = rawHarga * totalKoefisien;
                
                if (total > 0 && rawHarga > 0 && hasValidKoefisien) {
                    const formattedTotal = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(total);
                    
                    $('#totalInput').val(formattedTotal);
                } else {
                    $('#totalInput').val('');
                }
            }

            // Handle form submission
            $('#sebelumForm').on('submit', function(e) {
                e.preventDefault();
                
                // Get all satuan inputs (the ones with placeholder "-")
                const satuanInputs = $('#sebelumForm .space-y-3 input[type="text"][placeholder="-"]');
                const satuan1 = satuanInputs.eq(0).val() || null;
                const satuan2 = satuanInputs.eq(1).val() || null;
                const satuan3 = satuanInputs.eq(2).val() || null;
                
                // Get selected spesifikasi data
                const selectedOption = $('#spesifikasiSelect option:selected');
                const spesifikasiParts = selectedOption.text().split(' - ');
                const kodeBarang = spesifikasiParts[0] || '';
                const uraianBarang = spesifikasiParts[1] || '';
                const spesifikasi = spesifikasiParts.slice(2).join(' - ') || '';
                
                // Get selected rekening
                const kodeRekening = $('#rekeningSelect').val();
                
                // Get other values
                const satuan = $('#satuanInput').val();
                const harga = rawHarga;
                const koefisien1 = parseFloat($('#koefisienAngka1').val()) || 0;
                const koefisien2 = parseFloat($('#koefisienAngka2').val()) || 0;
                const koefisien3 = parseFloat($('#koefisienAngka3').val()) || 0;
                
                // Calculate total
                const totalKoefisien = (koefisien1 || 1) * (koefisien2 || 1) * (koefisien3 || 1);
                const total = harga * totalKoefisien;
                
                // Prepare form data
                const formData = {
                    pengajuan_id: $('#pengajuanId').val(),
                    kode_rekening: kodeRekening,
                    kode_barang: kodeBarang,
                    uraian_barang: uraianBarang,
                    spesifikasi: spesifikasi,
                    satuan: satuan,
                    harga: harga,
                    koefisien1: koefisien1,
                    koefisien2: koefisien2,
                    koefisien3: koefisien3,
                    satuan1: satuan1,
                    satuan2: satuan2,
                    satuan3: satuan3,
                    total: total
                };
                
                // Show loading state
                $('#saveBtn').prop('disabled', true).html('Menyimpan...');
                
                // Send AJAX request
                $.ajax({
                    url: '/store-sebelum',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#saveBtn').prop('disabled', false).html('Simpan');
                        
                        if (response.success) {
                            // Show success alert
                            alert('Data berhasil disimpan!');
                            
                            // Close modal
                            closeModal();
                            
                            // Reset form
                            $('#sebelumForm')[0].reset();
                            $('#spesifikasiSelect').empty();
                            $('#spesifikasiSelect').append('<option value="">Pilih Spesifikasi</option>');
                            sshData = [];
                            rawHarga = 0;
                            
                            // Reload page to show updated data
                            location.reload();
                        } else {
                            alert('Gagal menyimpan data: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#saveBtn').prop('disabled', false).html('Simpan');
                        
                        let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                        
                        alert(errorMessage);
                    }
                });
            });
        });

        // Store data for Sesudah lookup
        let sshDataSesudah = [];
        let rawHargaSesudah = 0;

        // Initialize Select2 on rekening dropdown for Sesudah
        $(document).ready(function() {
            $('#rekeningSelectSesudah').select2({
                placeholder: 'Pilih Rekening Baru',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });

            // Initialize Select2 on spesifikasi dropdown for Sesudah
            $('#spesifikasiSelectSesudah').select2({
                placeholder: 'Pilih Spesifikasi',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });

            // Handle rekening change to load spesifikasi for Sesudah
            $('#rekeningSelectSesudah').on('change', function() {
                const kodeRekening = $(this).val();
                
                // Clear spesifikasi dropdown and inputs
                $('#spesifikasiSelectSesudah').empty();
                $('#spesifikasiSelectSesudah').append('<option value="">Pilih Spesifikasi</option>');
                $('#satuanInputSesudah').val('');
                $('#hargaInputSesudah').val('');
                sshDataSesudah = [];
                
                if (kodeRekening) {
                    // AJAX request to get kode_barang based on kode_rekening
                    $.ajax({
                        url: '/get-kode-barang',
                        type: 'GET',
                        data: { kode_rekening: kodeRekening },
                        dataType: 'json',
                        success: function(data) {
                            // Store data for lookup
                            sshDataSesudah = data;
                            
                            $.each(data, function(index, item) {
                                const uraian = item.uraian_barang || '';
                                const spesifikasi = item.spesifikasi || '';
                                $('#spesifikasiSelectSesudah').append(
                                    `<option value="${item.kode_barang}">${item.kode_barang} - ${uraian} - ${spesifikasi}</option>`
                                );
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading kode_barang:', error);
                        }
                    });
                }
            });

            // Handle spesifikasi change to auto-fill satuan and harga for Sesudah
            $('#spesifikasiSelectSesudah').on('change', function() {
                const kodeBarang = $(this).val();
                
                // Find the selected item in stored data
                const selectedItem = sshDataSesudah.find(item => item.kode_barang === kodeBarang);
                
                if (selectedItem) {
                    // Store raw harga for calculation
                    rawHargaSesudah = selectedItem.harga || 0;
                    
                    // Format harga with currency
                    const formattedHarga = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(rawHargaSesudah);
                    
                    $('#satuanInputSesudah').val(selectedItem.satuan || '');
                    $('#hargaInputSesudah').val(formattedHarga);
                    
                    // Calculate total
                    calculateTotalSesudah();
                } else {
                    $('#satuanInputSesudah').val('');
                    $('#hargaInputSesudah').val('');
                    rawHargaSesudah = 0;
                    $('#totalInputSesudah').val('');
                }
            });

            // Handle koefisien change to calculate total for Sesudah
            $('#koefisienAngka1Sesudah, #koefisienAngka2Sesudah, #koefisienAngka3Sesudah').on('input', function() {
                calculateTotalSesudah();
            });

            // Function to calculate total for Sesudah
            function calculateTotalSesudah() {
                const koefisien1 = parseFloat($('#koefisienAngka1Sesudah').val()) || 0;
                const koefisien2 = parseFloat($('#koefisienAngka2Sesudah').val()) || 0;
                const koefisien3 = parseFloat($('#koefisienAngka3Sesudah').val()) || 0;
                
                // Filter out null/0 values and multiply them
                let totalKoefisien = 1;
                let hasValidKoefisien = false;
                
                if (koefisien1 > 0) {
                    totalKoefisien *= koefisien1;
                    hasValidKoefisien = true;
                }
                if (koefisien2 > 0) {
                    totalKoefisien *= koefisien2;
                    hasValidKoefisien = true;
                }
                if (koefisien3 > 0) {
                    totalKoefisien *= koefisien3;
                    hasValidKoefisien = true;
                }
                
                // Calculate total
                const total = rawHargaSesudah * totalKoefisien;
                
                if (total > 0 && rawHargaSesudah > 0 && hasValidKoefisien) {
                    const formattedTotal = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(total);
                    
                    $('#totalInputSesudah').val(formattedTotal);
                } else {
                    $('#totalInputSesudah').val('');
                }
            }

            // Handle form submission for Sesudah
            $('#sesudahForm').on('submit', function(e) {
                e.preventDefault();
                
                // Get all satuan inputs (the ones with placeholder "-")
                const satuanInputs = $('#sesudahForm .space-y-3 input[type="text"][placeholder="-"]');
                const satuan1 = satuanInputs.eq(0).val() || null;
                const satuan2 = satuanInputs.eq(1).val() || null;
                const satuan3 = satuanInputs.eq(2).val() || null;
                
                // Get selected spesifikasi data
                const selectedOption = $('#spesifikasiSelectSesudah option:selected');
                const spesifikasiParts = selectedOption.text().split(' - ');
                const kodeBarang = spesifikasiParts[0] || '';
                const uraianBarang = spesifikasiParts[1] || '';
                const spesifikasi = spesifikasiParts.slice(2).join(' - ') || '';
                
                // Get selected rekening
                const kodeRekening = $('#rekeningSelectSesudah').val();
                
                // Get other values
                const satuan = $('#satuanInputSesudah').val();
                const harga = rawHargaSesudah;
                const koefisien1 = parseFloat($('#koefisienAngka1Sesudah').val()) || 0;
                const koefisien2 = parseFloat($('#koefisienAngka2Sesudah').val()) || 0;
                const koefisien3 = parseFloat($('#koefisienAngka3Sesudah').val()) || 0;
                
                // Calculate total
                const totalKoefisien = (koefisien1 || 1) * (koefisien2 || 1) * (koefisien3 || 1);
                const total = harga * totalKoefisien;
                
                // Prepare form data
                const formData = {
                    pengajuan_id: $('#pengajuanIdSesudah').val(),
                    kode_rekening: kodeRekening,
                    kode_barang: kodeBarang,
                    uraian_barang: uraianBarang,
                    spesifikasi: spesifikasi,
                    satuan: satuan,
                    harga: harga,
                    koefisien1: koefisien1,
                    koefisien2: koefisien2,
                    koefisien3: koefisien3,
                    satuan1: satuan1,
                    satuan2: satuan2,
                    satuan3: satuan3,
                    total: total
                };
                
                // Show loading state
                $('#saveBtnSesudah').prop('disabled', true).html('Menyimpan...');
                
                // Send AJAX request
                $.ajax({
                    url: '/store-sesudah',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#saveBtnSesudah').prop('disabled', false).html('Simpan');
                        
                        if (response.success) {
                            // Show success alert
                            alert('Data berhasil disimpan!');
                            
                            // Close modal
                            closeSesudahModal();
                            
                            // Reset form
                            $('#sesudahForm')[0].reset();
                            $('#spesifikasiSelectSesudah').empty();
                            $('#spesifikasiSelectSesudah').append('<option value="">Pilih Spesifikasi</option>');
                            sshDataSesudah = [];
                            rawHargaSesudah = 0;
                            
                            // Reload page to show updated data
                            location.reload();
                        } else {
                            alert('Gagal menyimpan data: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#saveBtnSesudah').prop('disabled', false).html('Simpan');
                        
                        let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                        
                        alert(errorMessage);
                    }
                });
            });
        });

    </script>

</div>

@endsection