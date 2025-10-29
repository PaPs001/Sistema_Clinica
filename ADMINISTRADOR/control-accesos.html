<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Accesos - Panel Admin</title>
    <link rel="stylesheet" href="control-accesos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="hospital-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Panel Admin</h2>
                <p>Gestión del Sistema</p>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.html" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
                <a href="gestion-usuarios.html" class="nav-item">
                    <i class="fas fa-users"></i>Gestión de Usuarios
                </a>
                <a href="gestion-roles.html" class="nav-item">
                    <i class="fas fa-user-tag"></i>Gestión de Roles
                </a>
                <a href="control-accesos.html" class="nav-item active">
                    <i class="fas fa-lock"></i>Control de Accesos
                </a>
                <a href="respaldo-datos.html" class="nav-item">
                    <i class="fas fa-database"></i>Respaldo de Datos
                </a>
                <a href="reportes.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>Reportes
                </a>
                <a href="auditoria.html" class="nav-item">
                    <i class="fas fa-clipboard-list"></i>Auditoría
                </a>
                <a href="configuracion.html" class="nav-item">
                    <i class="fas fa-cogs"></i>Configuración
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="user-details">
                        <strong>Administrador</strong>
                        <span>Super Usuario</span>
                    </div>
                </div>
                <a href="#" class="logout-btn" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1><i class="fas fa-lock"></i> Control de Accesos</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchAccess" placeholder="Buscar accesos..." onkeyup="searchAccess()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalSessions">0</h3>
                            <p>Sesiones Activas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="blockedUsers">0</h3>
                            <p>Usuarios Bloqueados</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="failedAttempts">0</h3>
                            <p>Intentos Fallidos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="securityLevel">Alto</h3>
                            <p>Nivel de Seguridad</p>
                        </div>
                    </div>
                </div>

                <!-- Panel de Sesiones Activas -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-play-circle"></i> Sesiones Activas
                        <div class="section-actions">
                            <button class="section-btn" onclick="refreshSessions()">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                            <button class="section-btn btn-danger" onclick="terminateAllSessions()">
                                <i class="fas fa-power-off"></i> Terminar Todas
                            </button>
                        </div>
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>IP</th>
                                    <th>Inicio de Sesión</th>
                                    <th>Última Actividad</th>
                                    <th>Tiempo Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="sessionsTableBody">
                                <!-- Las sesiones se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Configuración de Seguridad -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-user-lock"></i> Políticas de Contraseñas</h3>
                        <div class="settings-list">
                            <div class="setting-item">
                                <label class="switch">
                                    <input type="checkbox" id="passwordExpiration" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Expiración cada 90 días</span>
                            </div>
                            <div class="setting-item">
                                <label class="switch">
                                    <input type="checkbox" id="passwordComplexity" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Requerir complejidad</span>
                            </div>
                            <div class="setting-item">
                                <label class="switch">
                                    <input type="checkbox" id="passwordHistory" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Historial de contraseñas</span>
                            </div>
                            <div class="setting-item">
                                <label>Longitud mínima:</label>
                                <select id="minPasswordLength" class="setting-select">
                                    <option value="8">8 caracteres</option>
                                    <option value="10" selected>10 caracteres</option>
                                    <option value="12">12 caracteres</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3><i class="fas fa-shield-alt"></i> Configuración de Bloqueo</h3>
                        <div class="settings-list">
                            <div class="setting-item">
                                <label class="switch">
                                    <input type="checkbox" id="accountLockout" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Bloqueo por intentos fallidos</span>
                            </div>
                            <div class="setting-item">
                                <label>Intentos máximos:</label>
                                <select id="maxAttempts" class="setting-select">
                                    <option value="3">3 intentos</option>
                                    <option value="5" selected>5 intentos</option>
                                    <option value="10">10 intentos</option>
                                </select>
                            </div>
                            <div class="setting-item">
                                <label>Tiempo de bloqueo:</label>
                                <select id="lockoutDuration" class="setting-select">
                                    <option value="5">5 minutos</option>
                                    <option value="15" selected>15 minutos</option>
                                    <option value="30">30 minutos</option>
                                    <option value="60">1 hora</option>
                                </select>
                            </div>
                            <div class="setting-item">
                                <button class="section-btn" onclick="saveSecuritySettings()">
                                    <i class="fas fa-save"></i> Guardar Configuración
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registro de Intentos Fallidos -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-exclamation-circle"></i> Intentos Fallidos Recientes
                        <div class="section-actions">
                            <button class="section-btn" onclick="clearFailedAttempts()">
                                <i class="fas fa-trash"></i> Limpiar Registros
                            </button>
                        </div>
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Fecha/Hora</th>
                                    <th>IP</th>
                                    <th>Motivo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="failedAttemptsTableBody">
                                <!-- Los intentos fallidos se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2><i class="fas fa-bolt"></i> Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="#" class="action-card" onclick="showAccessLogs()">
                            <i class="fas fa-list-alt"></i>
                            <span>Ver Logs de Acceso</span>
                        </a>
                        <a href="#" class="action-card" onclick="manageIPWhitelist()">
                            <i class="fas fa-network-wired"></i>
                            <span>IPs Permitidas</span>
                        </a>
                        <a href="#" class="action-card" onclick="generateSecurityReport()">
                            <i class="fas fa-file-shield"></i>
                            <span>Reporte de Seguridad</span>
                        </a>
                        <a href="#" class="action-card" onclick="showSecurityAlerts()">
                            <i class="fas fa-bell"></i>
                            <span>Alertas de Seguridad</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para Detalles de Sesión -->
    <div class="modal-overlay" id="sessionModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Detalles de Sesión</h3>
                <button class="close-modal" onclick="closeSessionModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="sessionDetails">
                    <!-- Los detalles se cargarán dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <script src="control-accesos.js"></script>
</body>
</html>