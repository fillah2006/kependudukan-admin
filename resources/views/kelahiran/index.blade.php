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
                <div class="stats-number">{{ $kelahiran->count() }}</div>
                <div class="stats-label">Total Kelahiran</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $kelahiran->where('jenis_kelamin', 'L')->count() }}</div>
                <div class="stats-label">Laki-laki</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $kelahiran->where('jenis_kelamin', 'P')->count() }}</div>
                <div class="stats-label">Perempuan</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $kelahiran->count() }}</div>
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
                                    <td data-label="No">{{ $loop->iteration }}</td>
                                    <td data-label="Nama Bayi">
                                        <strong>{{ $item->nama_bayi }}</strong>
                                    </td>
                                    <td data-label="Tanggal Lahir">
                                        {{ $item->tanggal_lahir->format('d/m/Y') }}
                                    </td>
                                    <td data-label="Jenis Kelamin">
                                        @if($item->jenis_kelamin == 'L')
                                            <span class="badge-gender badge-male">Laki-laki</span>
                                        @else
                                            <span class="badge-gender badge-female">Perempuan</span>
                                        @endif
                                    </td>
                                    <td data-label="Nama Ayah">
                                        <i class="fas fa-user me-1 text-muted"></i>
                                        {{ $item->nama_ayah }}
                                    </td>
                                    <td data-label="Nama Ibu">
                                        <i class="fas fa-user me-1 text-muted"></i>
                                        {{ $item->nama_ibu }}
                                    </td>
                                    <td data-label="Orang Tua">
                                        @if($item->orangtua)
                                            <i class="fas fa-users me-1 text-muted"></i>
                                            {{ $item->orangtua->nama ?? '-' }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="{{ route('kelahiran.edit', $item->id) }}"
                                               class="btn btn-neo-warning btn-sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kelahiran.destroy', $item->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-neo-danger btn-sm"
                                                        title="Hapus Data"
                                                        onclick="return confirm('Hapus data?')">
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
            @else
                <div class="empty-state">
                    <i class="fas fa-baby"></i>
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
