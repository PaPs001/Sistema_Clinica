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
                            <h3 id="totalRoles">0</h3>
                            <p>Total de Roles</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="activeRoles">0</h3>
                            <p>Roles Activos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalPermissions">0</h3>
                            <p>Permisos Totales</p>
                        </div>
                    </div>
                    <!--<div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalUsers">0</h3>
                            <p>Usuarios con Roles</p>
                        </div>
                    </div>-->
                </div>

                <!-- Panel de Control -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Lista de Roles del Sistema
                        <div class="section-actions">
                            <button class="section-btn" onclick="openCreateRoleModal()">
                                <i class="fas fa-plus"></i> Nuevo Rol
                            </button>
                            <button class="section-btn" onclick="exportRoles()">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                        </div>
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre del Rol</th>
                                    <th>Descripción</th>
                                    <th>Permisos</th>
                                    <th>Usuarios</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <!--<tbody id="rolesTableBody">
                                 Los roles se cargarán dinámicamente
                            </tbody>
-->
                        </table>
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
    <!-- Modal para Crear/Editar Rol -->
    <div class="modal-overlay" id="roleModal">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalTitle">Crear Nuevo Rol</h3>
                <button class="close-modal" onclick="closeRoleModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <div style="margin-bottom: 20px;">
                        <label for="roleName" style="display: block; margin-bottom: 5px; font-weight: 500;">Nombre del Rol:</label>
                        <input type="text" id="roleName" required style="width: 100%; padding: 10px; border: 1px solid #e1e5e9; border-radius: 5px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="roleDescription" style="display: block; margin-bottom: 5px; font-weight: 500;">Descripción:</label>
                        <textarea id="roleDescription" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e1e5e9; border-radius: 5px;"></textarea>
                    </div>
                    
                    <!-- Permisos -->
                    <div style="margin-bottom: 20px;">
                        <h4 style="color: #061175; margin-bottom: 15px; border-bottom: 2px solid #667eea; padding-bottom: 5px;">
                            <i class="fas fa-key"></i> Permisos del Sistema
                        </h4>
                        <div class="permissions-grid" id="permissionsGrid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; max-height: 200px; overflow-y: auto; padding: 10px; border: 1px solid #e1e5e9; border-radius: 5px;">
                            <!-- Los permisos se cargarán dinámicamente -->
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e1e5e9;">
                        <button type="button" class="section-btn" style="background: #95a5a6;" onclick="closeRoleModal()">Cancelar</button>
                        <button type="submit" class="section-btn">Guardar Rol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@vite('resources/js/ADMINISTRATOR/gestion-roles.js')
@endsection
