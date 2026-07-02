<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC ROUTES (Tanpa Autentikasi)
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// PROTECTED ROUTES (Wajib Login / Auth)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Global Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // --- Profile System ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Fitur Kustom Buku (Wajib di atas Resource) ---
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');
    Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
    Route::delete('/buku/bulk-delete', [BukuController::class, 'bulkDelete']);
    
    // --- CRUD Buku Resource ---
    Route::resource('buku', BukuController::class);

    // --- Fitur Kustom Anggota (Wajib di atas Resource) ---
    Route::get('anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
    
    // --- CRUD Anggota Resource ---
    Route::resource('anggota', AnggotaController::class);

    // ROUTE HOME
    Route::get('/', function () 
    {
        return view('home');
    })->name('home');

    //Laporan Transaksi
    Route::get('/laporan/transaksi', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');

    //Laporan Cetak PDF
    Route::get('/laporan/transaksi/pdf', [TransaksiController::class, 'cetakPDF'])->name('transaksi.cetakPDF');

    // --- Transaksi - CRUD + Custom Routes ---
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');

    //Route Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

});

require __DIR__.'/auth.php';