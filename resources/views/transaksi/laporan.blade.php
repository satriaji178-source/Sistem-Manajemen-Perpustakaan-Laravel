@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fa fa-file-text me-2 text-success"></i> Laporan Transaksi</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('transaksi.cetakPDF', request()->query()) }}" class="btn btn-danger" target="_blank">
                <i class="bi bi-download"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-success text-white py-3">
            <h6 class="mb-0"><i class="fa fa-filter me-2"></i> Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.laporan') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Anggota</label>
                        <select name="anggota_id" class="form-select">
                            <option value="">Semua Anggota</option>
                            @foreach($anggotas as $agt)
                                <option value="{{ $agt->id }}" {{ request('anggota_id') == $agt->id ? 'selected' : '' }}>{{ $agt->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('transaksi.laporan') }}" class="btn btn-secondary px-3"><i class="fa fa-refresh"></i> Reset</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fa fa-search"></i> Cari Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-light border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="display-6 text-primary me-3"><i class="fa fa-exchange"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Total Transaksi</h6>
                        <h4 class="fw-bold mb-0">{{ $totalTransaksi }} Data</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="display-6 text-danger me-3"><i class="fa fa-money"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Total Akumulasi Denda</h6>
                        <h4 class="fw-bold mb-0 text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3" style="width: 5%">No</th>
                            <th>Kode</th>
                            <th>Nama Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tenggat</th>
                            <th>Status</th>
                            <th class="pe-3 text-end">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $item)
                        <tr>
                            <td class="ps-3">{{ $index + 1 }}</td>
                            <td class="fw-bold text-success">{{ $item->kode_transaksi }}</td>
                            <td>{{ $item->anggota->nama ?? '-' }}</td>
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $item->status == 'Dikembalikan' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="pe-3 text-end fw-bold {{ $item->denda > 0 ? 'text-danger' : 'text-muted' }}">
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Data transaksi tidak ditemukan sesuai kriteria filter.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection