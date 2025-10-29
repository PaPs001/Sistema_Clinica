<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagina')</title>
    @yield('styles')
    @yield('scripts')
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
                <p>Módulo Enfermera</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboardEnfermera') }}" class="nav-item {{ request()->routeIs('dashboardEnfermera') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('pacientesEnfermera') }}" class="nav-item {{ request()->routeIs('pacientesEnfermera') ? 'active' : '' }}">
                    <i class="fas fa-user-injured"></i>
                    <span>Pacientes</span>
                </a>
                <a href="{{ route('signosVitales') }}" class="nav-item {{ request()->routeIs('signosVitales') ? 'active' : '' }}">
                    <i class="fas fa-heartbeat"></i>
                    <span>Signos Vitales</span>
                </a>
                <a href="{{ route('tratamientos') }}" class="nav-item {{ request()->routeIs('tratamientos') ? 'active' : '' }}">
                    <i class="fas fa-syringe"></i>
                    <span>Tratamientos</span>
                </a>
                <!--<a href="{{ route('medicamentos') }}" class="nav-item {{ request()->routeIs('medicamentos') ? 'active' : '' }}">
                    <i class="fas fa-pills"></i>
                    <span>Medicamentos</span>
                </a>-->
                <!--<a href="{{ route('citasEnfermera') }}" class="nav-item {{ request()->routeIs('citasEnfermera') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Citas del Día</span>
                </a>-->
                <!--<a href="{{ route('reportesEnfermera') }}" class="nav-item {{ request()->routeIs('reportesEnfermera') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>-->
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                    <div class="user-details">
                        <strong>Laura Martínez</strong>
                        <span>Enfermera</span>
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