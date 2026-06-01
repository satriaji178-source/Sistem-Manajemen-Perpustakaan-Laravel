@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container my-5">
    <h2 class="mb-4"><i class="fa-solid fa-chart-line text-primary me-2"></i>Dashboard Sistem Perpustakaan</h2>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white font-weight-bold py-3">
            <h5 class="mb-0"><i class="fa-solid fa-link text-secondary me-2"></i>Quick Links</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="/" class="btn btn-outline-secondary"><i class="fa-solid fa-house me-1"></i> Home</a>
                <a href="/dashboard" class="btn btn-primary"><i class="fa-solid fa-gauge me-1"></i> Dashboard</a>
                <a href="/buku" class="btn btn-outline-success"><i class="fa-solid fa-book me-1"></i> Kelola Buku</a>
                <a href="/anggota" class="btn btn-outline-info text-dark"><i class="fa-solid fa-users me-1"></i> Kelola Anggota</a>
                <a href="/transaksi" class="btn btn-outline-warning text-dark"><i class="fa-solid fa-exchange-alt me-1"></i> Transaksi</a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card h-100 shadow-sm border-0 border-start border-primary border-4">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase small"><i class="fa-solid fa-book-open me-2"></i>Statistik Buku</h5>
                    <div class="row align-items-center mt-3">
                        <div class="col-4 border-end text-center">
                            <h3 class="fw-bold mb-0 text-primary">{{ $totalBuku }}</h3>
                            <span class="text-muted small">Total Buku</span>
                        </div>
                        <div class="col-4 border-end text-center">
                            <h3 class="fw-bold mb-0 text-success">{{ $bukuTersedia }}</h3>
                            <span class="text-muted small">Tersedia</span>
                        </div>
                        <div class="col-4 text-center">
                            <h3 class="fw-bold mb-0 text-danger">{{ $bukuHabis }}</h3>
                            <span class="text-muted small">Habis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100 shadow-sm border-0 border-start border-info border-4">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase small"><i class="fa-solid fa-user-group me-2"></i>Statistik Anggota</h5>
                    <div class="row align-items-center mt-3">
                        <div class="col-4 border-end text-center">
                            <h3 class="fw-bold mb-0 text-info">{{ $totalAnggota }}</h3>
                            <span class="text-muted small">Total Anggota</span>
                        </div>
                        <div class="col-4 border-end text-center">
                            <h3 class="fw-bold mb-0 text-success">{{ $anggotaAktif }}</h3>
                            <span class="text-muted small">Aktif</span>
                        </div>
                        <div class="col-4 text-center">
                            <h3 class="fw-bold mb-0 text-secondary">{{ $anggotaNonaktif }}</h3>
                            <span class="text-muted small">Nonaktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-dark fw-semibold"><i class="fa-solid fa-plus-circle text-success me-2"></i>5 Buku Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuTerbaru as $buku)
                            <tr>
                                <td class="fw-bold text-muted">{{ $buku->kode_buku }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $buku->judul }}</div>
                                    <small class="text-muted">{{ $buku->pengarang }}</small>
                                </td>
                                <td>{{ $buku->stok }}</td>
                                <td>{!! $buku->status_stok_badge !!}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada data buku.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-dark fw-semibold"><i class="fa-solid fa-user-plus text-info me-2"></i>5 Anggota Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggotaTerbaru as $agt)
                            <tr>
                                <td class="fw-bold text-muted">{{ $agt->kode_anggota }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $agt->nama }}</div>
                                    <small class="text-muted">{{ $agt->email }}</small>
                                </td>
                                <td>{{ $agt->tanggal_daftar->format('d M Y') }}</td>
                                <td>{!! $agt->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada data anggota.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection