<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\LetterArchiveController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Welcome page with SIADESA showcase
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Dashboard (main application)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Incoming Letters (Surat Masuk)
    Route::resource('incoming-letters', IncomingLetterController::class);
    
    // Outgoing Letters (Surat Keluar)
    Route::resource('outgoing-letters', OutgoingLetterController::class);
    
    // Dispositions (Disposisi)
    Route::resource('dispositions', DispositionController::class);
    
    // Letter Archives (Arsip Surat)
    Route::resource('archives', LetterArchiveController::class);
    
    // User Management (Manajemen Pengguna)
    Route::resource('users', UserManagementController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';