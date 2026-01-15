<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\SkpdDashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\BpkpadController;

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
    Route::get('/ssh', [ImportController::class, 'ssh'])->name('ssh');
    Route::post('/ssh', [ImportController::class, 'sshStore'])->name('ssh.store');
});

// SKPD Dashboard Routes (Protected for SKPD role)
Route::prefix('skpd')->middleware('auth')->name('skpd.')->group(function () {
    Route::get('/dashboard', [SkpdDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SkpdDashboardController::class, 'profile'])->name('profile');
    Route::get('/pengajuan', [SkpdDashboardController::class, 'pengajuan'])->name('pengajuan');
    Route::get('/pengajuan/create', [SkpdDashboardController::class, 'createPengajuan'])->name('pengajuan.create');
    Route::post('/pengajuan', [SkpdDashboardController::class, 'storePengajuan'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}', [SkpdDashboardController::class, 'showPengajuan'])->name('pengajuan.show');
    Route::get('/pengajuan/{id}/pergeseran', [SkpdDashboardController::class, 'pergeseran'])->name('pengajuan.pergeseran');
    Route::get('/pengajuan/{id}/edit', [SkpdDashboardController::class, 'editPengajuan'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [SkpdDashboardController::class, 'updatePengajuan'])->name('pengajuan.update');
    Route::delete('/pengajuan/{id}', [SkpdDashboardController::class, 'destroyPengajuan'])->name('pengajuan.destroy');
    Route::get('/surat', [SkpdDashboardController::class, 'surat'])->name('surat');
    Route::get('/surat/pergeseran/{id}', [SkpdDashboardController::class, 'cetakSuratPergeseran'])->name('surat.pergeseran');
    Route::get('/surat/pernyataan/{id}', [SkpdDashboardController::class, 'cetakSuratPernyataan'])->name('surat.pernyataan');
    Route::get('/surat/keterangan/{id}', [SkpdDashboardController::class, 'cetakSuratKeterangan'])->name('surat.keterangan');
});

// AJAX Routes for dynamic dropdowns (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/kegiatan/{programId}', [SkpdDashboardController::class, 'getKegiatan'])->name('kegiatan.get');
    Route::get('/subkegiatan/{kegiatanId}', [SkpdDashboardController::class, 'getSubkegiatan'])->name('subkegiatan.get');
    Route::get('/get-kode-barang', [SkpdDashboardController::class, 'getKodeBarang'])->name('kode-barang.get');
    Route::post('/store-sebelum', [SkpdDashboardController::class, 'storeSebelum'])->name('sebelum.store');
    Route::delete('/sebelum/{id}', [SkpdDashboardController::class, 'destroySebelum'])->name('sebelum.destroy');
    Route::post('/store-sesudah', [SkpdDashboardController::class, 'storeSesudah'])->name('sesudah.store');
    Route::delete('/sesudah/{id}', [SkpdDashboardController::class, 'destroySesudah'])->name('sesudah.destroy');
    Route::post('/kirim-pergeseran', [SkpdDashboardController::class, 'kirimPergeseran'])->name('pergeseran.kirim');
});

// Pimpinan Routes (Protected for Pimpinan role)
Route::prefix('pimpinan')->middleware('auth')->name('pimpinan.')->group(function () {
    Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PimpinanController::class, 'profile'])->name('profile');
    Route::get('/pergeseran/{id}', [PimpinanController::class, 'showPergeseran'])->name('pergeseran.show');
});

// Pimpinan AJAX Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::post('/pimpinan/approve-pergeseran', [PimpinanController::class, 'approvePergeseran'])->name('pimpinan.approve');
    Route::post('/pimpinan/reject-pergeseran', [PimpinanController::class, 'rejectPergeseran'])->name('pimpinan.reject');
});

// BPKPAD Routes (Protected for BPKPAD role)
Route::prefix('bpkpad')->middleware('auth')->name('bpkpad.')->group(function () {
    Route::get('/dashboard', [BpkpadController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [BpkpadController::class, 'profile'])->name('profile');
    Route::put('/profile', [BpkpadController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [BpkpadController::class, 'updatePassword'])->name('password.update');
    Route::get('/pergeseran/{id}', [BpkpadController::class, 'showPergeseran'])->name('pergeseran.show');
});

// BPKPAD AJAX Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::post('/bpkpad/approve-pergeseran', [BpkpadController::class, 'approvePergeseran'])->name('bpkpad.approve');
    Route::post('/bpkpad/reject-pergeseran', [BpkpadController::class, 'rejectPergeseran'])->name('bpkpad.reject');
});
