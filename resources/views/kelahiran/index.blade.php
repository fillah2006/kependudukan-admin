@extends('layouts.app')

@section('title', 'Data Kelahiran - Neo System')
@section('page-title', 'Data Kelahiran')
@section('page-subtitle', 'Kelola data kelahiran dengan mudah dan efisien')
@section('add-route', route('kelahiran.create'))

@section('content')
<div class="container mb-5">

    <!-- Search & Filter -->
    <div class="glass-card mb-4 p-3">
        <form action="{{ route('kelahiran.index') }}" method="GET" class="row g-2">

            <!-- Search -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control neo-input"
                       placeholder="Cari nama bayi / ayah / ibu / akte..."
                       value="{{ request('search') }}">
            </div>

            <!-- Filter Gender -->
            <div class="col-md-3">
                <select name="gender" class="form-control neo-input">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Filter Orang Tua -->
            <div class="col-md-3">
                <select name="orangtua_id" class="form-control neo-input">
                    <option value="">Semua Orang Tua</option>
                    @foreach($orangtuaList as $ot)
                        <option value="{{ $ot->id }}"
                            {{ request('orangtua_id') == $ot->id ? 'selected' : '' }}>
                            {{ $ot->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-neo-primary w-100">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>

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

    <!-- Alerts -->
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
                                <td>{{ $kelahiran->firstItem() + $loop->index }}</td>
                                <td><strong>{{ $item->nama_bayi }}</strong></td>
                                <td>{{ $item->tanggal_lahir->format('d/m/Y') }}</td>
                                <td>
                                    @if($item->jenis_kelamin == 'L')
                                        <span class="badge-gender badge-male">Laki-laki</span>
                                    @else
                                        <span class="badge-gender badge-female">Perempuan</span>
                                    @endif
                                </td>
                                <td>{{ $item->nama_ayah }}</td>
                                <td>{{ $item->nama_ibu }}</td>
                                <td>{{ $item->orangtua->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('kelahiran.edit', $item->id) }}" class="btn btn-neo-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kelahiran.destroy', $item->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus data?')"
                                                class="btn btn-neo-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                    <small class="text-muted">
                        Menampilkan {{ $kelahiran->firstItem() }} - {{ $kelahiran->lastItem() }}
                        dari {{ $kelahiran->total() }} data
                    </small>

                    {{ $kelahiran->appends(request()->query())->links('pagination::bootstrap-5') }}
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
