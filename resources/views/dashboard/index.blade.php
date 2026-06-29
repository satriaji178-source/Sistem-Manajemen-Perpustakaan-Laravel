@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold fs-4 text-dark m-0">
            {{ __('Dashboard Perpustakaan') }}
        </h2>
    </div>

    <div class="row mt-4">
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="display-4 me-3">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-uppercase small" style="opacity: 0.8;">Buku Terlambat</h6>
                        <h2 class="fw-bold mb-0">{{ $jumlahTransaksiTerlambat }} Transaksi</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0"><i class="fa fa-users text-danger me-2"></i> Daftar Anggota Terlambat Mengembalikan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Nama Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tenggat</th>
                                    <th>Keterlambatan</th>
                                    <th>Denda</th>
                                    <th style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerlambat as $item)
                                    @php
                                        $hariTerlambat = \Carbon\Carbon::parse($item->tanggal_kembali)->diffInDays(\Carbon\Carbon::today());
                                    @endphp
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $item->anggota->nama ?? '-' }}</td>
                                        <td>{{ $item->buku->judul ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                                        <td class="text-danger fw-bold">
                                            <span class="badge bg-danger">Terlambat {{ $hariTerlambat }} Hari</span>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            Rp {{ number_format($hariTerlambat * 5000, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('transaksi.show', $item->id) }}" 
                                                class="btn btn-sm btn-info text-white px-3">
                                                 <i class="bi bi-eye"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">🎉 Luar biasa! Tidak ada buku yang terlambat saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary rounded p-3">
                        <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted small mb-1 fw-medium">Total Buku</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Buku::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 text-success rounded p-3">
                        <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted small mb-1 fw-medium">Total Anggota</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Anggota::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning rounded p-3">
                        <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted small mb-1 fw-medium">Dipinjam</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Transaksi::where('status', 'Dipinjam')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 text-info rounded p-3">
                        <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted small mb-1 fw-medium">Transaksi Hari Ini</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Transaksi::whereDate('created_at', today())->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4">Aksi Cepat</h5>
            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('buku.create') }}" class="d-flex align-items-center p-3 bg-primary bg-opacity-10 border border-primary border-opacity-10 rounded text-decoration-none transition-hover">
                        <svg class="bi text-primary me-3" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="fw-semibold text-primary">Tambah Buku</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('anggota.create') }}" class="d-flex align-items-center p-3 bg-success bg-opacity-10 border border-success border-opacity-10 rounded text-decoration-none transition-hover">
                        <svg class="bi text-success me-3" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span class="fw-semibold text-success">Tambah Anggota</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('transaksi.create') }}" class="d-flex align-items-center p-3 bg-warning bg-opacity-10 border border-warning border-opacity-10 rounded text-decoration-none transition-hover">
                        <svg class="bi text-warning me-3" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span class="fw-semibold text-warning-emphasis">Pinjam Buku</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('transaksi.index') }}" class="d-flex align-items-center p-3 bg-info bg-opacity-10 border border-info border-opacity-10 rounded text-decoration-none transition-hover">
                        <svg class="bi text-info me-3" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="fw-semibold text-info-emphasis">Lihat Transaksi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4">Transaksi Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary text-uppercase fs-7 fw-bold">Kode</th>
                            <th class="px-4 py-3 text-secondary text-uppercase fs-7 fw-bold">Anggota</th>
                            <th class="px-4 py-3 text-secondary text-uppercase fs-7 fw-bold">Buku</th>
                            <th class="px-4 py-3 text-secondary text-uppercase fs-7 fw-bold">Tanggal Pinjam</th>
                            <th class="px-4 py-3 text-secondary text-uppercase fs-7 fw-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Transaksi::with(['anggota', 'buku'])->latest()->take(5)->get() as $transaksi)
                        <tr>
                            <td class="px-4 py-3 fw-medium text-dark">{{ $transaksi->kode_transaksi }}</td>
                            <td class="px-4 py-3 text-muted">{{ $transaksi->anggota->nama }}</td>
                            <td class="px-4 py-3 text-muted">{{ $transaksi->buku->judul }}</td>
                            <td class="px-4 py-3 text-muted">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="badge rounded-pill px-3 py-2 fs-7 {{ $transaksi->status == 'Dipinjam' ? 'bg-warning bg-opacity-10 text-warning-emphasis' : 'bg-success bg-opacity-10 text-success-emphasis' }}">
                                    {{ $transaksi->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Sedikit styling tambahan untuk efek hover agar interaksi terasa hidup */
    .transition-hover:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }
    .fs-7 {
        font-size: 0.75rem;
    }
</style>
@endsection