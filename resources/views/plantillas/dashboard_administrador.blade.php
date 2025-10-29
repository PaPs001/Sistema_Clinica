<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagina')</title>
    @vite('resources/css/ADMINISTRADOR/general.css')
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
                <p>Módulo Administrador</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboardAdmin') }}" class="nav-item {{ request()->routeIs('dashboardAdmin') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('gestionRoles') }}" class="nav-item {{ request()->routeIs('gestionRoles') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Gestión de Roles</span>
                </a>
                <a href="{{ route('controlAccesos') }}" class="nav-item {{ request()->routeIs('controlAccesos') ? 'active' : '' }}">
                    <i class="fas fa-lock"></i>
                    <span>Control de Accesos</span>
                </a>
                <a href="{{ route('respaldoDatos') }}" class="nav-item {{ request()->routeIs('respaldoDatos') ? 'active' : '' }}">
                    <i class="fas fa-database"></i>
                    <span>Respaldo de Datos</span>
                </a>
               <!-- <a href="reportes-admin.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>-->
                <!--<a href="{{ route('auditoria') }}" class="nav-item {{ request()->routeIs('auditoria') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Auditoría</span>
                </a>-->
                <!--<a href="{{ route('configuracion') }}" class="nav-item {{ request()->routeIs('configuracion') ? 'active' : '' }}">
                    <i class="fas fa-cogs"></i>
                    <span>Configuración</span>
                </a>-->
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="user-details">
                        <strong>Carlos Mendoza</strong>
                        <span>Administrador</span>
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
</body>