@extends('layouts.app')

@section('title', 'Data Kelahiran - Neo System')
@section('page-title', 'Data Kelahiran')
@section('page-subtitle', 'Kelola data kelahiran dengan mudah dan efisien')
@section('add-route', route('kelahiran.create'))

@section('content')
<div class="container mb-5">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $totalKelahiran }}</div>
                <div class="stats-label">Total Kelahiran</div>
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
                <div class="stats-number">{{ $totalKelahiran }}</div>
                <div class="stats-label">Dalam Sistem</div>
            </div>
        </div>
    </div>

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

    <!-- Data Table -->
    <div class="glass-card">
        <div class="card-body p-0">
            @if($kelahiran->count() > 0)
                <div class="table-responsive">
                    <table class="table table-neo mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Bayi</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Nama Ayah</th>
                                <th>Nama Ibu</th>
                                <th>Orang Tua</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelahiran as $item)
                            <tr>
                                <td data-label="No">{{ $kelahiran->firstItem() + $loop->index }}</td>
                                <td data-label="Nama Bayi"><strong>{{ $item->nama_bayi }}</strong></td>
                                <td data-label="Tanggal Lahir">{{ $item->tanggal_lahir->format('d/m/Y') }}</td>
                                <td data-label="Jenis Kelamin">
                                    @if($item->jenis_kelamin == 'L')
                                        <span class="badge-gender badge-male">Laki-laki</span>
                                    @else
                                        <span class="badge-gender badge-female">Perempuan</span>
                                    @endif
                                </td>
                                <td data-label="Nama Ayah">{{ $item->nama_ayah }}</td>
                                <td data-label="Nama Ibu">{{ $item->nama_ibu }}</td>
                                <td data-label="Orang Tua">
                                    {{ $item->orangtua->nama ?? '-' }}
                                </td>
                                <td data-label="Aksi">
                                    <a href="{{ route('kelahiran.edit', $item->id) }}" class="btn btn-neo-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kelahiran.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus data?')" class="btn btn-neo-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div class="pagination-info text-muted">
                        Menampilkan {{ $kelahiran->firstItem() ?? 0 }} - {{ $kelahiran->lastItem() ?? 0 }} dari {{ $kelahiran->total() }} data
                    </div>
                    <nav aria-label="Data navigation">
                        <ul class="pagination pagination-neo mb-0">
                            <!-- Previous Page Link -->
                            @if ($kelahiran->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kelahiran->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($kelahiran->getUrlRange(1, $kelahiran->lastPage()) as $page => $url)
                                @if ($page == $kelahiran->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($kelahiran->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kelahiran->nextPageUrl() }}" rel="next">
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
            @else
                <div class="empty-state text-center p-4">
                    <i class="fas fa-baby fa-3x mb-3"></i>
                    <h4>Belum Ada Data Kelahiran</h4>
                    <p>Mulai dengan menambahkan data kelahiran pertama Anda</p>
                    <a href="{{ route('kelahiran.create') }}" class="btn btn-neo-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Data Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
