<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pagina')</title>
    @vite(['resources/css/medic/paginas/modulo_plantilla.css', 'resources/css/ADMINISTRADOR/general.css'])
    @yield('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <aside class="sidebar">
        <div class="clinic-info">
            <h3>Clinica Ultima Asignatura</h3>
            <p>Sistema Médico</p>
        </div>
        
        <ul class="sidebar-menu">
            @php($adminUser = auth()->user())
            
            @if($adminUser && $adminUser->hasPermission('administrar_roles'))
                <li>
                    <a href="{{ route('gestionRoles') }}" class="{{ request()->routeIs('gestionRoles') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Gestión de Roles</span>
                    </a>
                </li>
            @endif

            @if($adminUser && $adminUser->hasPermission('crear_reportes'))
                <li>
                    <a href="{{ route('respaldoDatos') }}" class="{{ request()->routeIs('respaldoDatos') ? 'active' : '' }}">
                        <i class="fas fa-database"></i>
                        <span>Respaldo de Datos</span>
                    </a>
                </li>
            @endif

            @if($adminUser && $adminUser->hasPermission('ver_reportes'))
                <li>
                    <a href="{{ route('reportes.pacientesAtendidos') }}" class="{{ request()->routeIs('reportes.pacientesAtendidos') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reportes</span>
                    </a>
                </li>
            @endif
            
            <!--<li>
                <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Notificaciones</span>
                    <span class="badge notification-badge" style="display: none; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; margin-left: 5px;">0</span>
                </a>
            </li>-->
        </ul>
        
        <div class="user-section">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <strong>{{ Auth::user()->name }}</strong>
                    <div>Administrador</div>
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

    @yield('scripts')
    @yield('modals')
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
