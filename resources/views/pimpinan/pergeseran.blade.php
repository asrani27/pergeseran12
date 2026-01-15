@extends('layouts.app')

@section('title', 'Detail Pergeseran')

@push('styles')
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
        <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Detail Pergeseran Anggaran</h1>
                    <p class="text-amber-100">Review dan setujui pergeseran anggaran</p>
                </div>
                <a href="{{ route('pimpinan.dashboard') }}"
                    class="bg-white text-amber-600 hover:bg-amber-50 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Pengajuan Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Pengajuan</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Nomor Surat</p>
                    <p class="text-gray-900 font-medium">{{ $pengajuan->nomor_surat }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Tanggal</p>
                    <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d/m/Y')
                        }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Program</p>
                    <p class="text-gray-900 font-medium">{{ $pengajuan->nama_program ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Diajukan Oleh</p>
                    <p class="text-gray-900 font-medium">{{ $pengajuan->user->name ?? '-' }}</p>
                </div>
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
                $totalSebelum = $sebelumData->sum('total');
                $totalSesudah = isset($sesudahData) ? $sesudahData->sum('total') : 0;
                $netral = $totalSebelum - $totalSesudah;

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

                @if($pengajuan->status_kepala_skpd == 1)
                <div class="space-y-2">
                    <button onclick="approvePergeseran()"
                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span>Setujui</span>
                    </button>
                    <button onclick="rejectPergeseran()"
                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Tolak</span>
                    </button>
                </div>
                @elseif($pengajuan->status_kepala_skpd == 2)
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-center mb-2">
                        <div class="bg-green-500 text-white rounded-full p-2 mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Status</span>
                    </div>
                    <p class="text-xl font-bold text-green-600">Disetujui</p>
                </div>
                @elseif($pengajuan->status_kepala_skpd == 3)
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <div class="flex items-center mb-2">
                        <div class="bg-red-500 text-white rounded-full p-2 mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Status</span>
                    </div>
                    <p class="text-xl font-bold text-red-600">Ditolak</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function approvePergeseran() {
        if (confirm('Apakah Anda yakin ingin menyetujui pergeseran ini?')) {
            $.ajax({
                url: '/pimpinan/approve-pergeseran',
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
                        alert('Pergeseran berhasil disetujui!');
                        location.reload();
                    } else {
                        alert('Gagal menyetujui pergeseran: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat menyetujui pergeseran';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    }

    function rejectPergeseran() {
        if (confirm('Apakah Anda yakin ingin menolak pergeseran ini?')) {
            $.ajax({
                url: '/pimpinan/reject-pergeseran',
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
                        alert('Pergeseran berhasil ditolak!');
                        location.reload();
                    } else {
                        alert('Gagal menolak pergeseran: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat menolak pergeseran';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    }
</script>

@endsection