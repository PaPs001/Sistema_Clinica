<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagina')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/medic/paginas/modulo_plantilla.css', 'resources/css/PACIENTE/general.css'])
    @yield('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Sidebar CON ESTILOS MODERNOS -->
    <aside class="sidebar">
        <div class="clinic-info">
            <h3>Clinica Ultima Asignatura</h3>
            <p>Sistema Médico</p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard.paciente') }}" class="{{ request()->routeIs('dashboard.paciente') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('historialPaciente') }}" class="{{ request()->routeIs('historialPaciente') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Mi Historial</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perfilPaciente') }}" class="{{ request()->routeIs('perfilPaciente') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Mi Perfil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Notificaciones</span>
                    <span class="badge notification-badge" style="display: none; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; margin-left: 5px;">0</span>
                </a>
            </li>
        </ul>
        
        <div class="user-section">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <strong>{{ Auth::user()->name }}</strong>
                    <div>Paciente</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: inherit;">
                <div class="weather-info">
                    <span>Cerrar Sesión</span>
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
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
</html>
