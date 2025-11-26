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
                            <span class="permisos-roles"></span>
                        </td>

                        <td class="role-users">
                            <span class="usuarios-roles"></span>
                        </td>

                        <td class="role-actions">
                            <button class="btn-abrir-permisos" data-id="">
                                <i class="fas fa-edit"></i>Editar permisos
                            </button>
                            <button class="btn-view-users" data-role-id="">
                                <i class="fas fa-eye"></i> Ver usuarios
                            </button>
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
                                    <th>Acciones</th>
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

                        <td class="role-actions">
                            <button class="btn-edit" data-id="">
                                <i class="fas fa-edit"></i>
                            </button>
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

                <div id="modalPermisos" class="modal">
                    <div class="modal-content">
                        <h2 id="modal-role-name"></h2>
                            
                        <div id="permissionsContainer"></div>

                        <button id="btnGuardarPermisos">Guardar</button>
                        <button id="btnCerrar" onclick="cerrarModalPermisos('#modalPermisos')">Cerrar</button>
                    </div>
                </div>



                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2><i class="fas fa-bolt"></i> Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="#" class="action-card" onclick="openCreateRoleModal()">
                            <i class="fas fa-plus-circle"></i>
                            <span>Crear Nuevo Rol</span>
                        </a>
                        <!--<a href="#" class="action-card" onclick="showPermissionsMatrix()">
                            <i class="fas fa-table"></i>
                            <span>Matriz de Permisos</span>
                        </a>-->
                        <a href="#" class="action-card" onclick="exportRoleReport()">
                            <i class="fas fa-file-export"></i>
                            <span>Exportar Reporte</span>
                        </a>
                        <!--<a href="#" class="action-card" onclick="showRoleAudit()">
                            <i class="fas fa-history"></i>
                            <span>Auditoría de Roles</span>
                        </a>-->
                    </div>
                </div>
            </div>
@endsection
@section('scripts')
@vite('resources/js/ADMINISTRATOR/gestion-roles.js')
@endsection
