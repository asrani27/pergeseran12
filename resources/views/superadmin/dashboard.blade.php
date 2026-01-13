@extends('layouts.app')

@section('title', 'Dashboard')
@section('description', 'Dashboard Sistem Pergeseran BPKPAD')

@section('navbar')
<!--====== TOP NAVBAR ======-->
<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Left: Sidebar Toggle & Breadcrumb -->
            <div class="flex items-center">
                <!-- Mobile Sidebar Toggle -->
                <button id="sidebar-toggle" onclick="toggleSidebar()" class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Breadcrumb -->
                <nav class="hidden md:flex ml-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Dashboard
                            </a>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                </button>

                <!-- User Dropdown -->
                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-3 text-sm rounded-lg hover:bg-gray-100 p-2 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <span class="hidden md:block font-medium text-gray-700">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                            <form action="{{ route('logout') }}" method="POST" onsubmit="confirmLogout(this); return false;">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
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
<!--====== DASHBOARD CONTENT ======-->
<div id="content-area" class="transition-all duration-300">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat datang di sistem pergeseran anggaran BPKPAD</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Pergeseran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pergeseran</p>
                    <p class="text-2xl font-bold text-gray-900">156</p>
                    <p class="text-xs text-green-600 mt-1">+12% dari bulan lalu</p>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">23</p>
                    <p class="text-xs text-yellow-600 mt-1">Perlu ditindak</p>
                </div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">98</p>
                    <p class="text-xs text-green-600 mt-1">+8% dari bulan lalu</p>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">35</p>
                    <p class="text-xs text-red-600 mt-1">-5% dari bulan lalu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Chart Pergeseran Bulanan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Grafik Pergeseran Bulanan</h3>
                <button class="text-sm text-blue-600 hover:text-blue-700">Lihat Detail</button>
            </div>
            <div class="h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-600">Chart akan ditampilkan di sini</p>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                <button class="text-sm text-blue-600 hover:text-blue-700">Lihat Semua</button>
            </div>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Pengajuan pergeseran #123 diajukan</p>
                        <p class="text-xs text-gray-500">2 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Pengajuan #122 disetujui</p>
                        <p class="text-xs text-gray-500">15 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Pengguna baru terdaftar</p>
                        <p class="text-xs text-gray-500">1 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-red-400 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Pengajuan #121 ditolak</p>
                        <p class="text-xs text-gray-500">2 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Pengajuan Terbaru</h3>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Tambah Baru</button>
                    <button class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Export</button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#123</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Budi Santoso</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Pergeseran anggaran IT</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">02/12/2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">Detail</button>
                            <button class="text-green-600 hover:text-green-900">Verifikasi</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#122</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Siti Nurhaliza</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Pergeseran operasional</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">01/12/2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">Detail</button>
                            <button class="text-gray-600 hover:text-gray-900">Cetak</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
