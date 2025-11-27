@extends('layouts.app')

@section('title', 'Data Penduduk - Neo System')
@section('page-title', 'Data Penduduk')
@section('page-subtitle', 'Kelola data kependudukan dengan mudah dan efisien')
@section('add-route', route('penduduk.create'))

@section('content')
<div class="container mb-5">

    <!-- Search + Filter Gender -->
    <div class="glass-card mb-4 p-3">
        <form action="{{ route('penduduk.index') }}" method="GET" class="row g-2">

            <!-- Search -->
            <div class="col-md-6">
                <input type="text" name="search" class="form-control neo-input"
                       placeholder="Cari nama, NIK, atau nomor telepon..."
                       value="{{ request('search') }}">
            </div>

            <!-- Filter Gender -->
            <div class="col-md-4">
                <select name="gender" class="form-control neo-input">
                    <option value="">-- Filter Jenis Kelamin --</option>
                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Tombol Cari -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-neo-primary w-100">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>

        </form>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $penduduks->total() }}</div>
                <div class="stats-label">Total Penduduk</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $penduduks->where('gender', 'L')->count() }}</div>
                <div class="stats-label">Laki-laki</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $penduduks->where('gender', 'P')->count() }}</div>
                <div class="stats-label">Perempuan</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $penduduks->total() }}</div>
                <div class="stats-label">Dalam Sistem</div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-neo-success mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-neo-danger mb-4">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Data Table -->
    <div class="glass-card">
        <div class="card-body p-0">
            @if($penduduks->count() > 0)
            <div class="table-responsive">
                <table class="table table-neo mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Lengkap</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>NIK</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penduduks as $penduduk)
                        <tr>
                            <td>{{ $penduduks->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $penduduk->first_name }} {{ $penduduk->last_name }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($penduduk->birthday)->format('d M Y') }}</td>
                            <td>
                                <span class="badge-gender {{ $penduduk->gender == 'L' ? 'badge-male' : 'badge-female' }}">
                                    {{ $penduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td>
                                @if($penduduk->nik)
                                    <i class="fas fa-id-card me-1 text-muted"></i> {{ $penduduk->nik }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($penduduk->phone)
                                    <i class="fas fa-phone me-1 text-muted"></i> {{ $penduduk->phone }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-neo-warning btn-sm" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('penduduk.destroy', $penduduk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-neo-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Enhanced Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div class="pagination-info text-muted">
                        Menampilkan {{ $penduduks->firstItem() ?? 0 }} - {{ $penduduks->lastItem() ?? 0 }} dari {{ $penduduks->total() }} data
                    </div>
                    <nav aria-label="Navigasi data penduduk">
                        <ul class="pagination pagination-neo mb-0">
                            <!-- Previous Page Link -->
                            @if ($penduduks->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $penduduks->withQueryString()->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($penduduks->getUrlRange(1, $penduduks->lastPage()) as $page => $url)
                                @if ($page == $penduduks->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $penduduks->withQueryString()->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($penduduks->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $penduduks->withQueryString()->nextPageUrl() }}" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>

            </div>
            @else
            <div class="empty-state text-center p-4">
                <i class="fas fa-users fa-3x mb-3"></i>
                <h4>Belum Ada Data Penduduk</h4>
                <p>Mulai dengan menambahkan data penduduk pertama Anda</p>
                <a href="{{ route('penduduk.create') }}" class="btn btn-neo-primary mt-3">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Data Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
