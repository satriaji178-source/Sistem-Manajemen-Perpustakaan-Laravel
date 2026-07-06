@extends('layouts.app')
@section('title', 'Dashboard')
 
@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Dashboard Perpustakaan</h2>
 
    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['Total Buku', $stats['total_buku'], 'bi-book', 'primary'],
            ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'success'],
            ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'info'],
            ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'danger'],
            ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'warning'],
            ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'secondary'],
            ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'dark'],
            ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash', 'danger'],
        ] as [$label, $value, $icon, $color])
        <div class="col-xl-3 col-md-6">
            <div class="card border-{{ $color }} h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi {{ $icon }} fs-1 text-{{ $color }} me-3"></i>
                    <div>
                        <h6 class="text-muted mb-1">{{ $label }}</h6>
                        <h4 class="mb-0">{{ $value }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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
    </div>

    <!-- Quick Links -->
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
                <a href="/laporan" class="btn btn-outline-danger"><i class="fa-solid fa-file-alt me-1"></i> Laporan</a>
            </div>
        </div>
    </div>
 
    {{-- Charts --}}
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Transaksi 6 Bulan Terakhir</div>
                <div class="card-body">
                    <canvas id="chartTransaksi" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Top 5 Buku Populer</div>
                <div class="card-body">
                    <canvas id="chartBuku" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
 
    {{-- Recent Transactions --}}
    <div class="card">
        <div class="card-header">Transaksi Terbaru</div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th><th>Anggota</th><th>Buku</th>
                        <th>Tgl Pinjam</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransaksi as $trx)
                    <tr>
                        <td>{{ $trx->kode_transaksi }}</td>
                        <td>{{ $trx->anggota->nama }}</td>
                        <td>{{ $trx->buku->judul }}</td>
                        <td>{{ $trx->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $trx->status === 'Dipinjam' ? 'warning' : 'success' }}">
                                {{ $trx->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
 
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Line chart — Transaksi 6 bulan terakhir
new Chart(document.getElementById('chartTransaksi'), {
    type: 'line',
    data: {
        labels: @json($chartData->pluck('bulan')),
        datasets: [
            { label: 'Peminjaman', data: @json($chartData->pluck('pinjam')),
              borderColor: '#0d6efd', tension: 0.3 },
            { label: 'Pengembalian', data: @json($chartData->pluck('kembali')),
              borderColor: '#198754', tension: 0.3 }
        ]
    },
    options: { responsive: true }
});
 
// Pie chart — Buku Populer
new Chart(document.getElementById('chartBuku'), {
    type: 'pie',
    data: {
        labels: @json($bukuPopuler->pluck('judul')),
        datasets: [{
            data: @json($bukuPopuler->pluck('transaksis_count')),
            backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1']
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
@endsection

