@extends('layouts.app')

@section('title', 'Profil Pimpinan')

@section('content')
<div class="transition-all duration-300">
    <!-- Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <h1 class="text-2xl font-bold mb-2">Profil Pimpinan SKPD</h1>
            <p class="text-amber-100">Kelola informasi profil Anda</p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="flex items-start space-x-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                        <span class="text-4xl font-bold text-white">
                            {{ substr($user->name, 0, 1) }}
                        </span>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-4">Pimpinan SKPD</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Username</p>
                            <p class="text-gray-900 font-medium">{{ $user->username }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                            <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 mb-1">SKPD</p>
                            <p class="text-gray-900 font-medium">{{ $skpd->nama ?? '-' }}</p>
                        </div>

                        @if($skpd)
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Kode SKPD</p>
                                <p class="text-gray-900 font-medium">{{ $skpd->kode_skpd }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
