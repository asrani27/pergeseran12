@extends('layouts.app')

@section('title', 'SKPD')

@section('navbar')
<!--====== TOP NAVBAR ======-->
<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left: Sidebar Toggle & Breadcrumb -->
            <div class="flex items-center">
                <!-- Mobile Sidebar Toggle -->
                <button id="sidebar-toggle" onclick="toggleSidebar()"
                    class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Breadcrumb -->
                <nav class="hidden md:flex ml-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500">SKPD</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Right: Search & User Menu -->
            <div class="flex items-center space-x-4">

                <!-- Search Bar -->
                <div class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari SKPD..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Notifications -->
                <button
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                </button>

                <!-- User Dropdown -->
                <div class="relative">
                    <button onclick="toggleUserMenu()"
                        class="flex items-center space-x-3 text-sm rounded-lg hover:bg-gray-100 p-2 transition-colors">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name ?? 'A', 0, 1)
                                }}</span>
                        </div>
                        <span class="hidden md:block font-medium text-gray-700">{{ Auth::user()->name ?? 'Administrator'
                            }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                            <form action="{{ route('logout') }}" method="POST"
                                onsubmit="confirmLogout(this); return false;">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
@endsection

@section('content')
<!--====== NOTIFICATIONS ======-->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
    <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
</div>
@endif

<!--====== SKPD CONTENT ======-->
<div class="transition-all duration-300">

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Data SKPD</h1>
                <p class="text-gray-600 mt-2">Kelola data Satuan Kerja Perangkat Daerah</p>
            </div>
            <div class="flex space-x-3">
                <button
                    class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah SKPD
                </button>
                <button
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>
    </div>

    <!-- SKPD Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Daftar SKPD</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <select
                            class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 pl-4 pr-8 py-2">
                            <option selected>Semua Status</option>
                            <option>Aktif</option>
                            <option>Non-aktif</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Username SKPD</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Username Pimpinan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            SKPD</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($data as $key => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $key + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-xs">{{ substr($item->kode_skpd, 0, 2)
                                        }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->kode_skpd }}</p>
                                    @if ($item->user)
                                    <p class="text-xs text-green-600">Aktif</p>
                                    @else
                                    <p class="text-xs text-gray-500">Belum ada akun</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-xs">P</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">pimpinan_{{ $item->kode_skpd }}</p>
                                    @if ($item->kepala)
                                    <p class="text-xs text-green-600">Aktif</p>
                                    @else
                                    <p class="text-xs text-gray-500">Belum ada akun</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-building text-gray-400 mr-2"></i>
                                {{ $item->nama }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($item->user && $item->kepala)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Lengkap
                            </span>
                            @elseif ($item->user || $item->kepala)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Sebagian
                            </span>
                            @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Belum Ada
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">

                                @if ($item->user == null)
                                <a href="/superadmin/skpd/createakun/{{ $item->id }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                    <i class="fas fa-key mr-1"></i>
                                    Buat Akun SKPD
                                </a>
                                @else
                                <a href="/superadmin/skpd/resetakun/{{ $item->id }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-xs font-medium rounded-md hover:from-teal-700 hover:to-cyan-700 transition-colors duration-200 shadow-sm">
                                    <i class="fas fa-key mr-1"></i>
                                    Reset Akun SKPD
                                </a>
                                @endif

                                @if ($item->kepala == null)
                                <a href="/superadmin/skpd/kepala/createakun/{{ $item->id }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-purple-600 text-white text-xs font-medium rounded-md hover:bg-purple-700 transition-colors duration-200 shadow-sm">
                                    <i class="fas fa-key mr-1"></i>
                                    Buat Akun Pimpinan
                                </a>
                                @else
                                <a href="/superadmin/skpd/kepala/resetakun/{{ $item->id }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-pink-600 to-rose-600 text-white text-xs font-medium rounded-md hover:from-pink-700 hover:to-rose-700 transition-colors duration-200 shadow-sm">
                                    <i class="fas fa-key mr-1"></i>
                                    Reset Akun Pimpinan
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($data->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-institution text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data SKPD</h3>
            <p class="text-gray-500">Tambahkan SKPD baru untuk mulai mengelola data.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle User Menu
function toggleUserMenu() {
    const menu = document.getElementById('user-menu');
    menu.classList.toggle('hidden');
}

// Close user menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('user-menu');
    const button = event.target.closest('button[onclick="toggleUserMenu()"]');
    
    if (!menu.contains(event.target) && !button) {
        menu.classList.add('hidden');
    }
});
</script>
@endpush
