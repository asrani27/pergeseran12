@extends('layouts.app')

@section('title', 'Detail Pengajuan Pergeseran')

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

<!--====== DETAIL PENGAJUAN CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Detail Pengajuan Pergeseran</h1>
                    <p class="text-blue-100">Informasi lengkap pengajuan pergeseran anggaran</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('skpd.pengajuan.edit', $pengajuan->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('skpd.pengajuan') }}" 
                       class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Surat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Informasi Surat
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $pengajuan->nomor_surat ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <p class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pengajuan</label>
                            <p class="text-sm text-gray-900 font-medium">
                                @switch($pengajuan->tipe_pengajuan)
                                    @case(1)
                                        Antar Objek
                                        @break
                                    @case(2)
                                        Antar Rincian Objek
                                        @break
                                    @case(3)
                                        Antar Sub Rincian Objek
                                        @break
                                    @case(4)
                                        Perubahan Uraian
                                        @break
                                    @default
                                        -
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hal</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $pengajuan->hal ?? '-' }}</p>
                        </div>
                    </div>
                    
                    @if($pengajuan->pengantar)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kalimat Pengantar</label>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $pengajuan->pengantar }}</p>
                    </div>
                    @endif
                    
                    @if($pengajuan->lampiran)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                        <a href="{{ asset('storage/' . $pengajuan->lampiran) }}" target="_blank" 
                           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Lihat Lampiran
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Detail Program, Kegiatan, Sub Kegiatan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Detail Program, Kegiatan, dan Sub Kegiatan
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Program -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h4 class="font-semibold text-blue-900">Program</h4>
                        </div>
                        <p class="text-sm text-blue-800 font-medium">{{ $pengajuan->kode_program }} - {{ $pengajuan->nama_program }}</p>
                    </div>
                    
                    <!-- Kegiatan -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="font-semibold text-green-900">Kegiatan</h4>
                        </div>
                        <p class="text-sm text-green-800 font-medium">{{ $pengajuan->kode_kegiatan }} - {{ $pengajuan->nama_kegiatan }}</p>
                    </div>
                    
                    <!-- Sub Kegiatan -->
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h4 class="font-semibold text-purple-900">Sub Kegiatan</h4>
                        </div>
                        <p class="text-sm text-purple-800 font-medium">{{ $pengajuan->kode_subkegiatan }} - {{ $pengajuan->nama_subkegiatan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (1/3) -->
        <div class="space-y-6">
            <!-- Status Pengajuan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status Pengajuan
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Status Operator -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Operator</label>
                        @switch($pengajuan->status_operator)
                            @case(1)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 w-full justify-center py-2">
                                    Di Proses
                                </span>
                                @break
                            @case(2)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 w-full justify-center py-2">
                                    Selesai
                                </span>
                                @break
                            @default
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 w-full justify-center py-2">
                                    Unknown
                                </span>
                        @endswitch
                    </div>
                    
                    <!-- Status Kepala SKPD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Kepala SKPD</label>
                        @switch($pengajuan->status_kepala_skpd)
                            @case(0)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 w-full justify-center py-2">
                                    Menunggu
                                </span>
                                @break
                            @case(1)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 w-full justify-center py-2">
                                    Di Proses
                                </span>
                                @break
                            @case(2)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 w-full justify-center py-2">
                                    Selesai
                                </span>
                                @break
                            @case(3)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 w-full justify-center py-2">
                                    Ditolak
                                </span>
                                @break
                            @default
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 w-full justify-center py-2">
                                    Unknown
                                </span>
                        @endswitch
                    </div>
                    
                    <!-- Status BPKPAD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status BPKPAD</label>
                        @switch($pengajuan->status_bpkpad)
                            @case(0)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 w-full justify-center py-2">
                                    Menunggu
                                </span>
                                @break
                            @case(1)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 w-full justify-center py-2">
                                    Di Proses
                                </span>
                                @break
                            @case(2)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 w-full justify-center py-2">
                                    Selesai
                                </span>
                                @break
                            @case(3)
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 w-full justify-center py-2">
                                    Ditolak
                                </span>
                                @break
                            @default
                                <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 w-full justify-center py-2">
                                    Unknown
                                </span>
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Informasi SKPD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Informasi SKPD
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKPD</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $pengajuan->skpd->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Diajukan oleh</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $pengajuan->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $pengajuan->tahun ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            @if($pengajuan->ket_kepala_skpd || $pengajuan->ket_bpkpad)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Keterangan
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($pengajuan->ket_kepala_skpd)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kepala SKPD</label>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $pengajuan->ket_kepala_skpd }}</p>
                    </div>
                    @endif
                    
                    @if($pengajuan->ket_bpkpad)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">BPKPAD</label>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $pengajuan->ket_bpkpad }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
