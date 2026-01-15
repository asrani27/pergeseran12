@extends('layouts.app')

@section('title', 'Dashboard BPKPAD')

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

<!--====== DASHBOARD CONTENT ======-->
<div class="transition-all duration-300">
    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Dashboard BPKPAD</h1>
                    <p class="text-purple-100">Selamat datang, {{ Auth::user()->name }}</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                    <p class="text-sm font-medium">Badan Pengelola Keuangan dan Aset Daerah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 text-blue-600 rounded-lg p-3 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pengajuan->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 text-yellow-600 rounded-lg p-3 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Di Proses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pengajuan->where('status_bpkpad', 1)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="bg-green-100 text-green-600 rounded-lg p-3 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pengajuan->where('status_bpkpad', 2)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="bg-red-100 text-red-600 rounded-lg p-3 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pengajuan->where('status_bpkpad', 3)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Pengajuan Pergeseran</h3>
            <p class="text-sm text-gray-500">Daftar pengajuan pergeseran dari semua SKPD</p>
        </div>
        <div class="p-6">
            @if($pengajuan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKPD</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Program</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pengajuan as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ $item->skpd->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->nomor_surat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->nama_program ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->status_bpkpad == 1)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Di Proses
                                            </span>
                                        @elseif($item->status_bpkpad == 2)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($item->status_bpkpad == 3)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <a href="{{ route('bpkpad.pergeseran.show', $item->id) }}"
                                            class="text-blue-600 hover:text-blue-900 font-medium">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-gray-500">Belum ada pengajuan pergeseran</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
