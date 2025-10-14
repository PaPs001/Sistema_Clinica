<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeuroLab - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">NEUROLAB</h1>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <span class="nav-icon">👤</span>
                    <span class="nav-text">Pacientes</span>
                </a>
                <a href="{{ route('scans.index') }}" class="nav-item {{ request()->routeIs('scans.*') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span>
                    <span class="nav-text">Escaneos</span>
                </a>
                <a href="{{ route('calendar') }}" class="nav-item {{ request()->routeIs('calendar') ? 'active' : '' }}">
                    <span class="nav-icon">📅</span>
                    <span class="nav-text">Calendario</span>
                </a>
                <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <span class="nav-icon">📄</span>
                    <span class="nav-text">Reportes</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <div class="header-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <h2 class="page-title">@yield('page-title')</h2>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span class="user-name">Dr. Simon Feeligs</span>
                        <div class="user-avatar">
                            <span>SF</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    @vite('resources/js/app.js')
</body>
</html>