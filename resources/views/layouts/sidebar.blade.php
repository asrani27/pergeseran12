<!--====== SIDEBAR ======-->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 via-indigo-900 to-purple-900 shadow-2xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm rounded-lg blur-lg opacity-75"></div>
                <img src="/fr/logo.png" height="40px" alt="Logo" class="relative h-10 w-auto rounded-lg" />
            </div>
        </div>

        {{-- <div>
            <h1 class="text-white font-bold text-lg">BPKPAD</h1>
            <p class="text-blue-200 text-xs">Pergeseran System</p>
        </div> --}}

        <!-- Mobile Close Button -->
        <button onclick="toggleSidebar()" class="lg:hidden text-white/80 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- User Profile -->
    <div class="px-6 py-4 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-white font-medium text-sm">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <p class="text-blue-200 text-xs">{{ Auth::user()->email ?? 'admin@bpkpad.go.id' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        @if(Auth::user()->role == 'superadmin')
        <!-- Superadmin Menu -->
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <!-- SKPD -->
        <a href="{{ route('skpd.index') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('skpd.*') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                </path>
            </svg>
            SKPD
        </a>

        <!-- Import Data -->
        <a href="{{ route('import.index') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('import.index') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                </path>
            </svg>
            Import Data
        </a>

        <!-- Import SSH -->
        <a href="{{ route('import.ssh') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('import.ssh') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Import SSH
        </a>

        @elseif(Auth::user()->role == 'skpd')

        <!-- SKPD Role Menu -->
        <!-- Dashboard -->
        <a href="{{ route('skpd.dashboard') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('skpd.dashboard') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <!-- Pengajuan Pergeseran -->
        <a href="{{ route('skpd.pengajuan') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('skpd.pengajuan*') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Pengajuan Pergeseran
        </a>

        <!-- Profil -->
        <a href="{{ route('skpd.profile') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('skpd.profile') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                </path>
            </svg>
            Profil
        </a>

        @elseif(Auth::user()->role == 'pimpinan')

        <!-- Pimpinan Role Menu -->
        <!-- Dashboard -->
        <a href="{{ route('pimpinan.dashboard') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('pimpinan.dashboard') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <!-- Profil -->
        <a href="{{ route('pimpinan.profile') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('pimpinan.profile') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                </path>
            </svg>
            Profil
        </a>

        @elseif(Auth::user()->role == 'bpkpad')
        <!-- BPKPAD Role Menu -->
        <!-- Dashboard -->
        <a href="{{ route('bpkpad.dashboard') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('bpkpad.dashboard') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <!-- Profil -->
        <a href="{{ route('bpkpad.profile') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('bpkpad.profile') ? 'bg-white/10 text-white border border-white/20' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
            <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                </path>
            </svg>
            Profil
        </a>
        @endif
    </nav>

    <!-- Sidebar Footer -->
    <div class="border-t border-white/10 p-4">
        <form action="{{ route('logout') }}" method="POST" class="w-full" onsubmit="confirmLogout(this); return false;">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:text-white hover:bg-red-500/20 border border-red-500/30 transition-all duration-300">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<!--====== SUBMENU TOGGLE SCRIPT ======-->
<script>
    function toggleSubmenu(menuId) {
    const submenu = document.getElementById(menuId + '-submenu');
    const arrow = document.getElementById(menuId + '-arrow');
    
    if (submenu.classList.contains('hidden')) {
        // Close other submenus
        document.querySelectorAll('[id$="-submenu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
        document.querySelectorAll('[id$="-arrow"]').forEach(arr => {
            arr.classList.remove('rotate-180');
        });
        
        // Open clicked submenu
        submenu.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        submenu.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}
</script>
