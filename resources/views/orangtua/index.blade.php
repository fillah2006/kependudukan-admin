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
                <div class="stats-number">{{ $orangTua->count() }}</div>
                <div class="stats-label">Total Orang Tua</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $orangTua->where('jenis_kelamin', 'L')->count() }}</div>
                <div class="stats-label">Laki-laki</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $orangTua->where('jenis_kelamin', 'P')->count() }}</div>
                <div class="stats-label">Perempuan</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $orangTua->where('status', 'hidup')->count() }}</div>
                <div class="stats-label">Masih Hidup</div>
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
                            <td data-label="No">{{ $loop->iteration }}</td>
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
                                {{ Str::limit($item->alamat, 30) }}
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
                                    <a href="{{ route('orangtua.edit', $item->id) }}" class="btn btn-neo-warning btn-sm" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('orangtua.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-neo-danger btn-sm" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                <i class="fas fa-users"></i>
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
