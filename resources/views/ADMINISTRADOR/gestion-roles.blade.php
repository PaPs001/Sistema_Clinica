@extends('plantillas.dashboard_administrador')
@section('title', 'Gestión de Roles - Clínica "Ultima Asignatura"')
@section('content')
            <header class="content-header">
                <h1><i class="fas fa-user-tag"></i> Gesti&oacute;n de Roles</h1>
                <!--<div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchRoles" placeholder="Buscar roles..." onkeyup="searchRoles()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                </div>-->
            </header>

            <div class="content">
                <!-- Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalRoles">{{ $totalMedics ?? 0 }}</h3>
                            <p>Medicos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="activeRoles">{{ $totalPatients ?? 0 }}</h3>
                            <p>Pacientes</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalPermissions">{{ $totalNurses ?? 0 }}</h3>
                            <p>Enfermeras</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalUsers">{{ $totalReceptionists ?? 0 }}</h3>
                            <p>Recepcionistas</p>
                        </div>
                    </div>
                </div>

                <!-- Panel de Control -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Lista de Roles del Sistema
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre del Rol</th>
                                    <th>Permisos</th>
                                    <th>Usuarios</th>
                                    <th>Cambiar permisos</th>
                                </tr>
                            </thead>
                            <tbody id="rolesTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <template id="role-Template">
                    <tr class="role-row" data-role-id="">
                        <td class="role-name">
                            <strong class="nombre-rol"></strong>
                        </td>

                        <td class="role-permissions">
                            <div class="permissions-list permisos-roles"></div>
                        </td>

                        <td class="role-users">
                            <span class="usuarios-roles"></span>
                        </td>

                        <td class="role-actions">
                            @if(auth()->user() && auth()->user()->hasPermission('asignar_permisos'))
                                <button class="btn-action btn-permissions btn-abrir-permisos" data-id="">
                                    <i class="fas fa-edit"></i><span>Editar permisos</span>
                                </button>
                            @endif
                            @if(auth()->user() && auth()->user()->hasPermission('ver_usuarios'))
                                <button class="btn-action btn-secondary btn-view-users" data-role-id="">
                                    <i class="fas fa-eye"></i><span>Ver usuarios</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                </template>
                <div class="pagination-container mt-3 text-center" id="paginationContainer-roles">
                        <!-- Los controles de paginación se cargarán aquí -->
                </div>
                
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Usuarios por rol
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre Usuario</th>
                                    <th>Rol</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="usuariosPorRolTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <template id="usuarioPorRol-Template">
                    <tr class="role-row" data-role-id="">
                        <td class="role-name">
                            <strong class="nombre-usuario"></strong>
                        </td>

                        <td class="role-permissions">
                            <span class="rol-usuario"></span>
                        </td>

                        <td class="role-users">
                            <span class="status-usuario"></span>
                        </td>
                    </tr>
                </template>
                <div class="pagination-container mt-3 text-center" id="paginationContainer-usuarios-por-rol">
                        <!-- Los controles de paginación se cargarán aquí -->
                </div>
                <template id="permiso-Template">
                    <div class="permission-item">
                        <input type="checkbox" class="perm-check">
                        <label class="perm-name"></label>
                    </div>
                </template>

            </div>
@endsection

@section('modals')
    <div id="modalPermisos">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-role-name">Editar Permisos</h3>
                <button class="close-modal" onclick="cerrarModalPermisos('#modalPermisos')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="permissions-grid" id="permissionsContainer"></div>
            </div>

            <div class="modal-footer">
                <button id="btnCerrar" class="btn-secondary" onclick="cerrarModalPermisos('#modalPermisos')">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button id="btnGuardarPermisos" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/css/ADMINISTRADOR/paginas/gestion-roles.css', 'resources/css/generales/modal-permisos.css', 'resources/js/ADMINISTRATOR/gestion-roles.js'])
@endsection
