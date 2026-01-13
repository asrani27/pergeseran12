@extends('layouts.app')

@section('title', 'Import Data')

@section('content')
<!--====== NOTIFICATIONS ======-->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center" id="success-notification">
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

@if($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
    <div class="flex items-center mb-2">
        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-red-800 font-medium">Terjadi kesalahan:</p>
    </div>
    <ul class="text-red-700 text-sm space-y-1">
        @foreach($errors->all() as $error)
        <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!--====== Import Progress ======-->
<div id="import-progress" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
    <div class="flex items-center">
        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600 mr-3"></div>
        <div class="flex-1">
            <p class="text-blue-800 text-sm font-medium">Sedang memproses import data...</p>
            <p class="text-blue-600 text-xs mt-1">Mohon tunggu, proses mungkin memerlukan beberapa saat untuk data yang
                besar.</p>
        </div>
    </div>
    <div class="mt-3">
        <div class="w-full bg-blue-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
        </div>
    </div>
</div>

<div id="import-result" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg hidden">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-green-800 text-sm font-medium" id="result-message"></p>
            <div id="result-details" class="mt-2 text-xs text-green-700"></div>
        </div>
    </div>
</div>

<div id="import-error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg hidden">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-red-800 text-sm font-medium">Import gagal:</p>
            <p class="text-red-700 text-xs mt-1" id="error-message"></p>
        </div>
    </div>
</div>

<!--====== IMPORT DATA CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Import Data</h1>
                    <p class="text-green-100">Import data program, kegiatan, dan sub kegiatan dari file Excel</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
                Import File Excel
            </h3>
        </div>
        <div class="p-6">
            <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data"
                onsubmit="return confirm('Apakah Anda yakin ingin mengimport data? Data yang sudah ada mungkin akan terpengaruh.')">
                @csrf

                <div class="space-y-6">
                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih File Excel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" id="file" name="file" accept=".xlsx,.xls" class="hidden" required
                                onchange="updateFileName(this)">
                            <label for="file"
                                class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p id="file-name" class="mt-2 text-sm text-gray-600">
                                        Klik untuk memilih file Excel (.xlsx, .xls)
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file: 10MB</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-900 mb-2">Format File Excel:</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Sheet 1: Program (kolom E=kode_skpd, K=kode, L=nama)</li>
                                    <li>• Sheet 2: Kegiatan (kolom: id, program_id, kode, nama)</li>
                                    <li>• Sheet 3: Sub Kegiatan (kolom: id, kegiatan_id, kode, nama)</li>
                                    <li>• Data Program yang sudah ada (kode_skpd + kode sama) akan dilewati</li>
                                    <li>• Pastikan data sudah sesuai format sebelum diimport</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Kembali</span>
                        </a>

                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submit-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <span>Import Data</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Import History -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                Riwayat Import
            </h3>
        </div>
        @if($importHistory->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama File
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($importHistory as $history)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->nama_file }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($history->status == 'selesai')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                            @elseif($history->status == 'di proses')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Di Proses
                            </span>
                            @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Gagal
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                            title="{{ $history->keterangan ?? '-' }}">
                            {{ $history->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-6 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <p class="text-sm">Belum ada riwayat import</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function updateFileName(input) {
    const fileName = input.files[0]?.name || 'Klik untuk memilih file Excel (.xlsx, .xls)';
    document.getElementById('file-name').textContent = fileName;
    
    // Enable/disable submit button based on file selection
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = !input.files[0];
}
</script>
@endpush
@endsection