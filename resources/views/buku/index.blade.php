@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>
</div>

{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TUGAS 3: Form Search & Filter Advanced --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
        <h6 class="card-title mb-3 text-secondary">
            <i class="bi bi-sliders"></i> Pencarian & Filter Advanced
        </h6>
        
        <form action="{{ route('buku.search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Kata Kunci</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="keyword" class="form-control" placeholder="Judul, pengarang, atau penerbit..." value="{{ request('keyword') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach(['Programming', 'Database', 'Web Design', 'Networking', 'Data Science'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat || (isset($kategori) && $kategori == $kat) ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Tahun Terbit</label>
                    <select name="tahun_terbit" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach(($daftarTahun ?? []) as $thn)
                            <option value="{{ $thn }}" {{ request('tahun_terbit') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Status Stok</label>
                    <select name="ketersediaan" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('ketersediaan') == 'tersedia' ? 'selected' : '' }}>Tersedia (Stok > 0)</option>
                        <option value="habis" {{ request('ketersediaan') == 'habis' ? 'selected' : '' }}>Habis (Stok = 0)</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-secondary px-3"><i class="bi bi-arrow-counterclockwise"></i> Reset Filter</a>
                <button type="submit" class="btn btn-sm btn-primary px-4"><i class="bi bi-funnel-fill"></i> Terapkan</button>
            </div>
        </form>
    </div>
</div>

{{-- Filter Kategori Cepat (Bawaan Sebelumnya) --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title">
            <i class="bi bi-funnel"></i> Filter Kategori Cepat:
        </h6>
        <div class="btn-group flex-wrap" role="group">
            <a href="{{ route('buku.index') }}" class="btn btn-sm {{ !isset($kategori) ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua
            </a>
            <a href="{{ route('buku.kategori', 'Programming') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">
                Programming
            </a>
            <a href="{{ route('buku.kategori', 'Database') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">
                Database
            </a>
            <a href="{{ route('buku.kategori', 'Web Design') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">
                Web Design
            </a>
            <a href="{{ route('buku.kategori', 'Networking') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">
                Networking
            </a>
            <a href="{{ route('buku.kategori', 'Data Science') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">
                Data Science
            </a>
        </div>
    </div>
</div>

{{-- TUGAS 2 & 3: Tampilan Katalog Buku Menggunakan Reusable Component Grid --}}
<div class="row">
    @forelse ($bukus as $buku)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            {{-- Mengakses Blade Component BukuCard yang kita buat di Tugas 2 --}}
            <x-buku-card :buku="$buku" :showActions="true" />
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                Tidak ada data buku yang cocok dengan kriteria pencarian kamu.
                @isset($kategori)
                    dengan kategori <strong>{{ $kategori }}</strong>
                @endisset
            </div>
        </div>
    @endforelse
</div>

@if ($bukus->count() > 0)
    <div class="text-center mt-2 mb-5">
        <p class="text-muted small">
            Menampilkan {{ $bukus->count() }} buku 
            @if(request()->filled('keyword')) dengan kata kunci "{{ request('keyword') }}" @endif
            @isset($kategori) dari kategori <strong>{{ $kategori }}</strong> @endisset
        </p>
    </div>
@endif
@endsection