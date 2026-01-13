@extends('layouts.app')

@section('title', 'Surat')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Surat</h1>
                    <p class="text-gray-600 mt-1">Kelola surat masuk dan keluar</p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Buat Surat</span>
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button class="py-4 px-6 border-b-2 border-blue-500 font-medium text-sm text-blue-600 focus:outline-none">
                        Surat Masuk
                    </button>
                    <button class="py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none">
                        Surat Keluar
                    </button>
                </nav>
            </div>
        </div>

        <!-- Surat Masuk Table -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Surat Masuk</h3>
                    <div class="flex space-x-2">
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Cari surat..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Surat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Perihal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pengirim
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Terima
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                                    </svg>
                                    <p class="mt-2">Belum ada data surat masuk</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Menampilkan <span class="font-medium">0</span> hingga <span class="font-medium">0</span> dari <span class="font-medium">0</span> hasil
            </div>
            <div class="flex space-x-1">
                <button class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50" disabled>
                    Previous
                </button>
                <button class="px-3 py-2 border border-blue-500 rounded-md text-sm font-medium text-blue-600 bg-blue-50">
                    1
                </button>
                <button class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50" disabled>
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
