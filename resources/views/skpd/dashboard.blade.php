@extends('layouts.app')

@section('title', 'Dashboard SKPD')

@section('sidebar')
<!--====== SIDEBAR ======-->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-gray-900 to-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center h-16 px-4 bg-gray-900 border-b border-gray-700">
        <div class="flex items-center">
            <img src="{{ asset('logo/pemko.png') }}" alt="Logo" class="h-10 w-10 rounded-lg">
            <div class="ml-3">
                <h1 class="text-xl font-bold text-white">SIMPEG</h1>
                <p class="text-xs text-gray-400">SKPD Portal</p>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="px-4 py-6 border-b border-gray-700">
        <div class="flex items-center">
            <div
                class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name ?? 'S', 0, 1) }}</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'SKPD User' }}</p>
                <p class="text-xs text-gray-400">{{ Auth::user()->email ?? 'skpd@local' }}</p>
                @if(Auth::user()->skpd)
                <p class="text-xs text-blue-400">{{ Auth::user()->skpd->nama }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-3">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('skpd.dashboard') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg bg-gray-700 text-white transition-all duration-200 hover:bg-gray-600">
                <i class="fas fa-tachometer-alt mr-3 text-blue-400"></i>
                <span>Dashboard</span>
            </a>

            <!-- Pengajuan Pergeseran -->
            <a href="{{ route('skpd.pengajuan') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all duration-200">
                <i class="fas fa-exchange-alt mr-3 text-green-400"></i>
                <span>Pengajuan Pergeseran</span>
                <span class="ml-auto bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full">New</span>
            </a>

            <!-- Surat -->
            <a href="{{ route('skpd.surat') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all duration-200">
                <i class="fas fa-file-alt mr-3 text-yellow-400"></i>
                <span>Surat</span>
            </a>

            <!-- Divider -->
            <div class="border-t border-gray-700 my-4"></div>

            <!-- Profil -->
            <a href="{{ route('skpd.profile') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all duration-200">
                <i class="fas fa-user-circle mr-3 text-purple-400"></i>
                <span>Profil</span>
            </a>

            <!-- Keluar -->
            <form action="{{ route('logout') }}" method="POST" onsubmit="confirmLogout(this); return false;">
                @csrf
                <button type="submit"
                    class="w-full group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition-all duration-200">
                    <i class="fas fa-sign-out-alt mr-3 text-red-400"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

<!-- Mobile sidebar overlay -->
<div id="sidebar-overlay" onclick="toggleSidebar()"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 z-40 lg:hidden hidden"></div>
@endsection

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

    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name ?? 'SKPD User' }}!</h1>
                    <p class="text-blue-100">
                        @if(Auth::user()->skpd)
                        {{ Auth::user()->skpd->nama }}
                        @else
                        Portal SKPD Sistem Informasi Manajemen Pegawai
                        @endif
                    </p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-building text-6xl text-white opacity-20"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengajuan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-file-contract text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-gray-900">24</p>
                </div>
            </div>
        </div>

        <!-- Sedang Proses -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sedang Proses</p>
                    <p class="text-2xl font-bold text-gray-900">8</p>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">15</p>
                </div>
            </div>
        </div>

        <!-- Surat Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <i class="fas fa-envelope text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Surat Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">12</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('skpd.pengajuan.create') }}"
                    class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Ajukan Pergeseran</span>
                </a>
                <a href="{{ route('skpd.surat') }}"
                    class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-envelope-open-text text-green-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Lihat Surat</span>
                </a>
                <a href="{{ route('skpd.pengajuan') }}"
                    class="flex flex-col items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-list-alt text-yellow-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Riwayat Pengajuan</span>
                </a>
                <a href="{{ route('skpd.profile') }}"
                    class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-user-cog text-purple-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Pengaturan</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-900">Pengajuan pergeseseran disetujui</p>
                        <p class="text-xs text-gray-500">2 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file text-blue-600 text-xs"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-900">Surat masuk baru</p>
                        <p class="text-xs text-gray-500">5 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xs"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-900">Pengajuan sedang diproses</p>
                        <p class="text-xs text-gray-500">1 hari yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection