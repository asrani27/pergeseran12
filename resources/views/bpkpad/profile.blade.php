@extends('layouts.app')

@section('title', 'Profil BPKPAD')

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
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <h1 class="text-2xl font-bold mb-2">Profil BPKPAD</h1>
            <p class="text-purple-100">Kelola informasi akun dan password Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-3xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-building mr-1"></i>
                        BPKPAD
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Username</dt>
                            <dd class="text-sm text-gray-900">{{ $user->username }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                            <dd class="text-sm text-gray-900">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</dd>
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
                    <form action="{{ route('bpkpad.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
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
                    <form action="{{ route('bpkpad.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" id="new_password" name="new_password" required minlength="8"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                                @error('new_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                @error('new_password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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
