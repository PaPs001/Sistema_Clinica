<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagina')</title>
    @vite(['resources/css/RECEPCIONISTA/general.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="hospital-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h2>Clinica Ultima Asignatura</h2>
                <p>Módulo Recepcionista</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboardRecepcionista') }}" class="nav-item {{ request()->routeIs('dashboardRecepcionista') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('registroPaciente') }}" class="nav-item {{ request()->routeIs('registroPaciente') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Registrar Pacientes</span>
                </a>
                <a href="{{ route('gestionCitas') }}" class="nav-item {{ request()->routeIs('gestionCitas') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Gestión de Citas</span>
                </a>
                <!--<a href="{{ route('agenda') }}" class="nav-item {{ request()->routeIs('agenda') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Agenda</span>
                </a>-->
                <a href="{{ route('pacientesRecepcionista') }}" class="nav-item {{ request()->routeIs('pacientesRecepcionista') ? 'active' : '' }}">
                    <i class="fas fa-user-injured"></i>
                    <span>Pacientes</span>
                </a>
                <a href="{{ route('recordatorios') }}" class="nav-item {{ request()->routeIs('recordatorios') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>Recordatorios</span>
                </a>
                <!--<a href="reportes-recepcion.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>-->
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="user-details">
                        <strong>Ana Rodríguez</strong>
                        <span>Recepcionista</span>
                    </div>
                </div>
                <form id="logout-form" method="post" style="display: none;"action="{{ route('logout') }}">
                    @csrf
                </form>
                <a href="#" class="logout-btn" onClick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
