@php
    // Memetakan ikon Bootstrap Icons secara dinamis berdasarkan kategori buku
    $icon = match($buku->kategori) {
        'Programming'  => 'bi-code-slash text-primary',
        'Database'     => 'bi-database-fill text-warning',
        'Web Design'   => 'bi-laptop text-info',
        'Networking'   => 'bi-globe2 text-success',
        'Data Science' => 'bi-cpu text-danger',
        default        => 'bi-book text-secondary'
    };
@endphp

<div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="bg-light d-flex align-items-center justify-content-center py-4 border-bottom position-relative" style="min-height: 140px;">
        <i class="bi {{ $icon }}" style="font-size: 3.5rem;"></i>
        
        <span class="position-absolute top-0 start-0 m-2 badge bg-dark text-uppercase small">
            {{ $buku->kategori }}
        </span>

        <div class="position-absolute top-0 end-0 m-2">
            {!! $buku->status_stok_badge !!}
        </div>
    </div>

    <div class="card-body d-flex flex-column p-3">
        <span class="text-muted small fw-bold mb-1">{{ $buku->kode_buku }}</span>
        <h5 class="card-title fw-bold text-dark text-truncate mb-1" title="{{ $buku->judul }}">
            {{ $buku->judul }}
        </h5>
        <p class="text-secondary small mb-3">
            <i class="bi bi-person text-muted me-1"></i> {{ $buku->pengarang }} 
            <span class="mx-1">•</span> 
            <span class="text-muted">{{ $buku->tahun_terbit }}</span>
        </p>

        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted d-block" style="font-size: 0.75rem;">Harga</small>
                <span class="fw-bold text-success">{{ $buku->harga_format }}</span>
            </div>
            <div class="text-end">
                <small class="text-muted d-block" style="font-size: 0.75rem;">Sisa Stok</small>
                <span class="fw-semibold {{ $buku->stok > 0 ? 'text-dark' : 'text-danger fw-bold' }}">
                    {{ $buku->stok }} eks
                </span>
            </div>
        </div>
    </div>

    @if($showActions)
        <div class="card-footer bg-white border-0 pb-3 pt-0 px-3">
    <div class="row g-2">
        <div class="col-4">
            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-info btn-sm w-100 rounded-2 text-dark text-truncate">
                <i class="bi bi-eye"></i> Detail
            </a>
        </div>
        
        <div class="col-4">
            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm w-100 rounded-2 text-truncate">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
        
        <div class="col-4">
            <form action="{{ route('buku.destroy', $buku->id) }}" 
                method="POST" 
                class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger w-100 btn-delete" 
                        data-judul="{{ $buku->judul }}">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
            
            @push('scripts')
            <script>
                // SweetAlert confirmation untuk delete
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('form');
                        const judul = this.getAttribute('data-judul');
                        
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
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            </script>
            @endpush
        </div>
    </div>
</div>
    @endif
</div>