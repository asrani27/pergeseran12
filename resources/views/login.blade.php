<!DOCTYPE html>
<html lang="en">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="Login BPKPAD Pergeseran" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--====== Title ======-->
    <title>Login - BPKPAD Pergeseran</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../assets/images/favicon.svg" type="image/svg" />

    <!--====== Vite Assets ======-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">

    <!--====== NAVBAR PART START ======-->

    <nav
        class="bg-gradient-to-r from-blue-600/90 via-indigo-600/90 to-purple-600/90 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-white/20 backdrop-blur-sm rounded-lg blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <img src="/fr/logo.png" height="50px" alt="Logo" class="relative h-12 w-auto rounded-lg" />
                        </div>
                        <span class="font-bold text-xl text-white">BPKPAD</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/"
                            class="relative text-white bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full font-medium text-sm hover:bg-white/30 transform hover:scale-105 transition-all duration-300 border border-white/30">
                            Beranda
                        </a>
                        <a href="/login"
                            class="relative text-white bg-white/30 backdrop-blur-sm px-6 py-2 rounded-full font-medium text-sm hover:bg-white/40 transform hover:scale-105 transition-all duration-300 border border-white/40">
                            Login
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button"
                        class="bg-white/20 backdrop-blur-sm p-2 rounded-lg text-white hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-300 border border-white/30">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-gradient-to-r from-blue-600/95 via-indigo-600/95 to-purple-600/95 backdrop-blur-lg border-t border-white/20">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/"
                    class="bg-white/20 backdrop-blur-sm text-white block px-3 py-2 rounded-md text-base font-medium border border-white/30">Beranda</a>
                <a href="/login"
                    class="bg-white/30 backdrop-blur-sm text-white block px-3 py-2 rounded-md text-base font-medium border border-white/40">Login</a>
            </div>
        </div>
    </nav>

    <!-- Success and Error Messages -->
    @if(session('success'))
    <div class="fixed top-20 right-4 z-50 max-w-sm w-full animate-pulse">
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                        class="inline-flex text-green-400 hover:text-green-600 focus:outline-none transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-20 right-4 z-50 max-w-sm w-full animate-pulse">
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                        class="inline-flex text-red-400 hover:text-red-600 focus:outline-none transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!--====== LOGIN SECTION START ======-->
    <section class="relative overflow-hidden flex items-center justify-center min-h-[calc(100vh-4rem)]">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div
                class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-blue-300 to-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse">
            </div>
            <div
                class="absolute top-40 right-10 w-72 h-72 bg-gradient-to-r from-purple-300 to-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-2000">
            </div>
            <div
                class="absolute bottom-20 left-1/2 w-72 h-72 bg-gradient-to-r from-yellow-300 to-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-4000">
            </div>
        </div>

        <div class="relative w-full max-w-md mx-4">
            <!-- Login Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Selamat Datang
                    </h2>
                    <p class="text-gray-600 mt-2">Masuk ke sistem BPKPAD Pergeseran</p>
                </div>

                <!-- Login Form -->
                <form class="space-y-6" method="POST" action="/login">
                    @csrf
                    <!-- Username Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input id="email" name="username" type="text" autocomplete="username" required
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm transition-all duration-300"
                                placeholder="username" value="{{ old('username') }}">
                        </div>
                        @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/80 backdrop-blur-sm transition-all duration-300"
                                placeholder="••••••">
                        </div>
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{
                                old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#"
                                class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Masuk
                            </span>
                        </button>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a href="#"
                                class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

    <!--====== Mobile Menu Script ======-->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.animate-pulse');
            messages.forEach(function(message) {
                message.remove();
            });
        }, 5000);
    </script>
</body>

</html>