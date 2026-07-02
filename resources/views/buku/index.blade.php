@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('buku.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Export Excel
        </a>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    </div>
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
                    <label class="form-label small fw-bold text-muted">Stok</label>
                    <select name="stok" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis</option>
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

{{-- FORM BULK DELETE DENGAN METHOD POST ASLI --}}
<form action="{{ route('buku.bulk-delete') }}" method="POST" id="form-bulk-delete" style="display: none;">
    @csrf
    <div id="bulk-delete-inputs"></div>
</form>

{{-- BAR UTAMA PILIH SEMUA BUKU --}}
@if ($bukus->count() > 0)
    <div class="card card-body mb-3 border-0 shadow-sm d-flex flex-row justify-content-between align-items-center py-2">
        <div class="form-check m-0">
            <input type="checkbox" id="select-all" class="form-check-input" style="cursor: pointer;">
            <label class="form-check-label small fw-bold text-secondary" for="select-all" style="cursor: pointer;">Pilih Semua Buku</label>
        </div>
        {{-- PERUBAHAN UTAMA: Diubah ke type="button" agar tidak memicu submit form liar di browser --}}
        <button type="button" class="btn btn-sm btn-danger px-3 shadow-sm" id="btn-bulk-delete" disabled>
            <i class="bi bi-trash-fill"></i> Hapus yang Dipilih
        </button>
    </div>
@endif

{{-- GRID BUKU CARD --}}
<div class="row">
    @forelse ($bukus as $buku)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4 position-relative">
            <div class="position-absolute" style="top: 35px; left: 25px; z-index: 10;">
                {{-- Gunakan data attribute agar nilainya terisolasi dengan aman --}}
                <input type="checkbox" value="{{ $buku->id }}" class="form-check-input border-secondary cb-buku" style="transform: scale(1.3); cursor: pointer;">
            </div>
            
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const selectAllCheckbox = document.getElementById('select-all');
        const btnBulkDelete = document.getElementById('btn-bulk-delete');
        const formBulkDelete = document.getElementById('form-bulk-delete');
        const bulkInputsContainer = document.getElementById('bulk-delete-inputs');

        // Fungsi pengecekan status tombol hapus massal
        function toggleBulkDeleteButton() {
            const anyChecked = Array.from(document.querySelectorAll('.cb-buku')).some(cb => cb.checked);
            if (btnBulkDelete) {
                btnBulkDelete.disabled = !anyChecked;
            }
        }

        // 1. Aksi Select All
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                document.querySelectorAll('.cb-buku').forEach(cb => {
                    cb.checked = this.checked;
                });
                toggleBulkDeleteButton();
            });
        }

        // 2. Monitoring Checkbox Individu
        document.body.addEventListener('change', function (e) {
            if (e.target.classList.contains('cb-buku')) {
                toggleBulkDeleteButton();
                
                // Uncheck select all jika ada satu yang dilepas
                if (!e.target.checked && selectAllCheckbox) {
                    selectAllCheckbox.checked = false;
                }
            }
        });

        // 3. Eksekusi Tombol Bulk Delete Independen
        if (btnBulkDelete) {
            btnBulkDelete.addEventListener('click', function (e) {
                e.preventDefault();
                
                const checkedBoxes = document.querySelectorAll('.cb-buku:checked');
                const totalTerpilih = checkedBoxes.length;

                if (totalTerpilih === 0) return;

                Swal.fire({
                    title: 'Konfirmasi Hapus Massal',
                    text: `Apakah Anda yakin ingin menghapus ${totalTerpilih} buku yang Anda pilih secara permanen?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Bersihkan container input lama
                        bulkInputsContainer.innerHTML = '';

                        // Bangun ulang input hidden agar dibaca murni sebagai POST array data oleh Controller
                        checkedBoxes.forEach(cb => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'buku_ids[]';
                            input.value = cb.value;
                            bulkInputsContainer.appendChild(input);
                        });

                        // Submit form murni bypass tumpang tindih HTML
                        formBulkDelete.submit();
                    }
                });
            });
        }

        // 4. Integrasi Event Hapus Tunggal bawaan card Anda
        document.body.addEventListener('click', function (e) {
            const button = e.target.closest('.btn-delete');
            
            if (button) {
                e.preventDefault();
                const formSatuan = button.closest('form');
                const judul = button.getAttribute('data-judul') || 'buku ini';
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed && formSatuan) {
                        formSatuan.submit();
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection