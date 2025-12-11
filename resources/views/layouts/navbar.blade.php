<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-cube me-2"></i>kependudukan-admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('penduduk.index') }}">Penduduk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orangtua.index') }}">Orang Tua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kelahiran.index') }}">Kelahiran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kematian.index') }}">Kematian</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
