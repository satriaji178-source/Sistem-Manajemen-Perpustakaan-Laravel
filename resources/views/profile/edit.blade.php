@extends('layouts.app')

@section('header')
    <div class="d-flex align-items-center py-3">
        <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.002 6a7 7 0 0 1 5.034 2.246.5.5 0 0 1-.393.754H3.356a.5.5 0 0 1-.393-.754 7 7 0 0 1 5.038-2.246"/>
                <path fill-rule="evenodd" d="M12.896 11.062a.5.5 0 0 1 .196.423v.53a.5.5 0 0 1-.361.48l-.75.25a.5.5 0 0 1-.52-.124l-.347-.346a.5.5 0 0 0-.707 0l-.346.346a.5.5 0 0 1-.52.124l-.75-.25a.5.5 0 0 1-.36-.48v-.53a.5.5 0 0 1 .195-.423l.422-.316a.5.5 0 0 0 .142-.616l-.21-.42a.5.5 0 0 0-.616-.252l-.634.212a.5.5 0 0 1-.57-.184l-.314-.471a.5.5 0 0 1 .05-.62l.443-.444a.5.5 0 0 0 0-.707l-.443-.443a.5.5 0 0 1-.05-.62l.314-.471a.5.5 0 0 1 .57-.184l.634.212a.5.5 0 0 0 .616-.252l.21-.42a.5.5 0 0 0-.142-.616l-.422-.316a.5.5 0 0 1-.195-.423v-.53a.5.5 0 0 1 .36-.48l.75-.25a.5.5 0 0 1 .52.124l.346.346a.5.5 0 0 0 .707 0l.347-.346a.5.5 0 0 1 .52-.124l.75.25a.5.5 0 0 1 .36.48v.53a.5.5 0 0 1-.195.423l-.422.316a.5.5 0 0 0-.142.616l.21.42a.5.5 0 0 0 .616.252l.634-.212a.5.5 0 0 1 .57.184l.314.471a.5.5 0 0 1-.05.62l-.443.444a.5.5 0 0 0 0 .707l.443.443a.5.5 0 0 1 .05.62l-.314.471a.5.5 0 0 1-.57.184l-.634-.212a.5.5 0 0 0-.616.252l-.21.42a.5.5 0 0 0 .142.616z"/>
            </svg>
        </div>
        <div>
            <h2 class="h4 mb-0 fw-bold text-dark">{{ __('Pengaturan Profil') }}</h2>
            <small class="text-muted">Kelola informasi akun dan keamanan Anda di sini.</small>
        </div>
    </div>
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-4 justify-content-center">
        
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=0D6EFD&color=fff" class="rounded-circle img-thumbnail shadow-sm" width="100" alt="Avatar">
                    </div>
                    <h5 class="fw-bold mb-1">{{ auth()->user()->name ?? 'Nama Pengguna' }}</h5>
                    <p class="text-muted small mb-0">{{ auth()->user()->email ?? 'email@domain.com' }}</p>
                </div>
                <div class="list-group list-group-flush border-top small">
                    <a href="#profile-info" class="list-group-item list-group-item-action p-3 text-primary fw-medium">
                        <i class="bi bi-person me-2"></i> Informasi Profil
                    </a>
                    <a href="#update-password" class="list-group-item list-group-item-action p-3">
                        <i class="bi bi-shield-lock me-2"></i> Ubah Password
                    </a>
                    <a href="#delete-account" class="list-group-item list-group-item-action p-3 text-danger">
                        <i class="bi bi-trash me-2"></i> Hapus Akun
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="d-flex flex-column gap-4">
                
                <div id="profile-info" class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-sm-5">
                        <div class="border-bottom pb-3 mb-4">
                            <h4 class="fw-bold text-dark mb-1">Informasi Profil</h4>
                            <p class="text-muted small mb-0">Perbarui nama lengkap dan alamat email akun Anda.</p>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div id="update-password" class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-sm-5">
                        <div class="border-bottom pb-3 mb-4">
                            <h4 class="fw-bold text-dark mb-1">Keamanan Akun</h4>
                            <p class="text-muted small mb-0">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div id="delete-account" class="card border-0 shadow-sm rounded-4 border-start border-danger border-4">
                    <div class="card-body p-4 p-sm-5">
                        <div class="border-bottom pb-3 mb-4">
                            <h4 class="fw-bold text-danger mb-1">Hapus Akun</h4>
                            <p class="text-muted small mb-0">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection