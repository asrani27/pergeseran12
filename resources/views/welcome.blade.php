<!DOCTYPE html>
<html lang="en">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--====== Title ======-->
    <title>BPKPAD Pergeseran</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../assets/images/favicon.svg" type="image/svg" />

    <!--====== Vite Assets ======-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">

    <!--====== NAVBAR PART START ======-->

    <nav class="bg-gradient-to-r from-blue-600/90 via-indigo-600/90 to-purple-600/90 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-white/20 backdrop-blur-sm rounded-lg blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <img src="/fr/logo.png" height="50px" alt="Logo" class="relative h-12 w-auto rounded-lg" />
                        </div>
                        <span class="font-bold text-xl text-white">BPKPAD</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="relative text-white bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full font-medium text-sm hover:bg-white/30 transform hover:scale-105 transition-all duration-300 border border-white/30">
                            Beranda
                        </a>
                        <a href="/login" class="relative text-white border-2 border-white/30 hover:border-transparent hover:bg-white/20 px-6 py-2 rounded-full font-medium text-sm transition-all duration-300 backdrop-blur-sm">
                            Login
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="bg-white/20 backdrop-blur-sm p-2 rounded-lg text-white hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-300 border border-white/30">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-gradient-to-r from-blue-600/95 via-indigo-600/95 to-purple-600/95 backdrop-blur-lg border-t border-white/20">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="bg-white/20 backdrop-blur-sm text-white block px-3 py-2 rounded-md text-base font-medium border border-white/30">Beranda</a>
                <a href="/login" class="text-white hover:bg-white/20 block px-3 py-2 rounded-md text-base font-medium transition-all duration-300">Login</a>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if(session('success'))
    <div class="fixed top-20 right-4 z-50 max-w-sm w-full animate-pulse">
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex text-green-400 hover:text-green-600 focus:outline-none transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!--====== HERO SECTION START ======-->
    <section class="relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-blue-300 to-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-gradient-to-r from-purple-300 to-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-gradient-to-r from-yellow-300 to-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Content Column -->
                <div class="text-center lg:text-left space-y-8">
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-100 to-indigo-100 px-4 py-2 rounded-full border border-blue-200">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        <span class="text-sm font-semibold text-blue-800">Sistem Terintegrasi</span>
                    </div>

                    <!-- Main Title -->
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                            <span class="block bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent animate-gradient bg-300">
                                PEMANTAU
                            </span>
                            <span class="block bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient bg-300 animation-delay-1000">
                                PERGESERAN
                            </span>
                            <span class="block bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 bg-clip-text text-transparent animate-gradient bg-300 animation-delay-2000">
                                BPKPAD
                            </span>
                        </h1>
                    </div>

                    <!-- Description -->
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Sistem modern dari dinas BPKPAD yang akan membantu kami dalam mengatur pengajuan pergeseran anggaran daerah dengan teknologi terkini
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/login" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-3xl">
                            <span class="relative z-10">Mulai Sekarang</span>
                            <svg class="relative z-10 ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        
                        <button class="group inline-flex items-center justify-center px-8 py-4 bg-white/80 backdrop-blur-sm text-gray-700 font-bold rounded-2xl border-2 border-gray-200 hover:border-blue-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Demo
                        </button>
                    </div>

                    <!-- Features -->
                    <div class="grid grid-cols-3 gap-4 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">99.9%</div>
                            <div class="text-sm text-gray-600">Uptime</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">24/7</div>
                            <div class="text-sm text-gray-600">Support</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">100+</div>
                            <div class="text-sm text-gray-600">Pengguna</div>
                        </div>
                    </div>
                </div>

                <!-- Image Column -->
                <div class="relative">
                    <!-- Main Image with Glassmorphism -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200 animate-tilt"></div>
                        <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-1">
                            <img src="/fr/gedung.jpg" alt="BPKPAD Building" class="w-full h-auto rounded-3xl shadow-2xl object-cover transform group-hover:scale-105 transition-transform duration-500" />
                        </div>
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-8 -right-8 bg-white rounded-2xl shadow-2xl p-4 animate-float">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">Verified</div>
                                <div class="text-sm text-gray-600">Sistem Aman</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-8 -left-8 bg-white rounded-2xl shadow-2xl p-4 animate-float animation-delay-2000">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">Cepat</div>
                                <div class="text-sm text-gray-600">Real-time</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Wave Animation -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-20 text-gray-50 fill-current animate-wave" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,32 C240,96 480,0 720,32 C960,64 1200,0 1440,32 L1440,120 L0,120 Z"></path>
            </svg>
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes wave {
            0%, 100% { transform: translateX(0px); }
            50% { transform: translateX(-50px); }
        }
        
        @keyframes tilt {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(2deg); }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-wave {
            animation: wave 4s ease-in-out infinite;
        }
        
        .animate-tilt {
            animation: tilt 4s ease-in-out infinite;
        }
        
        .animation-delay-1000 {
            animation-delay: 1s;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        .bg-300 {
            background-size: 300% 300%;
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

        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const successMessages = document.querySelectorAll('.animate-pulse');
            successMessages.forEach(function(message) {
                message.remove();
            });
        }, 5000);
    </script>
</body>

</html>
