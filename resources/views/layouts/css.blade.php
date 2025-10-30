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
        --gradient-success: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        --gradient-warning: linear-gradient(135deg, #ffd166 0%, #ff9e66 100%);
        --gradient-danger: linear-gradient(135deg, #ef476f 0%, #ff6b6b 100%);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .header-section {
        background: var(--gradient-primary);
        color: white;
        padding: 30px 0;
        margin-bottom: 30px;
        border-radius: 0 0 30px 30px;
        position: relative;
        overflow: hidden;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,0 1000,100 0,100"></polygon></svg>');
        background-size: cover;
    }

    .page-title {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }

    .btn-neo-primary {
        background: var(--gradient-primary);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .btn-neo-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-neo-primary:hover::before {
        left: 100%;
    }

    .btn-neo-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.6);
        color: white;
    }

    .btn-neo-warning {
        background: var(--gradient-warning);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 8px 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 209, 102, 0.4);
    }

    .btn-neo-danger {
        background: var(--gradient-danger);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 8px 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(239, 71, 111, 0.4);
    }

    .btn-neo-warning:hover,
    .btn-neo-danger:hover {
        transform: translateY(-2px);
        color: white;
    }

    .alert-neo-success {
        background: var(--gradient-success);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 25px rgba(78, 205, 196, 0.3);
        border-left: 5px solid rgba(255, 255, 255, 0.5);
    }

    .alert-neo-danger {
        background: var(--gradient-danger);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 25px rgba(239, 71, 111, 0.3);
        border-left: 5px solid rgba(255, 255, 255, 0.5);
    }

    .table-neo {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .table-neo thead {
        background: var(--gradient-primary);
        color: white;
    }

    .table-neo thead th {
        border: none;
        padding: 20px 15px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }

    .table-neo tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-neo tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateX(5px);
    }

    .table-neo tbody td {
        padding: 18px 15px;
        border: none;
        vertical-align: middle;
        font-weight: 500;
    }

    .badge-gender {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-male {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .badge-female {
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border-left: 5px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
    }

    .stats-label {
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .table-neo thead {
            display: none;
        }

        .table-neo tbody tr {
            display: block;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table-neo tbody td {
            display: block;
            text-align: right;
            padding: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-neo tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--primary-color);
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-alive {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
        }

        .badge-deceased {
            background: linear-gradient(135deg, #ef476f, #ff6b6b);
            color: white;
        }
        
        .empty-state i.fa-baby {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    }
</style>
