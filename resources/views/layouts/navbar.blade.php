<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid max-w-7xl px-md-4">
        <a class="navbar-brand d-flex align-items-center text-dark fw-bold fs-4" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top me-2 text-dark" style="height: 36px; width: auto;" />
            <span>Perpustakaan</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-3 ps-lg-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold border-bottom border-primary border-2' : '' }}" href="{{ route('home') }}">
                        {{ __('Home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold border-bottom border-primary border-2' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buku.*') ? 'active fw-semibold border-bottom border-primary border-2' : '' }}" href="{{ route('buku.index') }}">
                        {{ __('Buku') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('anggota.*') ? 'active fw-semibold border-bottom border-primary border-2' : '' }}" href="{{ route('anggota.index') }}">
                        {{ __('Anggota') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active fw-semibold border-bottom border-primary border-2' : '' }}" href="{{ route('transaksi.index') }}">
                        {{ __('Transaksi') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('transaksi.laporan') ? 'active fw-semibold border-bottom border-primary border-2' : '' }}" href="{{ route('transaksi.laporan') }}">
                        {{ __('Laporan Transaksi') }}
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav border-top border-lg-0 pt-2 pt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-secondary fw-medium" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="navbarDropdownMenuLink">
                        <li class="dropdown-header d-lg-none">
                            <div class="text-dark fw-bold">{{ Auth::user()->name }}</div>
                            <div class="text-muted small">{{ Auth::user()->email }}</div>
                            <hr class="dropdown-divider">
                        </li>
                        
                        <li>
                            <a class="dropdown-menu-item dropdown-item py-2" href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>