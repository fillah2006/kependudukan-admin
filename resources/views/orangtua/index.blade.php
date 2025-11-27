@extends('layouts.app')

@section('title', 'Data Orang Tua - Neo System')
@section('page-title', 'Data Orang Tua')
@section('page-subtitle', 'Kelola data orang tua dengan mudah dan efisien')
@section('add-route', route('orangtua.create'))

@section('content')
<div class="container mb-5">

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $totalOrangTua }}</div>
                <div class="stats-label">Total Orang Tua</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $totalLakiLaki }}</div>
                <div class="stats-label">Laki-laki</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $totalPerempuan }}</div>
                <div class="stats-label">Perempuan</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $totalHidup }}</div>
                <div class="stats-label">Masih Hidup</div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-neo-success mb-4">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-neo-danger mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <form action="{{ route('orangtua.index') }}" method="GET" class="mb-4">
        <div class="row g-2">

            <!-- Search -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control neo-input"
                    placeholder="Cari nama atau NIK..."
                    value="{{ $search }}">
            </div>

            <!-- Filter Jenis Kelamin -->
            <div class="col-md-3">
                <select name="jenis_kelamin" class="form-select neo-input">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ $filterKelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $filterKelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Filter Status -->
            <div class="col-md-3">
                <select name="status" class="form-select neo-input">
                    <option value="">Semua Status</option>
                    <option value="hidup" {{ $filterStatus == 'hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="meninggal" {{ $filterStatus == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>

            <!-- Button -->
            <div class="col-md-2 d-grid">
                <button class="btn btn-neo-primary">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
        </div>
    </form>

    <!-- Data Table -->
    <div class="glass-card">
        <div class="card-body p-0">

            @if($orangTua->count() > 0)
                <div class="table-responsive">
                    <table class="table table-neo mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orangTua as $item)
                            <tr>
                                <td data-label="No">{{ $orangTua->firstItem() + $loop->index }}</td>

                                <td data-label="Nama Lengkap">
                                    <strong>{{ $item->nama }}</strong>
                                </td>

                                <td data-label="NIK">
                                    <i class="fas fa-id-card me-1 text-muted"></i>
                                    {{ $item->nik }}
                                </td>

                                <td data-label="Jenis Kelamin">
                                    <span class="badge-gender {{ $item->jenis_kelamin == 'L' ? 'badge-male' : 'badge-female' }}">
                                        {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>

                                <td data-label="Alamat">
                                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                    {{ \Illuminate\Support\Str::limit($item->alamat, 30) }}
                                </td>

                                <td data-label="No Telepon">
                                    <i class="fas fa-phone me-1 text-muted"></i>
                                    {{ $item->no_telepon }}
                                </td>

                                <td data-label="Status">
                                    <span class="badge-status {{ $item->status == 'hidup' ? 'badge-alive' : 'badge-deceased' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>

                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="{{ route('orangtua.edit', $item->id) }}"
                                            class="btn btn-neo-warning btn-sm" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('orangtua.destroy', $item->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                class="btn btn-neo-danger btn-sm" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div class="pagination-info text-muted">
                        Menampilkan {{ $orangTua->firstItem() ?? 0 }} - {{ $orangTua->lastItem() ?? 0 }} dari {{ $orangTua->total() }} data
                    </div>

                    <nav aria-label="Data navigation">
                        <ul class="pagination pagination-neo mb-0">

                            {{-- Previous Page --}}
                            @if ($orangTua->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orangTua->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($orangTua->getUrlRange(1, $orangTua->lastPage()) as $page => $url)
                                @if ($page == $orangTua->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page --}}
                            @if ($orangTua->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orangTua->nextPageUrl() }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                </li>
                            @endif

                        </ul>
                    </nav>
                </div>

            @else

                <!-- Empty State -->
                <div class="empty-state text-center p-4">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h4>Belum Ada Data Orang Tua</h4>
                    <p>Mulai dengan menambahkan data orang tua pertama Anda</p>
                    <a href="{{ route('orangtua.create') }}" class="btn btn-neo-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Data Pertama
                    </a>
                </div>

            @endif

        </div>
    </div>
</div>
@endsection
