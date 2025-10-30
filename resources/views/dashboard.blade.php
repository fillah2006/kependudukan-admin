<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kependudukan - Neo System</title>
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

        /* Layout Structure */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
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

        .sidebar-badge {
            background: var(--accent-primary);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 700;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 20px;
            transition: all 0.3s ease;
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
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 { width: 300px; height: 300px; top: 10%; left: 5%; animation-delay: 0s; }
        .shape-2 { width: 200px; height: 200px; top: 60%; right: 10%; animation-delay: 2s; }
        .shape-3 { width: 150px; height: 150px; bottom: 20%; left: 20%; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
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
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Styles */
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
            box-shadow:
                0 20px 40px var(--shadow-color),
                0 0 80px rgba(102, 126, 234, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow:
                0 20px 40px var(--shadow-color),
                0 0 60px rgba(59, 130, 246, 0.1);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(102, 126, 234, 0.2),
                transparent);
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
            text-shadow: 0 2px 10px var(--shadow-color);
        }

        .header h1 {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary), #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 38px;
            font-weight: 800;
            text-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
            position: relative;
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

        .nav-btn {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.4s ease;
            box-shadow:
                0 8px 25px rgba(102, 126, 234, 0.4),
                0 0 30px rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
            transition: left 0.5s ease;
        }

        .nav-btn:hover::before {
            left: 100%;
        }

        .nav-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow:
                0 15px 35px rgba(102, 126, 234, 0.6),
                0 0 50px rgba(102, 126, 234, 0.3);
        }

        /* Logout Button */
        .logout-btn {
            background: linear-gradient(135deg, #ef476f, #ff6b6b);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.4s ease;
            box-shadow:
                0 8px 25px rgba(239, 71, 111, 0.4),
                0 0 30px rgba(239, 71, 111, 0.2);
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }

        .logout-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow:
                0 15px 35px rgba(239, 71, 111, 0.6),
                0 0 50px rgba(239, 71, 111, 0.3);
        }

        /* Ghost Toggle Switch */
        .theme-toggle {
            position: relative;
            width: 80px;
            height: 40px;
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
            box-shadow:
                0 4px 15px var(--shadow-color),
                inset 0 2px 5px rgba(255, 255, 255, 0.1);
        }

        .toggle-label::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 50%;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.3),
                0 0 15px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }

        .toggle-input:checked + .toggle-label::before {
            transform: translateX(40px);
            background: linear-gradient(135deg, #f59e0b, #d97706);
            content: '☀️';
        }

        .toggle-input:not(:checked) + .toggle-label::before {
            content: '🌙';
        }

        .toggle-label::after {
            content: 'Light';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .toggle-input:checked + .toggle-label::after {
            content: 'Dark';
            left: 10px;
            right: auto;
            opacity: 1;
        }

        .toggle-input:not(:checked) + .toggle-label::after {
            opacity: 1;
        }

        /* Alert Styles */
        .alert {
            background: rgba(39, 174, 96, 0.2);
            border: 1px solid rgba(39, 174, 96, 0.5);
            color: #2ecc71;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            backdrop-filter: blur(15px);
            border-left: 6px solid #2ecc71;
            box-shadow:
                0 10px 30px rgba(39, 174, 96, 0.3),
                0 0 40px rgba(39, 174, 96, 0.1);
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 35px 30px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 15px 35px var(--shadow-color),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-12px) scale(1.02);
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(102, 126, 234, 0.6);
            box-shadow:
                0 25px 50px var(--shadow-color),
                0 0 60px rgba(102, 126, 234, 0.2);
        }

        .stat-icon {
            font-size: 42px;
            margin-bottom: 25px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 8px 25px rgba(102, 126, 234, 0.4));
            position: relative;
            display: inline-block;
        }

        .stat-icon::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 10px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary), #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Chart Styles */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .chart-container {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow:
                0 15px 35px var(--shadow-color),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow:
                0 20px 45px var(--shadow-color),
                0 0 70px rgba(102, 126, 234, 0.15);
        }

        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            border-radius: 20px 20px 0 0;
        }

        .chart-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 25px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chart-title i {
            font-size: 1.2rem;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .chart-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            border: 2px dashed rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .chart-placeholder:hover {
            border-color: var(--accent-primary);
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.02);
        }

        .chart-placeholder i {
            font-size: 3rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0.7;
        }

        .chart-placeholder-text {
            color: var(--text-muted);
            font-size: 1rem;
            text-align: center;
            max-width: 200px;
        }

        /* Progress Bars */
        .progress-stats {
            margin-top: 25px;
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
            position: relative;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            position: relative;
            transition: width 1.5s ease-in-out;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Donut Chart */
        .donut-chart {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .donut-segment {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            clip-path: polygon(50% 50%, 50% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 0%);
        }

        .donut-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: var(--bg-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border: 2px solid rgba(102, 126, 234, 0.3);
        }

        /* Timeline */
        .timeline {
            margin-top: 25px;
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
            color: var(--text-primary);
        }

        .timeline-time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .main-content {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 35px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow:
                0 15px 35px var(--shadow-color),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary), var(--accent-tertiary));
            border-radius: 20px 20px 0 0;
        }

        .sidebar-right {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            padding: 35px;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow:
                0 15px 35px var(--shadow-color),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .sidebar-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-tertiary), var(--accent-primary), var(--accent-secondary));
            border-radius: 20px 20px 0 0;
        }

        .section-title {
            font-size: 26px;
            margin-bottom: 30px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border-bottom: 3px solid rgba(102, 126, 234, 0.4);
            padding-bottom: 15px;
            font-weight: 800;
            text-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 10px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .action-btn {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
            backdrop-filter: blur(15px);
        }

        .action-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-5px);
            border-color: var(--accent-primary);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .action-icon {
            font-size: 32px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-text {
            font-weight: 600;
            font-size: 14px;
        }

        /* User Info Styles */
        .user-info {
            background: rgba(255, 255, 255, 0.08);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        [data-theme="light"] .user-info {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .user-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(102, 126, 234, 0.1),
                transparent);
            transition: left 0.6s ease;
        }

        .user-info:hover::before {
            left: 100%;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(10px) scale(1.02);
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 10px 25px var(--shadow-color);
        }

        .info-label {
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .info-value {
            color: var(--text-primary);
            font-size: 18px;
            font-weight: 700;
        }

        /* Main Content Text */
        .main-content p {
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 16px;
            text-shadow: 0 2px 10px var(--shadow-color);
            margin-bottom: 20px;
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
            background: rgba(102, 126, 234, 0.6);
            border-radius: 50%;
            animation: particleFloat 8s linear infinite;
        }

        [data-theme="light"] .particle {
            background: rgba(59, 130, 246, 0.4);
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

        /* Glow Effects */
        .glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow:
                    0 0 20px rgba(102, 126, 234, 0.4),
                    0 0 40px rgba(102, 126, 234, 0.2);
            }
            to {
                box-shadow:
                    0 0 30px rgba(102, 126, 234, 0.6),
                    0 0 60px rgba(102, 126, 234, 0.3);
            }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .header h1 {
                font-size: 28px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .chart-wrapper {
                height: 250px;
            }

            .dashboard-container {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .chart-wrapper {
                height: 200px;
            }

            .chart-container {
                padding: 20px;
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

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div class="sidebar-title">Sistem Kependudukan</div>
                    <div class="sidebar-subtitle">Administrator Panel</div>
                </div>

                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="/dashboard" class="sidebar-link active">
                            <div class="sidebar-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div class="sidebar-text">Dashboard</div>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="{{ route('penduduk.index') }}" class="sidebar-link">
                            <div class="sidebar-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="sidebar-text">Data Penduduk</div>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="{{ route('kelahiran.index') }}" class="sidebar-link">
                            <div class="sidebar-icon">
                                <i class="fas fa-baby"></i>
                            </div>
                            <div class="sidebar-text">Data Kelahiran</div>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="{{ route('orangtua.index') }}" class="sidebar-link">
                            <div class="sidebar-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="sidebar-text">Data Orang Tua</div>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="sidebar-text">Laporan</div>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon">
                                <i class="fas fa-cog"></i>
                            </div>
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
                        <!-- Ghost Toggle Switch -->
                        <div class="theme-toggle">
                            <input type="checkbox" id="theme-toggle" class="toggle-input">
                            <label for="theme-toggle" class="toggle-label"></label>
                        </div>
                        <a href="{{ route('penduduk.index') }}" class="nav-btn">
                            <i class="fas fa-users"></i> Kelola Data
                        </a>
                        <a href="/auth" class="logout-btn" onclick="return confirm('Yakin ingin logout?')">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>

                <!-- Alert Session -->
                @if(session('success'))
                    <div class="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">{{ $totalPenduduk ?? '0' }}</div>
                        <div class="stat-label">Total Penduduk</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-number">{{ $pendudukBaru ?? '0' }}</div>
                        <div class="stat-label">Penduduk Baru</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stat-number">{{ $perubahanData ?? '0' }}</div>
                        <div class="stat-label">Perubahan Data</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="stat-number glow">Aktif</div>
                        <div class="stat-label">Status Sistem</div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="charts-grid">
                    <!-- Main Chart -->
                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-line"></i>
                            Grafik Pertumbuhan Penduduk
                        </h3>
                        <div class="chart-wrapper">
                            <canvas id="populationChart"></canvas>
                        </div>
                    </div>

                    <!-- Side Charts -->
                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-pie"></i>
                            Distribusi Gender
                        </h3>

                        <!-- Donut Chart -->
                        <div class="donut-chart">
                            <div class="donut-segment" style="background: conic-gradient(#667eea 0% {{ $persentaseLaki ?? 65 }}%, #764ba2 {{ $persentaseLaki ?? 65 }}% 100%);"></div>
                            <div class="donut-center">{{ $persentaseLaki ?? 65 }}%</div>
                        </div>

                        <!-- Progress Stats -->
                        <div class="progress-stats">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Laki-laki</span>
                                    <span>{{ $persentaseLaki ?? 65 }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $persentaseLaki ?? 65 }}%; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Perempuan</span>
                                    <span>{{ $persentasePerempuan ?? 35 }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $persentasePerempuan ?? 35 }}%; background: linear-gradient(90deg, #ef476f, #ff6b6b);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Charts Row -->
                <div class="charts-grid">
                    <!-- Activity Timeline -->
                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="fas fa-history"></i>
                            Aktivitas Terbaru
                        </h3>
                        <div class="timeline">
                            @if(isset($aktivitasTerbaru) && count($aktivitasTerbaru) > 0)
                                @foreach($aktivitasTerbaru as $aktivitas)
                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas {{ $aktivitas['icon'] }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">{{ $aktivitas['judul'] }}</div>
                                        <div class="timeline-time">{{ $aktivitas['waktu'] }}</div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Belum ada aktivitas</div>
                                        <div class="timeline-time">Mulai tambah data penduduk</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Age Distribution -->
                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="fas fa-child"></i>
                            Distribusi Usia
                        </h3>
                        <div class="chart-wrapper">
                            <canvas id="ageChart"></canvas>
                        </div>

                        <!-- Age Stats -->
                        <div class="progress-stats">
                            @if(isset($distribusiUsia) && count($distribusiUsia) > 0)
                                @foreach($distribusiUsia as $usia)
                                <div class="progress-item">
                                    <div class="progress-label">
                                        <span>{{ $usia['range'] }}</span>
                                        <span>{{ $usia['persentase'] }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $usia['persentase'] }}%; background: linear-gradient(90deg, {{ $usia['warna'] }});"></div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="progress-item">
                                    <div class="progress-label">
                                        <span>Data belum tersedia</span>
                                        <span>0%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="content-grid">
                    <div class="main-content">
                        <h2 class="section-title">Statistik Kependudukan</h2>
                        <p>Sistem kependudukan berjalan optimal dengan data real-time yang terintegrasi. Total penduduk terdaftar: <strong>{{ $totalPenduduk ?? 0 }} orang</strong>.</p>
                        <p>Monitoring menunjukkan distribusi penduduk berdasarkan wilayah dengan akurasi data mencapai 99.8%. Sistem telah memproses <strong>{{ $totalDokumen ?? 0 }} dokumen</strong> pencatatan sipil dengan efisiensi tinggi.</p>

                        <!-- Quick Actions -->

                            <a href="{{ route('penduduk.index') }}" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="action-text">Lihat Data</div>
                            </a>
                            <a href="{{ route('kelahiran.index') }}" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-baby"></i>
                                </div>
                                <div class="action-text">Data Kelahiran</div>
                            </a>
                            <a href="{{ route('kelahiran.create') }}" class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="action-text">Tambah Kelahiran</div>
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
                            <div class="info-value">ADM-{{ $userId ?? rand(1000, 9999) }}</div>
                        </div>
                        <div class="user-info">
                            <div class="info-label">Wilayah Kerja</div>
                            <div class="info-value">{{ $wilayahKerja ?? 'Kota Jakarta Pusat' }}</div>
                        </div>
                        <div class="user-info">
                            <div class="info-label">Status Sistem</div>
                            <div class="info-value" style="color: #4ecdc4;">● Online</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('theme-toggle');
        const currentTheme = localStorage.getItem('theme') || 'dark';

        // Set initial theme
        document.documentElement.setAttribute('data-theme', currentTheme);
        themeToggle.checked = currentTheme === 'light';

        // Theme toggle event
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Create particles
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 6 + 4) + 's';
                container.appendChild(particle);
            }
        }

        // Update waktu real-time
        function updateDateTime() {
            const now = new Date();
            const dateTimeElement = document.getElementById('currentDateTime');

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
            dateTimeElement.textContent = dateTimeString;
        }

        // Initialize charts
        function initializeCharts() {
            // Population Chart
            const populationCtx = document.getElementById('populationChart').getContext('2d');
            const populationChart = new Chart(populationCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: [100, 102, 105, 108, 110, 112, 115, 118, 120, 123, 125, 128],
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

            // Age Distribution Chart
            const ageCtx = document.getElementById('ageChart').getContext('2d');
            const ageChart = new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: ['0-17', '18-35', '36-55', '55+'],
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: [25, 45, 20, 10],
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.8)',
                            'rgba(118, 75, 162, 0.8)',
                            'rgba(78, 205, 196, 0.8)',
                            'rgba(239, 71, 111, 0.8)'
                        ],
                        borderColor: [
                            '#667eea',
                            '#764ba2',
                            '#4ecdc4',
                            '#ef476f'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Animate progress bars on scroll
        function animateProgressBars() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        }

        // Add interactive effects
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Initialize effects
        createParticles();
        initializeCharts();

        // Update waktu setiap detik
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call

        // Animate progress bars on load
        setTimeout(animateProgressBars, 1000);

        // Add random glow to stat cards
        setInterval(() => {
            const cards = document.querySelectorAll('.stat-card');
            const randomCard = cards[Math.floor(Math.random() * cards.length)];
            randomCard.classList.add('glow');
            setTimeout(() => randomCard.classList.remove('glow'), 2000);
        }, 3000);

        // Logout confirmation
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
            if (!confirm('Yakin ingin logout dari sistem?')) {
                e.preventDefault();
            }
        });

        // Sidebar active state management
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
