@extends('layouts.app')

@section('title', 'Edit Data Kematian - Neo System')
@section('page-title', 'Edit Data Kematian')
@section('page-subtitle', 'Perbarui data kematian yang sudah tercatat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kematian.index') }}">Kematian</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="glass-card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data Kematian</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kematian.update', $kematian->id) }}" method="POST" id="kematianForm">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Data Penduduk -->
                        <div class="section-title mb-3">
                            <h5><i class="fas fa-user me-2"></i>Data Penduduk</h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penduduk_id" class="form-label">Penduduk <span class="text-danger">*</span></label>
                                    <select name="penduduk_id" id="penduduk_id" class="form-control neo-input @error('penduduk_id') is-invalid @enderror" required
                                            onchange="showPendudukInfo(this.value)">
                                        <option value="">-- Pilih Penduduk --</option>
                                        @foreach($penduduks as $penduduk)
                                            <option value="{{ $penduduk->id }}"
                                                {{ old('penduduk_id', $kematian->penduduk_id) == $penduduk->id ? 'selected' : '' }}
                                                data-nik="{{ $penduduk->nik }}"
                                                data-nama="{{ $penduduk->first_name }} {{ $penduduk->last_name }}"
                                                data-tanggal-lahir="{{ $penduduk->birthday->format('d/m/Y') }}"
                                                data-usia="{{ $penduduk->birthday->age }}"
                                                data-gender="{{ $penduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}">
                                                {{ $penduduk->first_name }} {{ $penduduk->last_name }}
                                                (NIK: {{ $penduduk->nik }} | Lahir: {{ $penduduk->birthday->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('penduduk_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light p-3 rounded">
                                    <h6 class="mb-2">Informasi Penduduk</h6>
                                    <div id="pendudukInfo">
                                        @php
                                            $penduduk = $kematian->penduduk;
                                        @endphp
                                        <p class="mb-1"><strong>Nama:</strong> {{ $penduduk->first_name }} {{ $penduduk->last_name }}</p>
                                        <p class="mb-1"><strong>NIK:</strong> {{ $penduduk->nik ?: '-' }}</p>
                                        <p class="mb-1"><strong>Tanggal Lahir:</strong> {{ $penduduk->birthday->format('d/m/Y') }}</p>
                                        <p class="mb-1"><strong>Usia:</strong> {{ \Carbon\Carbon::parse($penduduk->birthday)->diff($kematian->tanggal_kematian)->y }} tahun</p>
                                        <p class="mb-0"><strong>Jenis Kelamin:</strong> {{ $penduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Data Kematian -->
                        <div class="section-title mb-3">
                            <h5><i class="fas fa-cross me-2"></i>Data Kematian</h5>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_kematian" class="form-label">Tanggal Kematian <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_kematian" id="tanggal_kematian"
                                           class="form-control neo-input @error('tanggal_kematian') is-invalid @enderror"
                                           value="{{ old('tanggal_kematian', $kematian->tanggal_kematian->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_kematian" class="form-label">Tempat Kematian <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_kematian" id="tempat_kematian"
                                           class="form-control neo-input @error('tempat_kematian') is-invalid @enderror"
                                           value="{{ old('tempat_kematian', $kematian->tempat_kematian) }}" placeholder="Contoh: RSUD, Rumah, Jalan Raya, dll" required>
                                    @error('tempat_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Penyebab Kematian -->
                        <div class="section-title mb-3">
                            <h5><i class="fas fa-stethoscope me-2"></i>Penyebab Kematian</h5>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penyebab_kematian" class="form-label">Penyebab Kematian <span class="text-danger">*</span></label>
                                    <select name="penyebab_kematian" id="penyebab_kematian"
                                            class="form-control neo-input @error('penyebab_kematian') is-invalid @enderror" required>
                                        <option value="">-- Pilih Penyebab --</option>
                                        <option value="sakit_biasa" {{ old('penyebab_kematian', $kematian->penyebab_kematian) == 'sakit_biasa' ? 'selected' : '' }}>Sakit Biasa</option>
                                        <option value="kecelakaan" {{ old('penyebab_kematian', $kematian->penyebab_kematian) == 'kecelakaan' ? 'selected' : '' }}>Kecelakaan</option>
                                        <option value="bunuh_diri" {{ old('penyebab_kematian', $kematian->penyebab_kematian) == 'bunuh_diri' ? 'selected' : '' }}>Bunuh Diri</option>
                                        <option value="pembunuhan" {{ old('penyebab_kematian', $kematian->penyebab_kematian) == 'pembunuhan' ? 'selected' : '' }}>Pembunuhan</option>
                                        <option value="lainnya" {{ old('penyebab_kematian', $kematian->penyebab_kematian) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('penyebab_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterangan_penyebab" class="form-label">Keterangan Penyebab</label>
                                    <textarea name="keterangan_penyebab" id="keterangan_penyebab"
                                              class="form-control neo-input @error('keterangan_penyebab') is-invalid @enderror"
                                              rows="2" placeholder="Jelaskan secara singkat penyebab kematian">{{ old('keterangan_penyebab', $kematian->keterangan_penyebab) }}</textarea>
                                    @error('keterangan_penyebab')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Pemakaman -->
                        <div class="section-title mb-3">
                            <h5><i class="fas fa-monument me-2"></i>Data Pemakaman</h5>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dimakamkan_di" class="form-label">Tempat Pemakaman <span class="text-danger">*</span></label>
                                    <input type="text" name="dimakamkan_di" id="dimakamkan_di"
                                           class="form-control neo-input @error('dimakamkan_di') is-invalid @enderror"
                                           value="{{ old('dimakamkan_di', $kematian->dimakamkan_di) }}" placeholder="Contoh: TPU Umum, Makam Keluarga, dll" required>
                                    @error('dimakamkan_di')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_pemakaman" class="form-label">Tanggal Pemakaman <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pemakaman" id="tanggal_pemakaman"
                                           class="form-control neo-input @error('tanggal_pemakaman') is-invalid @enderror"
                                           value="{{ old('tanggal_pemakaman', $kematian->tanggal_pemakaman->format('Y-m-d')) }}" required>
                                    @error('tanggal_pemakaman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Data Administrasi -->
                        <div class="section-title mb-3">
                            <h5><i class="fas fa-file-alt me-2"></i>Data Administrasi</h5>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status_pencatatan" class="form-label">Status Pencatatan <span class="text-danger">*</span></label>
                                    <select name="status_pencatatan" id="status_pencatatan"
                                            class="form-control neo-input @error('status_pencatatan') is-invalid @enderror" required>
                                        <option value="sementara" {{ old('status_pencatatan', $kematian->status_pencatatan) == 'sementara' ? 'selected' : '' }}>Sementara</option>
                                        <option value="permanen" {{ old('status_pencatatan', $kematian->status_pencatatan) == 'permanen' ? 'selected' : '' }}>Permanen</option>
                                    </select>
                                    @error('status_pencatatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="surat_kematian_no" class="form-label">Nomor Surat Kematian</label>
                                    <input type="text" name="surat_kematian_no" id="surat_kematian_no"
                                           class="form-control neo-input @error('surat_kematian_no') is-invalid @enderror"
                                           value="{{ old('surat_kematian_no', $kematian->surat_kematian_no) }}" placeholder="Nomor surat jika ada">
                                    @error('surat_kematian_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="surat_kematian_tanggal" class="form-label">Tanggal Surat Kematian</label>
                                    <input type="date" name="surat_kematian_tanggal" id="surat_kematian_tanggal"
                                           class="form-control neo-input @error('surat_kematian_tanggal') is-invalid @enderror"
                                           value="{{ old('surat_kematian_tanggal', $kematian->surat_kematian_tanggal ? $kematian->surat_kematian_tanggal->format('Y-m-d') : '') }}" max="{{ date('Y-m-d') }}">
                                    @error('surat_kematian_tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 6: Catatan Tambahan -->
                        <div class="form-group mb-4">
                            <label for="catatan_tambahan" class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan_tambahan" id="catatan_tambahan"
                                      class="form-control neo-input @error('catatan_tambahan') is-invalid @enderror"
                                      rows="3" placeholder="Catatan lain yang perlu dicatat">{{ old('catatan_tambahan', $kematian->catatan_tambahan) }}</textarea>
                            @error('catatan_tambahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong> Data ini dilaporkan oleh
                            <strong>{{ $kematian->pelapor->name ?? 'Tidak diketahui' }}</strong>
                            pada <strong>{{ $kematian->created_at->format('d/m/Y H:i') }}</strong>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <a href="{{ route('kematian.index') }}" class="btn btn-neo-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                                <a href="{{ route('kematian.show', $kematian->id) }}" class="btn btn-neo-info">
                                    <i class="fas fa-eye me-2"></i> Lihat Detail
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-neo-warning">
                                    <i class="fas fa-save me-2"></i> Perbarui Data
                                </button>
                            </div>
                        </div>
                    </form>
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
    }
    .section-title h5 {
        color: #495057;
        font-weight: 600;
    }
    .info-box {
        border-left: 4px solid #ffc107;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    .neo-input:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    // Fungsi untuk menampilkan info penduduk (TANPA AJAX)
    function showPendudukInfo(pendudukId) {
        var select = document.getElementById('penduduk_id');
        var selectedOption = select.options[select.selectedIndex];

        if (pendudukId && selectedOption.dataset.nik) {
            var html = `
                <p class="mb-1"><strong>Nama:</strong> ${selectedOption.dataset.nama}</p>
                <p class="mb-1"><strong>NIK:</strong> ${selectedOption.dataset.nik || '-'}</p>
                <p class="mb-1"><strong>Tanggal Lahir:</strong> ${selectedOption.dataset.tanggalLahir}</p>
                <p class="mb-1"><strong>Usia:</strong> ${selectedOption.dataset.usia} tahun</p>
                <p class="mb-0"><strong>Jenis Kelamin:</strong> ${selectedOption.dataset.gender}</p>
            `;
            document.getElementById('pendudukInfo').innerHTML = html;
        }
    }

    // Set min date for pemakaman based on kematian date
    document.getElementById('tanggal_kematian').addEventListener('change', function() {
        var kematianDate = this.value;
        var pemakamanInput = document.getElementById('tanggal_pemakaman');

        if (kematianDate) {
            pemakamanInput.setAttribute('min', kematianDate);
        }
    });

    // Trigger change for tanggal kematian to set min date
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('tanggal_kematian').dispatchEvent(new Event('change'));

        // Form validation
        document.getElementById('kematianForm').addEventListener('submit', function(e) {
            var tanggalKematian = document.getElementById('tanggal_kematian').value;
            var tanggalPemakaman = document.getElementById('tanggal_pemakaman').value;

            if (tanggalKematian && tanggalPemakaman) {
                if (new Date(tanggalPemakaman) < new Date(tanggalKematian)) {
                    e.preventDefault();
                    alert('Tanggal pemakaman tidak boleh sebelum tanggal kematian!');
                    document.getElementById('tanggal_pemakaman').focus();
                }
            }
        });
    });
</script>
@endpush
