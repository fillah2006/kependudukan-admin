@extends('layouts.app')

@section('title', 'Detail Kematian - Neo System')
@section('page-title', 'Detail Data Kematian')
@section('page-subtitle', 'Informasi lengkap data kematian')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kematian.index') }}">Kematian</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="glass-card">
                <div class="card-header bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Data Kematian</h4>
                        <div>
                            <a href="{{ route('kematian.edit', $kematian->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('kematian.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Data Penduduk -->
                    <div class="mb-4">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-user me-2"></i>Data Penduduk
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nama Lengkap</label>
                                    <p class="info-value">{{ $kematian->penduduk->first_name }} {{ $kematian->penduduk->last_name }}</p>
                                </div>
                                <div class="info-item">
                                    <label>NIK</label>
                                    <p class="info-value">{{ $kematian->penduduk->nik ?: '-' }}</p>
                                </div>
                                <div class="info-item">
                                    <label>Tanggal Lahir</label>
                                    <p class="info-value">{{ $kematian->penduduk->birthday->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Usia Saat Meninggal</label>
                                    <p class="info-value">{{ \Carbon\Carbon::parse($kematian->penduduk->birthday)->diff($kematian->tanggal_kematian)->y }} tahun</p>
                                </div>
                                <div class="info-item">
                                    <label>Jenis Kelamin</label>
                                    <p class="info-value">
                                        <span class="badge-gender {{ $kematian->penduduk->gender == 'L' ? 'badge-male' : 'badge-female' }}">
                                            {{ $kematian->penduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label>Telepon</label>
                                    <p class="info-value">{{ $kematian->penduduk->phone ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Kematian -->
                    <div class="mb-4">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-cross me-2"></i>Data Kematian
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tanggal Kematian</label>
                                    <p class="info-value">{{ $kematian->tanggal_kematian->format('d/m/Y') }}</p>
                                </div>
                                <div class="info-item">
                                    <label>Tempat Kematian</label>
                                    <p class="info-value">{{ $kematian->tempat_kematian }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Penyebab Kematian</label>
                                    <p class="info-value">
                                        <span class="badge bg-danger">{{ $kematian->penyebab_kematian_label }}</span>
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label>Keterangan Penyebab</label>
                                    <p class="info-value">{{ $kematian->keterangan_penyebab ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pemakaman -->
                    <div class="mb-4">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-monument me-2"></i>Data Pemakaman
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tempat Pemakaman</label>
                                    <p class="info-value">{{ $kematian->dimakamkan_di }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tanggal Pemakaman</label>
                                    <p class="info-value">{{ $kematian->tanggal_pemakaman->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Administrasi -->
                    <div class="mb-4">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-file-alt me-2"></i>Data Administrasi
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Status Pencatatan</label>
                                    <p class="info-value">
                                        <span class="badge {{ $kematian->status_pencatatan == 'permanen' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($kematian->status_pencatatan) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label>Surat Kematian No</label>
                                    <p class="info-value">{{ $kematian->surat_kematian_no ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tanggal Surat Kematian</label>
                                    <p class="info-value">
                                        {{ $kematian->surat_kematian_tanggal ? $kematian->surat_kematian_tanggal->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label>Dilaporkan Oleh</label>
                                    <p class="info-value">{{ $kematian->pelapor->name ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Tambahan -->
                    @if($kematian->catatan_tambahan)
                    <div class="mb-4">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                        </h5>
                        <div class="bg-light p-3 rounded">
                            {{ $kematian->catatan_tambahan }}
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="alert alert-secondary">
                        <div class="row">
                            <div class="col-md-6">
                                <small>
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    <strong>Dibuat:</strong> {{ $kematian->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small>
                                    <i class="fas fa-calendar-check me-1"></i>
                                    <strong>Diperbarui:</strong> {{ $kematian->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('penduduk.show', $kematian->penduduk_id) }}" class="btn btn-neo-info">
                            <i class="fas fa-user me-2"></i> Lihat Data Penduduk
                        </a>
                        <div>
                            <a href="{{ route('kematian.edit', $kematian->id) }}" class="btn btn-neo-warning me-2">
                                <i class="fas fa-edit me-2"></i> Edit Data
                            </a>
                            <form action="{{ route('kematian.destroy', $kematian->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-neo-danger"
                                        onclick="return confirm('Hapus data kematian ini?')">
                                    <i class="fas fa-trash me-2"></i> Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .section-title {
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
    }
    .info-item {
        margin-bottom: 1.5rem;
    }
    .info-item label {
        display: block;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }
    .info-value {
        margin: 0;
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        border-left: 4px solid #dc3545;
    }
    .badge-gender {
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .badge-male {
        background-color: #2196F3;
        color: white;
    }
    .badge-female {
        background-color: #E91E63;
        color: white;
    }
</style>
@endpush
