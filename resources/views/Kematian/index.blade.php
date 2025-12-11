@extends('layouts.app')

@section('title', 'Data Kematian')
@section('page-title', 'Data Kematian')
@section('page-subtitle', 'Pencatatan dan pengelolaan data kematian')
@section('add-route', route('kematian.create'))

@section('content')
<div class="container mb-5">

    <!-- Filter -->
    <div class="glass-card mb-4 p-3">
        <form action="{{ route('kematian.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control neo-input"
                       placeholder="Cari nama penduduk, tempat..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="bulan" class="form-control neo-input">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-control neo-input">
                    <option value="">Semua Tahun</option>
                    @foreach(range(date('Y')-5, date('Y')) as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="penyebab" class="form-control neo-input">
                    <option value="">Semua Penyebab</option>
                    @foreach(['sakit_biasa', 'kecelakaan', 'bunuh_diri', 'pembunuhan', 'lainnya'] as $cause)
                        <option value="{{ $cause }}" {{ request('penyebab') == $cause ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $cause)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-neo-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card stats-card-danger">
                <div class="stats-number">{{ $totalKematian }}</div>
                <div class="stats-label">Total Kematian</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card stats-card-primary">
                <a href="{{ route('kematian.report') }}" class="text-decoration-none text-white">
                    <div class="stats-number"><i class="fas fa-file-pdf"></i></div>
                    <div class="stats-label">Generate Laporan</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card">
        <div class="card-body p-0">
            @if($kematians->count() > 0)
                <div class="table-responsive">
                    <table class="table table-neo">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Penduduk</th>
                                <th>Tanggal Kematian</th>
                                <th>Tempat Kematian</th>
                                <th>Penyebab</th>
                                <th>Dimakamkan di</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kematians as $kematian)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $kematian->penduduk->first_name }} {{ $kematian->penduduk->last_name }}</strong><br>
                                        <small class="text-muted">NIK: {{ $kematian->penduduk->nik }}</small>
                                    </td>
                                    <td>{{ $kematian->tanggal_kematian->format('d/m/Y') }}</td>
                                    <td>{{ $kematian->tempat_kematian }}</td>
                                    <td><span class="badge bg-danger">{{ $kematian->penyebab_kematian_label }}</span></td>
                                    <td>{{ $kematian->dimakamkan_di }}</td>
                                    <td>
                                        <span class="badge {{ $kematian->status_pencatatan == 'permanen' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($kematian->status_pencatatan) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('kematian.edit', $kematian->id) }}"
                                               class="btn btn-neo-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kematian.destroy', $kematian->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-neo-danger btn-sm"
                                                        onclick="return confirm('Hapus data kematian ini?')">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $kematians->links() }}
                </div>

            @else
                <div class="text-center p-5">
                    <i class="fas fa-book-dead fa-3x mb-3 text-muted"></i>
                    <h4>Tidak ada data kematian</h4>
                    <p>Belum ada pencatatan kematian</p>
                    <a href="{{ route('kematian.create') }}" class="btn btn-neo-primary">
                        <i class="fas fa-plus me-2"></i> Catat Kematian Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stats-card-danger {
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
        color: white;
    }
    .stats-card-warning {
        background: linear-gradient(135deg, #ffa726, #ffb74d);
        color: white;
    }
</style>
@endpush
