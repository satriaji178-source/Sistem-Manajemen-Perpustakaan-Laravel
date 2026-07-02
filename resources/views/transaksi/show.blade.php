@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $transaksi->kode_transaksi }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fa fa-file-text-o me-2"></i> Detail Transaksi</h5>
                </div>
                <div class="card-body py-4">
                    @if($transaksi->status == 'Dipinjam')
                        @php
                            $hariIni = \Carbon\Carbon::today();
                            $deadline = \Carbon\Carbon::parse($transaksi->tanggal_kembali);
                            $selisihHari = $deadline->diffInDays($hariIni, false);
                        @endphp

                        @if($selisihHari > 0)
                            <div class="alert alert-danger d-flex align-items-center border-0 shadow-sm mb-4" role="alert">
                                <div class="display-6 me-3"><i class="fa fa-exclamation-circle animate__animated animate__flash animate__infinite"></i></div>
                                <div>
                                    <h5 class="alert-heading fw-bold mb-1">PERINGATAN: Transaksi Mengalami Keterlambatan!</h5>
                                    <p class="mb-0">Buku ini seharusnya sudah dikembalikan pada <strong>{{ $deadline->format('d F Y') }}</strong>. Anggota bersangkutan telah terlambat selama <span class="badge bg-danger fw-bold fs-6">{{ $selisihHari }} hari</span> dan denda berjalan akan terus diakumulasikan sebesar Rp 5.000/hari saat pengembalian diproses.</p>
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    <div class="text-center mb-4">
                        <div class="display-4 text-muted mb-2">
                            <i class="fa fa-exchange text-success"></i>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $transaksi->kode_transaksi }}</h4>
                        <span class="badge rounded-pill px-3 py-2 {{ $transaksi->status == 'Dikembalikan' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $transaksi->status == 'Dikembalikan' ? 'Buku Sudah Kembali' : 'Sedang Dipinjam' }}
                        </span>
                    </div>

                    <hr>

                    <div class="px-3">
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-user me-2"></i> Nama Peminjam</div>
                            <div class="col-sm-8">: {{ $transaksi->anggota->nama ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-book me-2"></i> Judul Buku</div>
                            <div class="col-sm-8">: {{ $transaksi->buku->judul ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-calendar me-2"></i> Tanggal Pinjam</div>
                            <div class="col-sm-8">: {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d F Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-calendar-check-o me-2"></i> Tenggat Kembali</div>
                            <div class="col-sm-8">: {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d F Y') }}</div>
                        </div>

                        @if($transaksi->status == 'Dipinjam')
                            @php
                                $hariIni = \Carbon\Carbon::today();
                                $deadline = \Carbon\Carbon::parse($transaksi->tanggal_kembali);
                                $terlambat = $deadline->diffInDays($hariIni, false);
                                $dendaEstimasi = 0;
                                if ($terlambat > 0) {
                                    $dendaEstimasi = $terlambat * 5000;
                                }
                            @endphp
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-money me-2"></i> Estimasi Denda</div>
                                <div class="col-sm-8 text-danger fw-bold">
                                    : @if($dendaEstimasi > 0)
                                        Rp {{ number_format($dendaEstimasi, 0, ',', '.') }} <span class="badge bg-danger ms-2">Terlambat {{ $terlambat }} hari</span>
                                      @else
                                        Rp 0 <span class="badge bg-info ms-2 text-dark">Belum terlambat</span>
                                      @endif
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold text-secondary">
                                    <i class="fa fa-calendar-times-o me-2"></i> Tanggal Dikembalikan
                                </div>
                                <div class="col-sm-8">
                                    : {{ $transaksi->tanggal_dikembalikan ? \Carbon\Carbon::parse($transaksi->tanggal_dikembalikan)->timezone('Asia/Jakarta')->translatedFormat('d F Y') : '-' }}
                                </div>
                            </div> 
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-money me-2"></i> Total Denda Dibayar</div>
                                <div class="col-sm-8 text-success fw-bold">
                                    : Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        @if($transaksi->keterangan)
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold text-secondary"><i class="fa fa-info-circle me-2"></i> Keterangan</div>
                                <div class="col-sm-8">: {{ $transaksi->keterangan }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-light text-muted small d-flex justify-content-between py-2">
                    <span><i class="fa fa-clock-o"></i> Input: {{ $transaksi->created_at ? $transaksi->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }} WIB</span>
                    <span><i class="fa fa-refresh"></i> Update: {{ $transaksi->updated_at ? $transaksi->updated_at->timezone('Asia/Jakarta')->format('d M Y H:i') : '-' }} WIB</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0"><i class="fa fa-cog me-2"></i> Aksi</h6>
                </div>
                <div class="card-body d-grid gap-2 py-3">
                    @if($transaksi->status == 'Dipinjam')
                        <form id="formKembalikan" action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-warning w-100 fw-bold py-2 text-dark" onclick="konfirmasiKembalikan()">
                                <i class="fa fa-undo me-2"></i> Kembalikan Buku
                            </button>
                            <div class="card mt-0 p-2 bg-light text-muted small">
                                <i class="fa fa-info-circle me-2"></i> <strong>Denda keterlambatan: Rp 5.000/hari</strong>
                            </div>
                        </form>
                    @endif

                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary py-2">
                        <i class="fa fa-arrow-left me-2"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Handler SweetAlert untuk konfirmasi klik tombol "Kembalikan Buku"
    function konfirmasiKembalikan() {
        Swal.fire({
            title: 'Proses Pengembalian?',
            text: "Pastikan buku yang dikembalikan sudah sesuai dengan data transaksi.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754', // Warna hijau Bootstrap
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<span style="color: #fff; font-weight: bold;">Ya, Kembalikan!</span>',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form secara programmatic jika user memilih opsi "Ya"
                document.getElementById('formKembalikan').submit();
            }
        });
    }
    </script>
@endsection