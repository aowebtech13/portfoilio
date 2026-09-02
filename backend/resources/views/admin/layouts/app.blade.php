<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #1a1a1a;
            border-right: 1px solid rgba(255,255,255,0.1);
            z-index: 1000;
            padding: 30px 0;
        }
        .admin-sidebar .logo {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }
        .admin-sidebar .logo img {
            max-width: 150px;
        }
        .admin-sidebar nav a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .admin-sidebar nav a:hover,
        .admin-sidebar nav a.active {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left-color: #ff8743;
        }
        .admin-sidebar nav a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-header h1 {
            font-size: 28px;
            font-weight: 500;
        }
        .admin-card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            margin-bottom: 25px;
        }
        .stats-row .stat-card {
            flex: 1 1 0;
            min-width: 220px;
            margin-bottom: 0;
        }
        .admin-card h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: #ff8743;
            color: #fff;
        }
        .btn-primary:hover {
            background: #e6763a;
        }
        .btn-danger {
            background: #dc3545;
            color: #fff;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.2);
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        table th {
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        table td {
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .badge-success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }
        .badge-warning {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            background: #222;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 5px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff8743;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .media-item {
            background: #222;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .media-item .row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .media-item .row > div {
            flex: 1;
            min-width: 200px;
        }
        .alert {
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }
    </style>
</head>
<body>
    <aside class="admin-sidebar">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('https://res.cloudinary.com/djme9spdc/image/upload/v1788377581/logo_k9vp0v.png') }}" alt="Logo">
            </a>
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i> Projects
            </a>
            <a href="{{ route('admin.projects.create') }}" class="{{ request()->routeIs('admin.projects.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i> New Project
            </a>
        </nav>
    </aside>

    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    @yield('scripts')
</body>
</html>
