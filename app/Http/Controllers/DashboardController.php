<?php

namespace App\Http\Controllers;

use illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::tersedia()->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::aktif()->count();
        $anggotaNonaktif = Anggota::where('status', '!=', 'Aktif')->count();

        $bukuTerbaru = Buku::latest()->take(5)->get();
        $anggotaTerbaru = Anggota::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalBuku', 
            'bukuTersedia', 
            'bukuHabis',
            'totalAnggota', 
            'anggotaAktif', 
            'anggotaNonaktif',
            'bukuTerbaru', 
            'anggotaTerbaru'
        ));
    }
}