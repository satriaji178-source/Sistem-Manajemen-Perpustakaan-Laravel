<?php
 
use Illuminate\Support\Facades\Route;
 
// Route default
Route::get('/', function () {
    return view('welcome');
});
 
// Route baru - return text
Route::get('/hello', function () {
    return 'Hello dari Laravel!';
});
 
// Route dengan HTML
Route::get('/info', function () {
    return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
});
 
// Route dengan JSON
Route::get('/buku', function () {
    return [
        'judul' => 'Laravel Programming',
        'pengarang' => 'John Doe',
        'harga' => 150000
    ];
});