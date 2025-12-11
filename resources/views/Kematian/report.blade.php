@extends('layouts.app')

@section('title', 'Laporan Kematian - Neo System')
@section('page-title', 'Laporan Data Kematian')
@section('page-subtitle', 'Generate laporan kematian berdasarkan periode')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kematian.index') }}">Kematian</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Animated Background -->
                <div class="bg-animation">
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>
                    <div class="floating-shape shape-3"></div>
                    <div class="floating-shape shape-4"></div>
                </div>

                <!-- Cyber Grid -->
                <div class="cyber-grid"></div>

                <div class="form-container">
                    <div class="card-header bg-gradient-info text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0"><i class="fas fa-file-pdf me-2"></i>Generate Laporan Kematian</h4>
                                <p class="mb-0 opacity-75">Filter dan generate laporan data kematian</p>
                            </div>
                            <div class="report-badge">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-database me-1"></i>
                                    {{ $data->count() }} Data
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filter Form -->
                        <div class="glass-card p-4 mb-4">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-filter me-2"></i>Filter Laporan
                            </h5>
                            <form action="{{ route('kematian.report') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">
                                            <i class="fas fa-calendar-start me-1"></i>Tanggal Mulai
                                        </label>
                                        <input type="date" name="start_date" id="start_date"
                                            class="form-control neo-input"
                                            value="{{ request('start_date') ?? now()->startOfMonth()->format('Y-m-d') }}"
                                            onchange="updateDateRange()">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">
                                            <i class="fas fa-calendar-end me-1"></i>Tanggal Akhir
                                        </label>
                                        <input type="date" name="end_date" id="end_date" class="form-control neo-input"
                                            value="{{ request('end_date') ?? now()->endOfMonth()->format('Y-m-d') }}"
                                            onchange="updateDateRange()">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="penyebab" class="form-label">
                                            <i class="fas fa-stethoscope me-1"></i>Penyebab Kematian
                                        </label>
                                        <select name="penyebab" id="penyebab" class="form-control neo-input">
                                            <option value="">Semua Penyebab</option>
                                            <option value="sakit_biasa"
                                                {{ request('penyebab') == 'sakit_biasa' ? 'selected' : '' }}>Sakit Biasa
                                            </option>
                                            <option value="kecelakaan"
                                                {{ request('penyebab') == 'kecelakaan' ? 'selected' : '' }}>Kecelakaan
                                            </option>
                                            <option value="bunuh_diri"
                                                {{ request('penyebab') == 'bunuh_diri' ? 'selected' : '' }}>Bunuh Diri
                                            </option>
                                            <option value="pembunuhan"
                                                {{ request('penyebab') == 'pembunuhan' ? 'selected' : '' }}>Pembunuhan
                                            </option>
                                            <option value="lainnya"
                                                {{ request('penyebab') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sort_by" class="form-label">
                                            <i class="fas fa-sort me-1"></i>Urutkan Berdasarkan
                                        </label>
                                        <select name="sort_by" id="sort_by" class="form-control neo-input">
                                            <option value="tanggal_kematian"
                                                {{ request('sort_by') == 'tanggal_kematian' ? 'selected' : '' }}>Tanggal
                                                Kematian</option>
                                            <option value="nama_penduduk"
                                                {{ request('sort_by') == 'nama_penduduk' ? 'selected' : '' }}>Nama Penduduk
                                            </option>
                                            <option value="penyebab_kematian"
                                                {{ request('sort_by') == 'penyebab_kematian' ? 'selected' : '' }}>Penyebab
                                                Kematian</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="d-flex gap-2 mt-3">
                                            <button type="submit" class="btn btn-neo-primary">
                                                <i class="fas fa-filter me-2"></i> Terapkan Filter
                                            </button>
                                            <button type="button" onclick="printReport()" class="btn btn-neo-success">
                                                <i class="fas fa-print me-2"></i> Cetak Laporan
                                            </button>
                                            <button type="button" onclick="exportToExcel()" class="btn btn-neo-info">
                                                <i class="fas fa-file-excel me-2"></i> Export Excel
                                            </button>
                                            <a href="{{ route('kematian.index') }}" class="btn btn-neo-secondary">
                                                <i class="fas fa-arrow-left me-2"></i> Kembali
                                            </a>
                                            <button type="button" onclick="resetFilter()" class="btn btn-neo-warning">
                                                <i class="fas fa-redo me-2"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Report Summary Stats -->
                        <!-- Update bagian Report Summary Stats -->
                        @if ($data->count() > 0)
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <div class="stats-card stats-card-info">
                                        <div class="stats-icon">
                                            <i class="fas fa-database"></i>
                                        </div>
                                        <div class="stats-content">
                                            <div class="stats-number">{{ $totalData }}</div>
                                            <div class="stats-label">Total Data</div>
                                            <div class="stats-period">
                                                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                                                {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="stats-card stats-card-success">
                                        <div class="stats-icon">
                                            <i class="fas fa-heartbeat"></i>
                                        </div>
                                        <div class="stats-content">
                                            <div class="stats-number">{{ $sakitBiasaCount }}</div>
                                            <div class="stats-label">Sakit Biasa</div>
                                            <div class="stats-percentage">{{ number_format($sakitBiasaPercentage, 1) }}%
                                            </div>
                                            <div class="stats-period">
                                                @if ($totalData > 0)
                                                    {{ $sakitBiasaCount }} dari {{ $totalData }}
                                                @else
                                                    0 data
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="stats-card stats-card-warning">
                                        <div class="stats-icon">
                                            <i class="fas fa-car-crash"></i>
                                        </div>
                                        <div class="stats-content">
                                            <div class="stats-number">{{ $kecelakaanCount }}</div>
                                            <div class="stats-label">Kecelakaan</div>
                                            <div class="stats-percentage">{{ number_format($kecelakaanPercentage, 1) }}%
                                            </div>
                                            <div class="stats-period">
                                                @if ($totalData > 0)
                                                    {{ $kecelakaanCount }} dari {{ $totalData }}
                                                @else
                                                    0 data
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="stats-card stats-card-dark">
                                        <div class="stats-icon">
                                            <i
                                                class="fas {{ $dominantCause == 'sakit_biasa' ? 'fa-heartbeat' : 'fa-car-crash' }}"></i>
                                        </div>
                                        <div class="stats-content">
                                            <div class="stats-number">{{ $dominantCount }}</div>
                                            <div class="stats-label">
                                                {{ $dominantCause == 'sakit_biasa' ? 'Sakit Biasa' : 'Kecelakaan' }}
                                                (Dominan)
                                            </div>
                                            <div class="stats-percentage">{{ number_format($dominantPercentage, 1) }}%
                                            </div>
                                            <div class="stats-period">
                                                @if ($sakitBiasaCount > $kecelakaanCount)
                                                    Sakit > Kecelakaan: {{ $sakitBiasaCount - $kecelakaanCount }} data
                                                @elseif($kecelakaanCount > $sakitBiasaCount)
                                                    Kecelakaan > Sakit: {{ $kecelakaanCount - $sakitBiasaCount }} data
                                                @else
                                                    Sama banyak
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Update bagian Statistics Charts dengan data lengkap -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="glass-card p-4 h-100">
                                        <h5 class="section-title mb-3">
                                            <i class="fas fa-chart-pie me-2"></i>Distribusi Semua Penyebab
                                        </h5>
                                        <div class="pie-chart-container">
                                            @php
                                                $allCauses = [
                                                    'sakit_biasa' => [
                                                        'count' => $sakitBiasaCount,
                                                        'percentage' => $sakitBiasaPercentage,
                                                        'label' => 'Sakit Biasa',
                                                        'color' => '#4CAF50',
                                                    ],
                                                    'kecelakaan' => [
                                                        'count' => $kecelakaanCount,
                                                        'percentage' => $kecelakaanPercentage,
                                                        'label' => 'Kecelakaan',
                                                        'color' => '#FF9800',
                                                    ],
                                                    'bunuh_diri' => [
                                                        'count' => $bunuhDiriCount,
                                                        'percentage' => $bunuhDiriPercentage,
                                                        'label' => 'Bunuh Diri',
                                                        'color' => '#2196F3',
                                                    ],
                                                    'pembunuhan' => [
                                                        'count' => $pembunuhanCount,
                                                        'percentage' => $pembunuhanPercentage,
                                                        'label' => 'Pembunuhan',
                                                        'color' => '#F44336',
                                                    ],
                                                    'lainnya' => [
                                                        'count' => $lainnyaCount,
                                                        'percentage' => $lainnyaPercentage,
                                                        'label' => 'Lainnya',
                                                        'color' => '#9E9E9E',
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($allCauses as $cause)
                                                @if ($cause['count'] > 0)
                                                    <div class="pie-chart-item mb-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <div class="color-indicator me-2"
                                                                    style="background-color: {{ $cause['color'] }}"></div>
                                                                <span>{{ $cause['label'] }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bold me-2">{{ $cause['count'] }}</span>
                                                                <span
                                                                    class="text-muted">({{ number_format($cause['percentage'], 1) }}%)</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mt-1" style="height: 8px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $cause['percentage'] }}%; background-color: {{ $cause['color'] }}"
                                                                aria-valuenow="{{ $cause['percentage'] }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            <!-- Total Summary -->
                                            <div class="mt-4 pt-3 border-top">
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <div class="display-6 fw-bold text-info">{{ $totalData }}</div>
                                                        <div class="text-muted small">Total Data</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="display-6 fw-bold text-warning">
                                                            {{ number_format($avgAge, 1) }}</div>
                                                        <div class="text-muted small">Rata Usia (tahun)</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="glass-card p-4 h-100">
                                        <h5 class="section-title mb-3">
                                            <i class="fas fa-balance-scale me-2"></i>Perbandingan Sakit vs Kecelakaan
                                        </h5>

                                        <!-- Comparison Chart -->
                                        <div class="comparison-chart mb-4">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-success">
                                                    <i class="fas fa-heartbeat me-1"></i> Sakit Biasa
                                                </span>
                                                <span class="text-warning">
                                                    <i class="fas fa-car-crash me-1"></i> Kecelakaan
                                                </span>
                                            </div>

                                            <div class="progress comparison-progress" style="height: 25px;">
                                                @if ($totalData > 0)
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $sakitBiasaPercentage }}%"
                                                        aria-valuenow="{{ $sakitBiasaPercentage }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ $sakitBiasaCount }}
                                                        ({{ number_format($sakitBiasaPercentage, 1) }}%)
                                                    </div>
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $kecelakaanPercentage }}%"
                                                        aria-valuenow="{{ $kecelakaanPercentage }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ $kecelakaanCount }}
                                                        ({{ number_format($kecelakaanPercentage, 1) }}%)
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mt-3 text-center">
                                                @if ($sakitBiasaCount > $kecelakaanCount)
                                                    <div class="alert alert-success mb-0">
                                                        <i class="fas fa-trophy me-2"></i>
                                                        <strong>Sakit Biasa lebih dominan</strong> dengan selisih
                                                        {{ $sakitBiasaCount - $kecelakaanCount }} data
                                                    </div>
                                                @elseif($kecelakaanCount > $sakitBiasaCount)
                                                    <div class="alert alert-warning mb-0">
                                                        <i class="fas fa-trophy me-2"></i>
                                                        <strong>Kecelakaan lebih dominan</strong> dengan selisih
                                                        {{ $kecelakaanCount - $sakitBiasaCount }} data
                                                    </div>
                                                @elseif($totalData > 0)
                                                    <div class="alert alert-info mb-0">
                                                        <i class="fas fa-balance-scale me-2"></i>
                                                        <strong>Sama banyak</strong> antara Sakit Biasa dan Kecelakaan
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Quick Stats -->
                                        <div class="row g-2 mb-4">
                                            <div class="col-6">
                                                <div class="quick-stat bg-success text-white p-3 rounded text-center">
                                                    <div class="stat-number display-6 fw-bold">{{ $sakitBiasaCount }}
                                                    </div>
                                                    <div class="stat-label">Sakit Biasa</div>
                                                    <div class="stat-percentage">
                                                        {{ number_format($sakitBiasaPercentage, 1) }}%</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="quick-stat bg-warning text-dark p-3 rounded text-center">
                                                    <div class="stat-number display-6 fw-bold">{{ $kecelakaanCount }}
                                                    </div>
                                                    <div class="stat-label">Kecelakaan</div>
                                                    <div class="stat-percentage">
                                                        {{ number_format($kecelakaanPercentage, 1) }}%</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Detail Info -->
                                        <div class="report-info">
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-calculator me-2"></i>Rasio Sakit:Kecelakaan
                                                </div>
                                                <div class="info-value">
                                                    @if ($kecelakaanCount > 0)
                                                        {{ number_format($sakitBiasaCount / $kecelakaanCount, 2) }} : 1
                                                    @elseif($sakitBiasaCount > 0)
                                                        {{ $sakitBiasaCount }} : 0
                                                    @else
                                                        0 : 0
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-chart-line me-2"></i>Distribusi Total
                                                </div>
                                                <div class="info-value">
                                                    Sakit: {{ $sakitBiasaCount }}, Kecelakaan: {{ $kecelakaanCount }},
                                                    Lainnya: {{ $bunuhDiriCount + $pembunuhanCount + $lainnyaCount }}
                                                </div>
                                            </div>
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-percentage me-2"></i>Persentase Gabungan
                                                </div>
                                                <div class="info-value">
                                                    Sakit + Kecelakaan =
                                                    {{ number_format($sakitBiasaPercentage + $kecelakaanPercentage, 1) }}%
                                                    dari total
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Report Table -->
                        @if ($data->count() > 0)
                            <div class="glass-card p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="section-title mb-0">
                                        <i class="fas fa-table me-2"></i>Data Laporan
                                        <span class="badge bg-info ms-2">{{ $data->count() }} records</span>
                                    </h5>
                                    <div>
                                        <button onclick="toggleFullscreen()" class="btn btn-sm btn-neo-secondary">
                                            <i class="fas fa-expand me-1"></i> Fullscreen
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive" id="reportTable">
                                    <table class="table table-neo table-hover">
                                        <thead>
                                            <tr class="table-header-gradient">
                                                <th width="50">#</th>
                                                <th>Nama Penduduk</th>
                                                <th>NIK</th>
                                                <th>Usia</th>
                                                <th>Tanggal Kematian</th>
                                                <th>Tempat Kematian</th>
                                                <th>Penyebab</th>
                                                <th>Tempat Pemakaman</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-dark">{{ $loop->iteration }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle me-2">
                                                                {{ substr($item->penduduk->first_name, 0, 1) }}
                                                            </div>
                                                            <div>
                                                                <strong>{{ $item->penduduk->first_name }}
                                                                    {{ $item->penduduk->last_name }}</strong>
                                                                <div class="text-muted small">
                                                                    {{ $item->penduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <code
                                                            class="bg-dark p-1 rounded">{{ $item->penduduk->nik }}</code>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            {{ $item->penduduk->birthday->age }} tahun
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-calendar-day text-danger me-2"></i>
                                                            <span
                                                                class="fw-bold">{{ $item->tanggal_kematian->format('d/m/Y') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                                            <span>{{ Str::limit($item->tempat_kematian, 25) }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $badgeColors = [
                                                                'sakit_biasa' => 'bg-success',
                                                                'kecelakaan' => 'bg-warning',
                                                                'bunuh_diri' => 'bg-info',
                                                                'pembunuhan' => 'bg-danger',
                                                                'lainnya' => 'bg-secondary',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge {{ $badgeColors[$item->penyebab_kematian] ?? 'bg-dark' }}">
                                                            <i
                                                                class="fas fa-{{ $item->penyebab_kematian == 'sakit_biasa' ? 'heartbeat' : ($item->penyebab_kematian == 'kecelakaan' ? 'car-crash' : 'exclamation-triangle') }} me-1"></i>
                                                            {{ $item->penyebab_kematian_label }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-tombstone text-muted me-2"></i>
                                                            <span>{{ Str::limit($item->dimakamkan_di, 20) }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $item->status_pencatatan == 'permanen' ? 'bg-success' : 'bg-warning' }}">
                                                            <i
                                                                class="fas fa-{{ $item->status_pencatatan == 'permanen' ? 'check-circle' : 'clock' }} me-1"></i>
                                                            {{ ucfirst($item->status_pencatatan) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Ditampilkan {{ $data->count() }} dari {{ $data->count() }} data
                                    </div>
                                    <div>
                                        <button onclick="scrollToTop()" class="btn btn-sm btn-neo-secondary">
                                            <i class="fas fa-arrow-up me-1"></i> Ke Atas
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Charts -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="glass-card p-4 h-100">
                                        <h5 class="section-title mb-3">
                                            <i class="fas fa-chart-pie me-2"></i>Distribusi Penyebab Kematian
                                        </h5>
                                        @php
                                            $grouped = $data->groupBy('penyebab_kematian');
                                            $total = $data->count();
                                        @endphp
                                        <div class="pie-chart-container">
                                            @foreach ($grouped as $penyebab => $items)
                                                @php
                                                    $count = $items->count();
                                                    $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                                    $colors = [
                                                        'sakit_biasa' => '#4CAF50',
                                                        'kecelakaan' => '#FF9800',
                                                        'bunuh_diri' => '#2196F3',
                                                        'pembunuhan' => '#F44336',
                                                        'lainnya' => '#9E9E9E',
                                                    ];
                                                @endphp
                                                <div class="pie-chart-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="color-indicator me-2"
                                                                style="background-color: {{ $colors[$penyebab] ?? '#000' }}">
                                                            </div>
                                                            <span>{{ \App\Models\Kematian::$penyebabLabels[$penyebab] ?? $penyebab }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="fw-bold me-2">{{ $count }}</span>
                                                            <span
                                                                class="text-muted">({{ number_format($percentage, 1) }}%)</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-1" style="height: 6px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $percentage }}%; background-color: {{ $colors[$penyebab] ?? '#000' }}"
                                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="glass-card p-4 h-100">
                                        <h5 class="section-title mb-3">
                                            <i class="fas fa-chart-line me-2"></i>Informasi Laporan
                                        </h5>
                                        <div class="report-info">
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-calendar-alt me-2"></i>Periode Laporan
                                                </div>
                                                <div class="info-value">
                                                    {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} -
                                                    {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
                                                </div>
                                            </div>
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-clock me-2"></i>Tanggal Generate
                                                </div>
                                                <div class="info-value">
                                                    {{ now()->format('d F Y H:i:s') }}
                                                </div>
                                            </div>
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-user me-2"></i>Dibuat Oleh
                                                </div>
                                                <div class="info-value">
                                                    {{ Auth::user()->name ?? 'System' }}
                                                </div>
                                            </div>
                                            <div class="info-item mb-3">
                                                <div class="info-label">
                                                    <i class="fas fa-calculator me-2"></i>Statistik Singkat
                                                </div>
                                                <div class="info-value">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small class="text-muted">Total Data</small>
                                                            <div class="fw-bold">{{ $data->count() }}</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted">Rata Usia</small>
                                                            <div class="fw-bold">{{ number_format($avgAge, 1) }} tahun
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-3 border-top">
                                            <h6 class="mb-3">Quick Actions:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button onclick="printReport()" class="btn btn-sm btn-neo-success">
                                                    <i class="fas fa-print me-1"></i> Print
                                                </button>
                                                <button onclick="exportToExcel()" class="btn btn-sm btn-neo-info">
                                                    <i class="fas fa-file-excel me-1"></i> Excel
                                                </button>
                                                <button onclick="shareReport()" class="btn btn-sm btn-neo-primary">
                                                    <i class="fas fa-share-alt me-1"></i> Share
                                                </button>
                                                <button onclick="downloadPDF()" class="btn btn-sm btn-neo-danger">
                                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="glass-card p-5 text-center">
                                <div class="empty-state">
                                    <i class="fas fa-file-excel fa-4x mb-4 text-muted"></i>
                                    <h4 class="mb-3">Tidak ada data dalam periode ini</h4>
                                    <p class="text-muted mb-4">Ubah filter tanggal atau penyebab kematian untuk menampilkan
                                        data</p>
                                    <button onclick="resetFilter()" class="btn btn-neo-primary">
                                        <i class="fas fa-redo me-2"></i> Reset Filter
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(25px);
            border-radius: 30px;
            border: 1px solid rgba(23, 162, 184, 0.3);
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.4),
                0 0 100px rgba(23, 162, 184, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(23, 162, 184, 0.15),
                    transparent);
            transition: left 0.8s ease;
        }

        .form-container:hover::before {
            left: 100%;
        }

        .card-header.bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #5bc0de 100%);
            padding: 25px 30px;
        }

        .report-badge .badge {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .stats-card {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .stats-card-dark {
            background: linear-gradient(135deg, rgba(45, 55, 72, 0.9), rgba(26, 32, 44, 0.9));
            border-color: rgba(255, 255, 255, 0.1);
        }

        .stats-icon {
            font-size: 2.5rem;
            margin-right: 20px;
            opacity: 0.8;
        }

        .stats-content {
            flex: 1;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stats-percentage {
            font-size: 0.8rem;
            opacity: 0.8;
            font-weight: 600;
        }

        .stats-period {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 3px;
        }

        .table-header-gradient {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.2), rgba(91, 192, 222, 0.15));
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .color-indicator {
            width: 12px;
            height: 12px;
            border-radius: 2px;
        }

        .report-info .info-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .report-info .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .report-info .info-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 3px;
        }

        .report-info .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: white;
        }

        .empty-state {
            padding: 40px 0;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        /* Custom scrollbar for table */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #17a2b8, #5bc0de);
            border-radius: 10px;
        }

        /* Print specific styles */
        @media print {
            body * {
                visibility: hidden;
            }

            #reportTable,
            #reportTable * {
                visibility: visible;
            }

            #reportTable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            /* Comparison Chart */
            .comparison-progress .progress-bar {
                font-weight: 600;
                font-size: 0.85rem;
                display: flex;
                align-items: center;
                justify-content: center;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            }

            .comparison-progress .bg-success {
                background: linear-gradient(135deg, #4CAF50, #388E3C) !important;
            }

            .comparison-progress .bg-warning {
                background: linear-gradient(135deg, #FF9800, #F57C00) !important;
            }

            /* Quick Stats */
            .quick-stat {
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .quick-stat:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            }

            .quick-stat .stat-number {
                line-height: 1;
                margin-bottom: 5px;
            }

            .quick-stat .stat-label {
                font-size: 0.9rem;
                opacity: 0.9;
                margin-bottom: 3px;
            }

            .quick-stat .stat-percentage {
                font-size: 0.8rem;
                opacity: 0.8;
                font-weight: 600;
            }

            /* Empty State Enhancement */
            .empty-state {
                animation: fadeInUp 0.6s ease;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .quick-stat {
                    padding: 15px 10px !important;
                }

                .quick-stat .stat-number {
                    font-size: 2rem !important;
                }

                .comparison-progress .progress-bar {
                    font-size: 0.7rem;
                }
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function updateDateRange() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                // Update stats or show info about selected range
                console.log(`Selected range: ${diffDays} days`);
            }
        }

        function resetFilter() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            document.getElementById('start_date').value = formatDate(firstDay);
            document.getElementById('end_date').value = formatDate(lastDay);
            document.getElementById('penyebab').value = '';
            document.getElementById('sort_by').value = 'tanggal_kematian';

            // Submit form automatically
            document.querySelector('form').submit();
        }

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function printReport() {
            window.print();
        }

        function exportToExcel() {
            alert('Fitur export Excel akan segera tersedia!');
            // Implementasi export Excel menggunakan SheetJS atau library lain
        }

        function downloadPDF() {
            alert('Fitur download PDF akan segera tersedia!');
            // Implementasi PDF generation menggunakan jsPDF atau library lain
        }

        function shareReport() {
            if (navigator.share) {
                navigator.share({
                        title: 'Laporan Kematian - Neo System',
                        text: 'Laporan data kematian periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}',
                        url: window.location.href
                    })
                    .then(() => console.log('Berhasil share'))
                    .catch((error) => console.log('Error sharing:', error));
            } else {
                alert('Share API tidak didukung di browser ini');
            }
        }

        function toggleFullscreen() {
            const table = document.getElementById('reportTable');
            if (!document.fullscreenElement) {
                table.requestFullscreen().catch(err => {
                    alert(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });

            // Auto-update date inputs
            updateDateRange();
        });
    </script>
@endpush
