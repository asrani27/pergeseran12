@extends('layouts.app')

@section('title', 'Profil SKPD')

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
                            <a href="{{ route('skpd.dashboard') }}"
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
                                <span class="ml-1 text-sm font-medium text-gray-500">Profil</span>
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
                        <input type="text" placeholder="Cari data..."
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
                            class="w-8 h-8 bg-gradient-to-r from-green-400 to-blue-400 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name ?? 'S', 0, 1)
                                }}</span>
                        </div>
                        <span class="hidden md:block font-medium text-gray-700">{{ Auth::user()->name ?? 'SKPD User'
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
                            <a href="{{ route('skpd.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil Saya
                            </a>
                            <a href="{{ route('skpd.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-key mr-2"></i> Ganti Password
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST" onsubmit="confirmLogout(this); return false;">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
@endsection

@section('sidebar')
<!--====== SIDEBAR ======-->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-gray-900 to-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
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
            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
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
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-all duration-200">
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
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg bg-gray-700 text-white transition-all duration-200 hover:bg-gray-600">
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

<!--====== PROFILE CONTENT ======-->
<div class="transition-all duration-300">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Profil Pengguna</h1>
        <p class="text-gray-600 mt-1">Kelola informasi akun dan password Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-3xl">{{ substr(Auth::user()->name ?? 'S', 0, 1) }}</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ Auth::user()->name ?? 'SKPD User' }}</h3>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'skpd@local' }}</p>
                    @if(Auth::user()->skpd)
                        <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-building mr-1"></i>
                            {{ Auth::user()->skpd->nama }}
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Username</dt>
                            <dd class="text-sm text-gray-900">{{ Auth::user()->username ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                            <dd class="text-sm text-gray-900">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Aktif
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                </div>
                <div class="p-6">
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? '' }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email ?? '' }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Ganti Password</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('skpd.profile') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" id="new_password" name="new_password" required minlength="8"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <i class="fas fa-key mr-2"></i>
                                Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
