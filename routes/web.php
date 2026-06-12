<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;

// Route untuk halaman pencarian buku
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');

// Custom route untuk filter kategori
Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
     ->name('buku.kategori');

// Custom route untuk export buku ke Excel
Route::get('/buku/export', [BukuController::class, 'export'])
     ->name('buku.export');

// Route untuk bulk delete buku
Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
    ->name('buku.bulk-delete');

Route::delete('/buku/bulk-delete', [BukuController::class, 'bulkDelete']);

// Resource route untuk Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', function () {
    return view('home');
})->name('home');

// Resource route untuk Buku
Route::resource('buku', BukuController::class);
 
// Route untuk export anggota ke Excel
Route::get('anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');

// Route untuk fitur pencarian anggota
Route::get('anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');

// Resource route untuk Anggota
Route::resource('anggota', AnggotaController::class);