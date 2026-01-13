<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\SkpdDashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ImportController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route (Protected)
Route::get('/superadmin/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// SKPD Routes (Protected)
Route::prefix('superadmin/skpd')->middleware('auth')->group(function () {
    Route::get('/', [SkpdController::class, 'index'])->name('skpd.index');
    Route::get('/createakun/{id}', [SkpdController::class, 'createAkun'])->name('skpd.createakun');
    Route::get('/resetakun/{id}', [SkpdController::class, 'resetAkun'])->name('skpd.resetakun');
    Route::get('/kepala/createakun/{id}', [SkpdController::class, 'createKepalaAkun'])->name('skpd.kepala.createakun');
    Route::get('/kepala/resetakun/{id}', [SkpdController::class, 'resetKepalaAkun'])->name('skpd.kepala.resetakun');
});

// Import Routes (Protected for Superadmin)
Route::prefix('superadmin/import')->middleware('auth')->name('import.')->group(function () {
    Route::get('/', [ImportController::class, 'index'])->name('index');
    Route::post('/', [ImportController::class, 'store'])->name('store');
});

// SKPD Dashboard Routes (Protected for SKPD role)
Route::prefix('skpd')->middleware('auth')->name('skpd.')->group(function () {
    Route::get('/dashboard', [SkpdDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SkpdDashboardController::class, 'profile'])->name('profile');
    Route::get('/pengajuan', [SkpdDashboardController::class, 'pengajuan'])->name('pengajuan');
    Route::get('/pengajuan/create', [SkpdDashboardController::class, 'createPengajuan'])->name('pengajuan.create');
    Route::post('/pengajuan', [SkpdDashboardController::class, 'storePengajuan'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}', [SkpdDashboardController::class, 'showPengajuan'])->name('pengajuan.show');
    Route::get('/pengajuan/{id}/edit', [SkpdDashboardController::class, 'editPengajuan'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [SkpdDashboardController::class, 'updatePengajuan'])->name('pengajuan.update');
    Route::delete('/pengajuan/{id}', [SkpdDashboardController::class, 'destroyPengajuan'])->name('pengajuan.destroy');
    Route::get('/surat', [SkpdDashboardController::class, 'surat'])->name('surat');
});

// AJAX Routes for dynamic dropdowns (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/kegiatan/{programId}', [SkpdDashboardController::class, 'getKegiatan'])->name('kegiatan.get');
    Route::get('/subkegiatan/{kegiatanId}', [SkpdDashboardController::class, 'getSubkegiatan'])->name('subkegiatan.get');
});
