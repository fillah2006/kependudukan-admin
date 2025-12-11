<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Kematian - Neo System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #4ecdc4;
            --warning-color: #ffd166;
            --danger-color: #ef476f;
            --dark-color: #2d3748;
            --light-color: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            --gradient-success: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            --gradient-warning: linear-gradient(135deg, #ffd166 0%, #ff9e66 100%);
            --gradient-danger: linear-gradient(135deg, #ef476f 0%, #ff6b6b 100%);
            --gradient-dark: linear-gradient(135deg, #0f0f1b 0%, #1a1a2e 100%);
        }

        body {
            background: var(--gradient-dark);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(239, 71, 111, 0.1) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 { width: 200px; height: 200px; top: 10%; left: 5%; animation-delay: 0s; }
        .shape-2 { width: 150px; height: 150px; top: 60%; right: 10%; animation-delay: 2s; }
        .shape-3 { width: 100px; height: 100px; bottom: 20%; left: 20%; animation-delay: 4s; }
        .shape-4 { width: 180px; height: 180px; top: 30%; right: 15%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            50% { transform: translateY(-25px) rotate(180deg) scale(1.1); }
        }

        /* Cyber Grid */
        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(90deg, rgba(239, 71, 111, 0.03) 1px, transparent 1px),
                linear-gradient(180deg, rgba(239, 71, 111, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: -1;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .form-container {
            max-width: 1000px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(25px);
            border-radius: 30px;
            border: 1px solid rgba(239, 71, 111, 0.3);
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.4),
                0 0 100px rgba(239, 71, 111, 0.2),
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
                rgba(239, 71, 111, 0.15),
                transparent);
            transition: left 0.8s ease;
        }

        .form-container:hover::before {
            left: 100%;
        }

        .form-header {
            background: var(--gradient-danger);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,0 1000,100 0,100"></polygon></svg>');
            background-size: cover;
        }

        .form-title {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #ffffff, #ffd6d6, #ffb8b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: titleGlow 3s ease-in-out infinite alternate;
            position: relative;
        }

        @keyframes titleGlow {
            from {
                text-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            }
            to {
                text-shadow: 0 12px 45px rgba(0, 0, 0, 0.5), 0 0 60px rgba(239, 71, 111, 0.3);
            }
        }

        .form-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
            position: relative;
            color: rgba(255, 255, 255, 0.9);
        }

        .form-body {
            padding: 50px;
        }

        .form-section {
            margin-bottom: 40px;
            position: relative;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(239, 71, 111, 0.4);
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100px;
            height: 3px;
            background: var(--gradient-danger);
            border-radius: 3px;
            animation: sectionLine 2s ease-in-out infinite alternate;
        }

        @keyframes sectionLine {
            from { width: 100px; }
            to { width: 150px; }
        }

        .section-title i {
            background: var(--gradient-danger);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.3rem;
        }

        .form-label {
            font-weight: 700;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .form-label i {
            color: var(--danger-color);
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .form-control, .form-select, .select2-container--default .select2-selection--single {
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 16px 20px;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.08);
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .form-control::placeholder, .form-select::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus, .form-select:focus,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--danger-color);
            box-shadow:
                0 0 0 4px rgba(239, 71, 111, 0.15),
                0 8px 30px rgba(239, 71, 111, 0.3);
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-3px);
            color: white;
        }

        .form-control:hover, .form-select:hover {
            border-color: rgba(239, 71, 111, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .form-select option {
            background: #2d3748;
            color: white;
        }

        /* Select2 Customization */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: white transparent transparent transparent;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent white transparent;
        }

        .select2-dropdown {
            background: #2d3748;
            border: 2px solid var(--danger-color);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(239, 71, 111, 0.3);
        }

        .select2-container--default .select2-results__option {
            color: white;
            padding: 10px 20px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: var(--gradient-danger);
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background: rgba(239, 71, 111, 0.3);
        }

        .btn-neo-danger {
            background: var(--gradient-danger);
            border: none;
            color: white;
            padding: 18px 40px;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:
                0 12px 35px rgba(239, 71, 111, 0.5),
                0 0 60px rgba(239, 71, 111, 0.3);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-neo-danger::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent);
            transition: left 0.7s ease;
        }

        .btn-neo-danger:hover::before {
            left: 100%;
        }

        .btn-neo-danger:hover {
            transform: translateY(-6px) scale(1.05);
            box-shadow:
                0 20px 45px rgba(239, 71, 111, 0.7),
                0 0 80px rgba(239, 71, 111, 0.4);
        }

        .btn-neo-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid var(--danger-color);
            color: var(--danger-color);
            padding: 18px 40px;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1.2rem;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            letter-spacing: 0.5px;
        }

        .btn-neo-secondary:hover {
            background: var(--danger-color);
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(239, 71, 111, 0.5);
        }

        .form-actions {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 50px;
            padding-top: 40px;
            border-top: 2px solid rgba(239, 71, 111, 0.2);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
            z-index: 5;
            font-size: 1.1rem;
        }

        .form-control:focus + .input-icon {
            color: var(--danger-color);
            transform: translateY(-50%) scale(1.2);
            text-shadow: 0 0 10px rgba(239, 71, 111, 0.5);
        }

        .required-field::after {
            content: ' *';
            color: var(--danger-color);
            font-weight: bold;
            text-shadow: 0 0 10px rgba(239, 71, 111, 0.5);
        }

        /* Penduduk Info Box */
        .penduduk-info-box {
            background: linear-gradient(135deg, rgba(239, 71, 111, 0.15), rgba(255, 107, 107, 0.1));
            border-left: 4px solid var(--danger-color);
            padding: 25px;
            border-radius: 15px;
            height: 100%;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .penduduk-info-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .penduduk-info-title i {
            color: var(--danger-color);
        }

        .info-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .info-value {
            color: white;
            font-weight: 500;
            margin-top: 2px;
        }

        .form-note {
            background: linear-gradient(135deg, rgba(239, 71, 111, 0.2), rgba(255, 107, 107, 0.15));
            border-left: 4px solid var(--danger-color);
            padding: 20px 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .form-note i {
            color: var(--danger-color);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Alert Styles */
        .alert {
            border-radius: 15px;
            border: none;
            padding: 20px 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(78, 205, 196, 0.2), rgba(68, 160, 141, 0.15));
            border-left: 4px solid var(--success-color);
            color: rgba(255, 255, 255, 0.9);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 71, 111, 0.3), rgba(255, 107, 107, 0.25));
            border-left: 4px solid var(--danger-color);
            color: rgba(255, 255, 255, 0.9);
        }

        /* Validation States */
        .is-valid {
            border-color: var(--success-color) !important;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2) !important;
        }

        .is-invalid {
            border-color: var(--danger-color) !important;
            box-shadow: 0 0 0 3px rgba(239, 71, 111, 0.2) !important;
        }

        .invalid-feedback {
            display: block;
            color: var(--danger-color);
            font-weight: 600;
            margin-top: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* Particle Effects */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(239, 71, 111, 0.6);
            border-radius: 50%;
            animation: particleFloat 12s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Loading animation for submit */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 24px;
            height: 24px;
            margin: -12px 0 0 -12px;
            border: 3px solid transparent;
            border-top: 3px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Textarea styling */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        @media (max-width: 768px) {
            .form-container {
                margin: 20px auto;
                border-radius: 25px;
            }

            .form-header {
                padding: 40px 25px;
            }

            .form-body {
                padding: 40px 25px;
            }

            .form-title {
                font-size: 2.2rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
            }

            .btn-neo-danger,
            .btn-neo-secondary {
                width: 100%;
                text-align: center;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-danger);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #ff6b6b 0%, #ef476f 100%);
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
    </div>

    <!-- Cyber Grid -->
    <div class="cyber-grid"></div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">Catat Kematian Baru</h1>
            <p class="form-subtitle">Isi data kematian dengan lengkap dan akurat</p>
        </div>

        <div class="form-body">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-skull-crossbones me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form Note -->
            <div class="form-note">
                <i class="fas fa-info-circle"></i>
                <strong>Informasi Penting:</strong> Field yang ditandai dengan asterisk (*) wajib diisi. Pastikan data kematian yang dicatat akurat dan sesuai dengan dokumen resmi.
            </div>

            <form action="{{ route('kematian.store') }}" method="POST" id="kematianForm">
                @csrf

                <!-- Section 1: Data Penduduk -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>Data Penduduk
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="penduduk_id" class="form-label required-field">
                                    <i class="fas fa-user-circle"></i>Pilih Penduduk
                                </label>
                                <select name="penduduk_id" id="penduduk_id" class="form-select @error('penduduk_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Penduduk --</option>
                                    @foreach($penduduks as $penduduk)
                                        <option value="{{ $penduduk->id }}"
                                            {{ old('penduduk_id', request('penduduk_id')) == $penduduk->id ? 'selected' : '' }}
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
                            <div class="penduduk-info-box">
                                <h6 class="penduduk-info-title">
                                    <i class="fas fa-info-circle"></i>Informasi Penduduk Terpilih
                                </h6>
                                <div id="pendudukInfo">
                                    @if($selectedPenduduk)
                                        <div class="info-item">
                                            <div class="info-label">Nama Lengkap</div>
                                            <div class="info-value">{{ $selectedPenduduk->first_name }} {{ $selectedPenduduk->last_name }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">NIK</div>
                                            <div class="info-value">{{ $selectedPenduduk->nik ?: '-' }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Tanggal Lahir</div>
                                            <div class="info-value">{{ $selectedPenduduk->birthday->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Usia</div>
                                            <div class="info-value">{{ $selectedPenduduk->birthday->age }} tahun</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Jenis Kelamin</div>
                                            <div class="info-value">{{ $selectedPenduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                        </div>
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-user-slash fa-2x mb-3" style="color: rgba(255,255,255,0.3)"></i>
                                            <p class="mb-0" style="color: rgba(255,255,255,0.5)">Pilih penduduk untuk menampilkan informasi</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Kematian -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-cross"></i>Data Kematian
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tanggal_kematian" class="form-label required-field">
                                    <i class="fas fa-calendar-times"></i>Tanggal Kematian
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('tanggal_kematian') is-invalid @enderror"
                                           id="tanggal_kematian" name="tanggal_kematian"
                                           value="{{ old('tanggal_kematian') }}"
                                           max="{{ date('Y-m-d') }}" required>
                                    <i class="fas fa-calendar-alt input-icon"></i>
                                </div>
                                @error('tanggal_kematian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tempat_kematian" class="form-label required-field">
                                    <i class="fas fa-map-marker-alt"></i>Tempat Kematian
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('tempat_kematian') is-invalid @enderror"
                                           id="tempat_kematian" name="tempat_kematian"
                                           value="{{ old('tempat_kematian') }}"
                                           placeholder="Contoh: RSUD, Rumah, Jalan Raya, dll" required>
                                    <i class="fas fa-hospital input-icon"></i>
                                </div>
                                @error('tempat_kematian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Penyebab Kematian -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-stethoscope"></i>Penyebab Kematian
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="penyebab_kematian" class="form-label required-field">
                                    <i class="fas fa-diagnoses"></i>Penyebab Kematian
                                </label>
                                <select name="penyebab_kematian" id="penyebab_kematian"
                                        class="form-select @error('penyebab_kematian') is-invalid @enderror" required>
                                    <option value="">-- Pilih Penyebab --</option>
                                    <option value="sakit_biasa" {{ old('penyebab_kematian') == 'sakit_biasa' ? 'selected' : '' }}>Sakit Biasa</option>
                                    <option value="kecelakaan" {{ old('penyebab_kematian') == 'kecelakaan' ? 'selected' : '' }}>Kecelakaan</option>
                                    <option value="bunuh_diri" {{ old('penyebab_kematian') == 'bunuh_diri' ? 'selected' : '' }}>Bunuh Diri</option>
                                    <option value="pembunuhan" {{ old('penyebab_kematian') == 'pembunuhan' ? 'selected' : '' }}>Pembunuhan</option>
                                    <option value="lainnya" {{ old('penyebab_kematian') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('penyebab_kematian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="keterangan_penyebab" class="form-label">
                                    <i class="fas fa-file-medical-alt"></i>Keterangan Penyebab
                                </label>
                                <textarea name="keterangan_penyebab" id="keterangan_penyebab"
                                          class="form-control @error('keterangan_penyebab') is-invalid @enderror"
                                          rows="3" placeholder="Jelaskan secara singkat penyebab kematian">{{ old('keterangan_penyebab') }}</textarea>
                                @error('keterangan_penyebab')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Data Pemakaman -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-monument"></i>Data Pemakaman
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="dimakamkan_di" class="form-label required-field">
                                    <i class="fas fa-tombstone"></i>Tempat Pemakaman
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('dimakamkan_di') is-invalid @enderror"
                                           id="dimakamkan_di" name="dimakamkan_di"
                                           value="{{ old('dimakamkan_di') }}"
                                           placeholder="Contoh: TPU Umum, Makam Keluarga, dll" required>
                                    <i class="fas fa-archway input-icon"></i>
                                </div>
                                @error('dimakamkan_di')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tanggal_pemakaman" class="form-label required-field">
                                    <i class="fas fa-calendar-day"></i>Tanggal Pemakaman
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('tanggal_pemakaman') is-invalid @enderror"
                                           id="tanggal_pemakaman" name="tanggal_pemakaman"
                                           value="{{ old('tanggal_pemakaman') }}" required>
                                    <i class="fas fa-calendar-check input-icon"></i>
                                </div>
                                @error('tanggal_pemakaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Data Administrasi -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-file-alt"></i>Data Administrasi
                    </h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="status_pencatatan" class="form-label required-field">
                                    <i class="fas fa-clipboard-check"></i>Status Pencatatan
                                </label>
                                <select name="status_pencatatan" id="status_pencatatan"
                                        class="form-select @error('status_pencatatan') is-invalid @enderror" required>
                                    <option value="sementara" {{ old('status_pencatatan') == 'sementara' ? 'selected' : '' }}>Sementara</option>
                                    <option value="permanen" {{ old('status_pencatatan') == 'permanen' ? 'selected' : '' }}>Permanen</option>
                                </select>
                                @error('status_pencatatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="surat_kematian_no" class="form-label">
                                    <i class="fas fa-file-contract"></i>Nomor Surat Kematian
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('surat_kematian_no') is-invalid @enderror"
                                           id="surat_kematian_no" name="surat_kematian_no"
                                           value="{{ old('surat_kematian_no') }}"
                                           placeholder="Nomor surat jika ada">
                                    <i class="fas fa-hashtag input-icon"></i>
                                </div>
                                @error('surat_kematian_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="surat_kematian_tanggal" class="form-label">
                                    <i class="fas fa-calendar-plus"></i>Tanggal Surat Kematian
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control @error('surat_kematian_tanggal') is-invalid @enderror"
                                           id="surat_kematian_tanggal" name="surat_kematian_tanggal"
                                           value="{{ old('surat_kematian_tanggal') }}"
                                           max="{{ date('Y-m-d') }}">
                                    <i class="fas fa-calendar input-icon"></i>
                                </div>
                                @error('surat_kematian_tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 6: Catatan Tambahan -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-sticky-note"></i>Catatan Tambahan
                    </h3>
                    <div class="mb-4">
                        <label for="catatan_tambahan" class="form-label">
                            <i class="fas fa-edit"></i>Catatan
                        </label>
                        <textarea name="catatan_tambahan" id="catatan_tambahan"
                                  class="form-control @error('catatan_tambahan') is-invalid @enderror"
                                  rows="4" placeholder="Catatan lain yang perlu dicatat">{{ old('catatan_tambahan') }}</textarea>
                        @error('catatan_tambahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-neo-danger" id="submitBtn">
                        <i class="fas fa-skull-crossbones me-2"></i>Catat Kematian
                    </button>
                    <a href="{{ route('kematian.index') }}" class="btn btn-neo-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Create particles
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.animationDelay = Math.random() * 12 + 's';
                particle.style.animationDuration = (Math.random() * 8 + 8) + 's';
                container.appendChild(particle);
            }
        }

        // Fungsi untuk menampilkan info penduduk
        function showPendudukInfo(pendudukId) {
            const select = document.getElementById('penduduk_id');
            const selectedOption = select.options[select.selectedIndex];
            const infoBox = document.getElementById('pendudukInfo');

            if (pendudukId && selectedOption.dataset.nik) {
                const html = `
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">${selectedOption.dataset.nama}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">NIK</div>
                        <div class="info-value">${selectedOption.dataset.nik || '-'}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Lahir</div>
                        <div class="info-value">${selectedOption.dataset.tanggalLahir}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Usia</div>
                        <div class="info-value">${selectedOption.dataset.usia} tahun</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">${selectedOption.dataset.gender}</div>
                    </div>
                `;
                infoBox.innerHTML = html;
            } else {
                infoBox.innerHTML = `
                    <div class="text-center py-3">
                        <i class="fas fa-user-slash fa-2x mb-3" style="color: rgba(255,255,255,0.3)"></i>
                        <p class="mb-0" style="color: rgba(255,255,255,0.5)">Pilih penduduk untuk menampilkan informasi</p>
                    </div>
                `;
            }
        }

        // Set min date for pemakaman based on kematian date
        function setupDateValidation() {
            const kematianInput = document.getElementById('tanggal_kematian');
            const pemakamanInput = document.getElementById('tanggal_pemakaman');

            kematianInput.addEventListener('change', function() {
                if (this.value) {
                    pemakamanInput.setAttribute('min', this.value);
                    // Set default pemakaman date to next day
                    if (!pemakamanInput.value) {
                        const nextDay = new Date(this.value);
                        nextDay.setDate(nextDay.getDate() + 1);
                        pemakamanInput.value = nextDay.toISOString().split('T')[0];
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            createParticles();

            // Initialize Select2 for penduduk selection
            $('#penduduk_id').select2({
                placeholder: 'Pilih Penduduk',
                allowClear: false,
                theme: 'default',
                width: '100%'
            }).on('change', function() {
                showPendudukInfo(this.value);
            });

            // Initialize with current selected value
            const initialPendudukId = document.getElementById('penduduk_id').value;
            if (initialPendudukId) {
                showPendudukInfo(initialPendudukId);
            }

            setupDateValidation();

            const form = document.getElementById('kematianForm');
            const submitBtn = document.getElementById('submitBtn');

            // Add loading state to submit button
            form.addEventListener('submit', function() {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                const tanggalKematian = document.getElementById('tanggal_kematian').value;
                const tanggalPemakaman = document.getElementById('tanggal_pemakaman').value;

                if (tanggalKematian && tanggalPemakaman) {
                    if (new Date(tanggalPemakaman) < new Date(tanggalKematian)) {
                        e.preventDefault();
                        alert('Tanggal pemakaman tidak boleh sebelum tanggal kematian!');
                        document.getElementById('tanggal_pemakaman').focus();
                    }
                }

                // Validate required fields
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Harap lengkapi semua field yang wajib diisi!');
                }
            });

            // Add real-time validation
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            function validateField(field) {
                if (field.value.trim() === '') {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            }

            // Add staggered animation to form sections
            const formSections = document.querySelectorAll('.form-section');
            formSections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';

                setTimeout(() => {
                    section.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 200 + 300);
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });
        });

        // Add hover effects
        document.querySelectorAll('.form-control, .form-select').forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            element.addEventListener('mouseleave', function() {
                if (document.activeElement !== this) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
    </script>
</body>
</html>
