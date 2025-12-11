<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kependudukan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        :root {
            --bg-primary: #0f0f1b;
            --bg-secondary: #1a1a2e;
            --bg-tertiary: #16213e;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.9);
            --text-muted: rgba(255, 255, 255, 0.7);
            --accent-primary: #667eea;
            --accent-secondary: #764ba2;
            --accent-tertiary: #4ecdc4;
            --card-bg: rgba(255, 255, 255, 0.08);
            --card-border: rgba(102, 126, 234, 0.3);
            --shadow-color: rgba(0, 0, 0, 0.4);
        }

        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #e2e8f0;
            --bg-tertiary: #cbd5e1;
            --text-primary: #1e293b;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --accent-primary: #3b82f6;
            --accent-secondary: #8b5cf6;
            --accent-tertiary: #06b6d4;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(59, 130, 246, 0.3);
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-tertiary) 100%);
            min-height: 100vh;
            color: var(--text-primary);
            position: relative;
            overflow-x: hidden;
            transition: all 0.5s ease;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            border-right: 1px solid var(--card-border);
            box-shadow: 5px 0 25px var(--shadow-color);
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-content {
            padding: 30px 0;
            height: 100%;
        }

        .sidebar-header {
            padding: 0 25px 25px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .user-avatar-sidebar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 15px;
            border: 3px solid var(--accent-primary);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
        }

        .user-avatar-sidebar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            opacity: 0.7;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 5px;
            position: relative;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--text-primary);
            border-left-color: var(--accent-primary);
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
            color: var(--text-primary);
            border-left-color: var(--accent-primary);
        }

        .sidebar-icon {
            width: 20px;
            margin-right: 15px;
            font-size: 16px;
            text-align: center;
        }

        .sidebar-text {
            flex: 1;
            font-weight: 600;
            font-size: 14px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* Background Animation */
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
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Cyber Grid */
        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(90deg, rgba(102, 126, 234, 0.03) 1px, transparent 1px),
                linear-gradient(180deg, rgba(102, 126, 234, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: -1;
        }

        [data-theme="light"] .cyber-grid {
            background:
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(180deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(25px);
            border-radius: 25px;
            border: 1px solid var(--card-border);
            box-shadow: 0 20px 40px var(--shadow-color),
                0 0 80px rgba(102, 126, 234, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 20px 40px var(--shadow-color),
                0 0 60px rgba(59, 130, 246, 0.1);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .header:hover::before {
            left: 100%;
        }

        .welcome {
            color: var(--text-secondary);
            font-size: 16px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .header h1 {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 38px;
            font-weight: 800;
        }

        .header h1::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            border-radius: 10px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            border: 1px solid var(--card-border);
        }

        .avatar-header {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--accent-primary);
        }

        .avatar-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
        }

        .nav-btn,
        .logout-btn {
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .nav-btn {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            color: white;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef476f, #ff6b6b);
            color: white;
            box-shadow: 0 5px 20px rgba(239, 71, 111, 0.3);
        }

        .nav-btn:hover,
        .logout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: relative;
            width: 60px;
            height: 30px;
        }

        .toggle-input {
            display: none;
        }

        .toggle-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid var(--card-border);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .toggle-label::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 50%;
            transition: all 0.4s ease;
        }

        .toggle-input:checked+.toggle-label::before {
            transform: translateX(30px);
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        /* Alert */
        .alert {
            background: rgba(39, 174, 96, 0.2);
            border: 1px solid rgba(39, 174, 96, 0.5);
            color: #2ecc71;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            backdrop-filter: blur(15px);
            border-left: 6px solid #2ecc71;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px var(--shadow-color);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px var(--shadow-color);
        }

        .stat-icon {
            font-size: 42px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 16px;
            font-weight: 600;
        }

        /* Charts */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .chart-container {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 25px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 15px 35px var(--shadow-color);
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-wrapper {
            height: 250px;
            width: 100%;
        }

        /* Progress Bars */
        .progress-stats {
            margin-top: 20px;
        }

        .progress-item {
            margin-bottom: 15px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
        }

        /* Timeline */
        .timeline {
            margin-top: 20px;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            border-left: 3px solid var(--accent-primary);
            transition: all 0.3s ease;
        }

        .timeline-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(5px);
        }

        .timeline-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .timeline-icon i {
            color: white;
            font-size: 0.9rem;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .timeline-time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .main-content-area,
        .sidebar-right {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 15px 35px var(--shadow-color);
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 25px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.3);
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .action-btn {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            padding: 20px;
            border-radius: 15px;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-5px);
            border-color: var(--accent-primary);
        }

        .action-icon {
            font-size: 28px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-text {
            font-weight: 600;
            font-size: 14px;
        }

        /* User Info */
        .user-info {
            background: rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-label {
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
        }

        .info-value {
            color: var(--text-primary);
            font-size: 16px;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 1200px) {

            .charts-grid,
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar .sidebar-text,
            .sidebar .sidebar-subtitle,
            .sidebar-title {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .sidebar-link {
                justify-content: center;
                padding: 15px;
            }

            .sidebar-icon {
                margin-right: 0;
                font-size: 20px;
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .header-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .user-profile {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <!-- Cyber Grid -->
    <div class="cyber-grid"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
    <div class="user-avatar-sidebar">
        <!-- Gambar custom Anda -->
        <img src="{{ asset('images/logo.png') }}"
             alt="Logo Penduduk"
             style="width:100%;height:100%;object-fit:contain;padding:15px;">
    </div>
    <div class="sidebar-title">Sistem Kependudukan</div>
    <div class="sidebar-subtitle">{{ auth()->user()->name }}</div>
</div>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="/dashboard" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <div class="sidebar-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <div class="sidebar-text">Dashboard</div>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('penduduk.index') }}"
                            class="sidebar-link {{ request()->is('penduduk*') ? 'active' : '' }}">
                            <div class="sidebar-icon"><i class="fas fa-users"></i></div>
                            <div class="sidebar-text">Data Penduduk</div>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('kelahiran.index') }}"
                            class="sidebar-link {{ request()->is('kelahiran*') ? 'active' : '' }}">
                            <div class="sidebar-icon"><i class="fas fa-baby"></i></div>
                            <div class="sidebar-text">Data Kelahiran</div>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('orangtua.index') }}"
                            class="sidebar-link {{ request()->is('orangtua*') ? 'active' : '' }}">
                            <div class="sidebar-icon"><i class="fas fa-user-friends"></i></div>
                            <div class="sidebar-text">Data Orang Tua</div>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('kematian.index') }}"
                            class="sidebar-link {{ request()->is('kematian*') ? 'active' : '' }}">
                            <div class="sidebar-icon"><i class="fas fa-user-friends"></i></div>
                            <div class="sidebar-text">Data kematian</div>
                        </a>
                    </li>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fas fa-cog"></i></div>
                            <div class="sidebar-text">Pengaturan</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-container">
                <!-- Header -->
                <div class="header">
                    <div>
                        <p class="welcome">Selamat Datang di Sistem Kependudukan</p>
                        <h1>Dashboard Administrator</h1>
                    </div>

                    <div class="header-actions">
                        <div class="user-profile">
                            <div class="avatar-header">
                                @if (auth()->check() && auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="{{ auth()->user()->name }}">
                                @else
                                    <div
                                        style="width:100%;height:100%;background:linear-gradient(135deg, #667eea, #764ba2);display:flex;align-items:center;justify-content:center;color:white;font-size:16px;font-weight:bold;">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="user-name">{{ auth()->user()->name }}</div>
                        </div>

                        <div class="theme-toggle">
                            <input type="checkbox" id="theme-toggle" class="toggle-input">
                            <label for="theme-toggle" class="toggle-label"></label>
                        </div>

                        <a href="{{ route('penduduk.index') }}" class="nav-btn">
                            <i class="fas fa-users"></i> Kelola Data
                        </a>

                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn" onclick="return confirm('Yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Alert Session -->
                @if (session('success'))
                    <div class="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif


                <!-- Statistics Grid -->

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-number">{{ $totalPenduduk ?? 0 }}</div>
                        <div class="stat-label">Total Penduduk</div>

                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-baby"></i></div>
                        <div class="stat-number">{{ $totalKelahiran ?? 0 }}</div>
                        <div class="stat-label">Data Kelahiran</div>
                        <span class="stat-subtext">{{ $kelahiranBaru ?? 0 }} baru bulan ini</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-user-friends"></i></div>
                        <div class="stat-number">{{ $totalOrangTua ?? 0 }}</div>
                        <div class="stat-label">Data Orang Tua</div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="charts-grid">
                    <!-- Main Chart -->
                    <div class="chart-container">
                        <h3 class="chart-title"><i class="fas fa-chart-line"></i> Grafik Pertumbuhan (6 Bulan
                            Terakhir)</h3>
                        <div class="chart-wrapper">
                            <canvas id="populationChart" data-labels='@json($chartLabels ?? [])'
                                data-values='@json($chartValues ?? [])'></canvas>
                        </div>
                    </div>

                    <!-- Gender Distribution -->
                    <div class="chart-container">
                        <h3 class="chart-title"><i class="fas fa-chart-pie"></i> Distribusi Gender
                            ({{ $totalPenduduk ?? 0 }} Data)</h3>

                        <!-- Donut Chart -->
                        <div class="donut-chart-container">
                            <div class="donut-chart">
                                <div class="donut-segment"
                                    style="background: conic-gradient(#667eea 0% {{ $persentaseLaki ?? 0 }}%, #764ba2 {{ $persentaseLaki ?? 0 }}% 100%);">
                                </div>
                                <div class="donut-center">{{ $persentaseLaki ?? 0 }}%</div>
                            </div>
                        </div>

                        <!-- Progress Stats -->
                        <div class="progress-stats">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Laki-laki</span>
                                    <span>{{ $totalLaki ?? 0 }} ({{ $persentaseLaki ?? 0 }}%)</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $persentaseLaki ?? 0 }}%;"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Perempuan</span>
                                    <span>{{ $totalPerempuan ?? 0 }} ({{ $persentasePerempuan ?? 0 }}%)</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                        style="width: {{ $persentasePerempuan ?? 0 }}%; background: linear-gradient(90deg, #ef476f, #ff6b6b);">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="charts-grid">
                    <!-- Activity Timeline -->
                    <div class="chart-container">
                        <h3 class="chart-title"><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                        <div class="timeline">
                            @forelse($aktivitasTerbaru ?? [] as $aktivitas)
                                <div class="timeline-item">
                                    <div class="timeline-icon"><i
                                            class="fas {{ $aktivitas['icon'] ?? 'fa-info-circle' }}"></i></div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">{{ $aktivitas['judul'] ?? 'Aktivitas' }}</div>
                                        <div class="timeline-time">{{ $aktivitas['waktu'] ?? 'Baru saja' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="timeline-item">
                                    <div class="timeline-icon"><i class="fas fa-info-circle"></i></div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Belum ada aktivitas</div>
                                        <div class="timeline-time">Mulai tambah data penduduk</div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Age Distribution -->
                    <div class="chart-container">
                        <h3 class="chart-title"><i class="fas fa-child"></i> Distribusi Usia</h3>
                        <div class="chart-wrapper">
                            <canvas id="ageChart" data-labels='@json(isset($distribusiUsia) ? collect($distribusiUsia)->pluck('range')->toArray() : [])'
                                data-values='@json(isset($distribusiUsia) ? collect($distribusiUsia)->pluck('persentase')->toArray() : [])'
                                data-colors='@json(isset($distribusiUsia) ? collect($distribusiUsia)->pluck('warna')->toArray() : [])'></canvas>
                        </div>

                        <!-- Age Distribution Cards -->
                        @if (isset($distribusiUsia) && count($distribusiUsia) > 0)
                            <div class="age-distribution">
                                @foreach ($distribusiUsia as $usia)
                                    <div class="age-card" style="border-left: 4px solid {{ $usia['warna'] }};">
                                        <div class="age-percent" style="color: {{ $usia['warna'] }};">
                                            {{ $usia['persentase'] }}%
                                        </div>
                                        <div class="age-range">{{ $usia['range'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="content-grid">
                    <div class="main-content-area">
                        <h2 class="section-title">Statistik Kependudukan</h2>

                        <p>Sistem kependudukan berjalan optimal dengan data real-time yang terintegrasi. Total penduduk
                            terdaftar: <strong>{{ $totalPenduduk ?? 0 }} orang</strong>.</p>

                        <p>Monitoring menunjukkan distribusi penduduk berdasarkan data aktual:
                            <strong>{{ $totalLaki ?? 0 }} laki-laki</strong> ({{ $persentaseLaki ?? 0 }}%) dan
                            <strong>{{ $totalPerempuan ?? 0 }} perempuan</strong> ({{ $persentasePerempuan ?? 0 }}%).
                        </p>

                        @if (isset($distribusiUsia) && count($distribusiUsia) > 0)
                            <div
                                style="margin: 20px 0; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 10px;">
                                <h4 style="margin-bottom: 15px; color: var(--accent-primary);">Analisis Usia Penduduk:
                                </h4>
                                <p>Berdasarkan data {{ $totalPenduduk ?? 0 }} penduduk, distribusi usia menunjukkan
                                    mayoritas penduduk berada pada kelompok usia produktif (18-55 tahun).</p>
                            </div>
                        @endif

                        <div class="quick-actions">
                            <a href="{{ route('penduduk.index') }}" class="action-btn">
                                <div class="action-icon"><i class="fas fa-users"></i></div>
                                <div class="action-text">Lihat Data Penduduk</div>
                            </a>
                            <a href="{{ route('kelahiran.index') }}" class="action-btn">
                                <div class="action-icon"><i class="fas fa-baby"></i></div>
                                <div class="action-text">Data Kelahiran</div>
                            </a>
                            <a href="{{ route('orangtua.index') }}" class="action-btn">
                                <div class="action-icon"><i class="fas fa-user-friends"></i></div>
                                <div class="action-text">Data Orang Tua</div>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-right">
                        <h2 class="section-title">Informasi Sistem</h2>
                        <div class="user-info">
                            <div class="info-label">Hari & Tanggal</div>
                            <div class="info-value" id="currentDateTime">Loading...</div>
                        </div>
                        <div class="user-info">
                            <div class="info-label">ID Petugas</div>
                            <div class="info-value">ADM-{{ auth()->user()->id ?? rand(1000, 9999) }}</div>
                        </div>
                        <div class="user-info">
                            <div class="info-label">Wilayah Kerja</div>
                            <div class="info-value">{{ $wilayahKerja ?? 'Kota Jakarta Pusat' }}</div>
                        </div>
                        <div class="user-info">
                            <div class="info-label">Status Sistem</div>
                            <div class="info-value" style="color: #4ecdc4;">
                                <i class="fas fa-circle" style="font-size: 10px; margin-right: 5px;"></i>
                                Online - {{ $totalPenduduk ?? 0 }} data tersedia
                            </div>
                        </div>
                        <div class="user-info">
                            <div class="info-label">Data Dummy</div>
                            <div class="info-value" style="color: #f59e0b;">
                                <i class="fas fa-database" style="font-size: 10px; margin-right: 5px;"></i>
                                100 Data Penduduk
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const currentTheme = localStorage.getItem('theme') || 'dark';

        document.documentElement.setAttribute('data-theme', currentTheme);
        themeToggle.checked = currentTheme === 'light';

        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Update Date Time
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const dateTimeString = now.toLocaleDateString('id-ID', options);
            document.getElementById('currentDateTime').textContent = dateTimeString;
        }

        // Initialize Charts dengan data dari Blade
        function initializeCharts() {
            // Population Chart
            const populationCanvas = document.getElementById('populationChart');
            if (populationCanvas) {
                const popLabels = JSON.parse(populationCanvas.dataset.labels || '[]');
                const popValues = JSON.parse(populationCanvas.dataset.values || '[]');

                // Jika data kosong, berikan data default
                const labels = popLabels.length > 0 ? popLabels : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
                const values = popValues.length > 0 ? popValues : [10, 20, 30, 40, 50, 60];

                new Chart(populationCanvas.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: values,
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Age Distribution Chart
            const ageCanvas = document.getElementById('ageChart');
            if (ageCanvas) {
                const ageLabels = JSON.parse(ageCanvas.dataset.labels || '[]');
                const ageValues = JSON.parse(ageCanvas.dataset.values || '[]');
                const ageColors = JSON.parse(ageCanvas.dataset.colors || '[]');

                // Jika data kosong, berikan data default
                const labels = ageLabels.length > 0 ? ageLabels : ['0-17', '18-35', '36-55', '55+'];
                const values = ageValues.length > 0 ? ageValues : [25, 45, 20, 10];
                const colors = ageColors.length > 0 ? ageColors : ['#667eea', '#764ba2', '#4ecdc4', '#ef476f'];

                new Chart(ageCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Persentase',
                            data: values,
                            backgroundColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        }

        // Initialize
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Tunggu DOM siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCharts);
        } else {
            initializeCharts();
        }

        // Sidebar active state
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>
