<!DOCTYPE html>
<html lang="en">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="@yield('description', 'BPKPAD Pergeseran Dashboard')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--====== Title ======-->
    <title>@yield('title', 'Dashboard') - BPKPAD Pergeseran</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../assets/images/favicon.svg" type="image/svg" />

    <!--====== Vite Assets ======-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!--====== Custom Styles for Dashboard ======-->
    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!--====== MAIN WRAPPER ======-->
    <div class="flex h-screen overflow-hidden">

        <!--====== SIDEBAR ======-->
        @include('layouts.sidebar')

        <!--====== CONTENT AREA ======-->
        <div id="content-area" class="flex-1 flex flex-col overflow-hidden lg:ml-64 transition-all duration-300">

            <!--====== NAVBAR ======-->
            @if(Auth::check())
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
                                        @if(request()->routeIs('skpd.*'))
                                        <a href="{{ route('skpd.dashboard') }}"
                                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                </path>
                                            </svg>
                                            Dashboard
                                        </a>
                                        @else
                                        <a href="{{ route('dashboard') }}"
                                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                </path>
                                            </svg>
                                            Dashboard
                                        </a>
                                        @endif
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
                                        @if(request()->routeIs('skpd.*'))
                                        <a href="{{ route('skpd.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i> Profil Saya
                                        </a>
                                        <a href="{{ route('skpd.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-key mr-2"></i> Ganti Password
                                        </a>
                                        @else
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i> Profil Saya
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-key mr-2"></i> Ganti Password
                                        </a>
                                        @endif
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
            @endif

            <!--====== MAIN CONTENT ======-->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!--====== FOOTER SCRIPTS ======-->
    @stack('scripts')

    <!--====== Sidebar Toggle Script ======-->
    <script>
        // Track sidebar state
        let sidebarState = {
            isVisible: true,
            isMobile: window.innerWidth < 1024
        };

        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content-area');
            
            // Update mobile state
            sidebarState.isMobile = window.innerWidth < 1024;
            
            if (sidebarState.isVisible) {
                // Hide sidebar
                if (sidebarState.isMobile) {
                    sidebar.classList.add('-translate-x-full');
                } else {
                    // Desktop: override lg:translate-x-0 by adding !-translate-x-full
                    sidebar.classList.add('!-translate-x-full');
                }
                content.classList.remove('lg:ml-64');
                content.classList.add('lg:ml-0');
                sidebarState.isVisible = false;
            } else {
                // Show sidebar
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.remove('!-translate-x-full');
                if (!sidebarState.isMobile) {
                    content.classList.remove('lg:ml-0');
                    content.classList.add('lg:ml-64');
                }
                sidebarState.isVisible = true;
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) &&
                sidebarState.isVisible) {
                sidebar.classList.add('-translate-x-full');
                sidebarState.isVisible = false;
            }
        });

        // Handle responsive sidebar
        function handleResponsiveSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content-area');
            const isMobile = window.innerWidth < 1024;
            
            if (isMobile !== sidebarState.isMobile) {
                sidebarState.isMobile = isMobile;
                
                if (isMobile) {
                    // On mobile, hide sidebar by default
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('!-translate-x-full');
                    content.classList.remove('lg:ml-64');
                    content.classList.add('lg:ml-0');
                    sidebarState.isVisible = false;
                } else {
                    // On desktop, show sidebar by default
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.remove('!-translate-x-full');
                    content.classList.add('lg:ml-64');
                    content.classList.remove('lg:ml-0');
                    sidebarState.isVisible = true;
                }
            }
        }

        // Initialize and handle resize
        document.addEventListener('DOMContentLoaded', handleResponsiveSidebar);
        window.addEventListener('resize', handleResponsiveSidebar);
    </script>

    <!--====== User Menu Toggle Script ======-->
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

    <!--====== Logout Confirmation Script ======-->
    <script>
        // Logout confirmation function
        function confirmLogout(form) {
            // Prevent any default form submission
            if (event) {
                event.preventDefault();
            }
            
            // Remove any existing modal
            const existingModal = document.getElementById('logout-modal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Create custom confirmation modal
            const modalHtml = `
                <div id="logout-modal" class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 backdrop-blur-md bg-black-50 bg-opacity-20 transition-opacity z-[9998]" aria-hidden="true" onclick="closeLogoutModal()"></div>
                        
                        <!-- Center modal -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full z-[9999]">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Konfirmasi Keluar
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Apakah Anda yakin ingin keluar dari sistem? Semua sesi akan berakhir.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" id="confirm-logout-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                    Ya, Keluar
                                </button>
                                <button type="button" onclick="closeLogoutModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Store form reference for later use
            window.pendingLogoutForm = form;
            
            // Add event listener to confirm button
            setTimeout(() => {
                const confirmBtn = document.getElementById('confirm-logout-btn');
                if (confirmBtn) {
                    confirmBtn.addEventListener('click', proceedLogout);
                }
            }, 100);
            
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
        }

        function proceedLogout() {
            console.log('Proceeding with logout...');
            
            // Restore body scroll
            document.body.style.overflow = '';
            
            // Close modal
            const modal = document.getElementById('logout-modal');
            if (modal) {
                modal.remove();
            }
            
            // Submit stored form directly
            if (window.pendingLogoutForm) {
                console.log('Submitting logout form...');
                console.log('Form action:', window.pendingLogoutForm.action);
                console.log('Form method:', window.pendingLogoutForm.method);
                
                // Submit original form directly
                window.pendingLogoutForm.submit();
            } else {
                console.error('No pending logout form found');
                // Fallback: redirect to logout route directly
                window.location.href = '/logout';
            }
        }

        function closeLogoutModal() {
            // Restore body scroll
            document.body.style.overflow = '';
            
            // Remove modal from DOM
            const modal = document.getElementById('logout-modal');
            if (modal) {
                modal.remove();
            }
            window.pendingLogoutForm = null;
        }

        // Handle ESC key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLogoutModal();
            }
        });

        // Debug: Make sure functions are globally available
        window.proceedLogout = proceedLogout;
        window.closeLogoutModal = closeLogoutModal;
        window.confirmLogout = confirmLogout;
    </script>
</body>

</html>
