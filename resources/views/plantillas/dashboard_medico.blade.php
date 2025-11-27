<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagina')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/MEDICO/modulo_plantilla.css')
    @yield('styles')
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
                <p>Módulo Médico</p>
                <p>Bienvenido {{ Auth::user()->name }}</p>
            </div>
            
            <nav class="sidebar-nav">
                <!--<a href="{{ route('dashboardMedico') }}" class="nav-item {{ request()->routeIs('dashboardMedico') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>-->
                <a href="{{ route('registro-expediente') }}" class="nav-item {{ request()->routeIs('registro-expediente') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Nuevo Expediente</span>
                </a>
                <a href="{{ route('consulta-historial') }}" class="nav-item {{ request()->routeIs('consulta-historial') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Historial Médico</span>
                </a>
                <a href="{{ route('iniciar-Upload-files') }}" class="nav-item {{ request()->routeIs('iniciar-Upload-files') ? 'active' : '' }}">
                    <i class="fas fa-file-upload"></i>
                    <span>Subir Documentos</span>
                </a>
                <a href="{{ route('filtrar-expedientes') }}" class="nav-item {{ request()->routeIs('filtrar-expedientes') ? 'active' : '' }}">
                    <i class="fas fa-filter"></i>
                    <span>Filtrar Expedientes</span>
                </a>
                <a href="{{ route('registro-alergias') }}" class="nav-item {{ request()->routeIs('registro-alergias') ? 'active' : '' }}">
                    <i class="fas fa-allergies"></i>
                    <span>Antecedents Medicos</span>
                </a>
            </nav>
            
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="user-details">
                        <strong>Dr. Juan Pérez</strong>
                        <span>Cardiólogo</span>
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
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
