<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagina')</title>
    @vite(['resources/css/PACIENTE/general.css'])
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
                <p>Módulo Paciente</p>
                <p>Bienvenida {{ Auth::user()->name }} </p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard.paciente') }}" class="nav-item {{ request()->routeIs('dashboard.paciente') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('historialPaciente') }}" class="nav-item {{ request()->routeIs('historialPaciente') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Mi Historial</span>
                </a>
                <!--<a href="{{ route('citasPaciente') }}" class="nav-item {{ request()->routeIs('citasPaciente') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Mis Citas</span>
                </a>
                <a href="{{ route('documentosPaciente') }}" class="nav-item {{ request()->routeIs('documentosPaciente') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Mis Documentos</span>
                </a>
                <a href="{{ route('alergiasPaciente') }}" class="nav-item {{ request()->routeIs('alergiasPaciente') ? 'active' : '' }}">
                    <i class="fas fa-allergies"></i>
                    <span>Mis Alergias</span>
                </a>-->
                <a href="{{ route('perfilPaciente') }}" class="nav-item {{ request()->routeIs('perfilPaciente') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Mi Perfil</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Notificaciones</span>
                    <span class="badge notification-badge" style="display: none; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; margin-left: 5px;">0</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>Paciente</span>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateNotificationCount();
            setInterval(updateNotificationCount, 30000);
        });

        function updateNotificationCount() {
            fetch('{{ route("notifications.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badges = document.querySelectorAll('.notification-badge');
                    badges.forEach(badge => {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    });
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }
    </script>
</body>
