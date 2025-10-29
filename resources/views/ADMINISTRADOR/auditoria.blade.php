<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría - Panel Admin</title>
    <link rel="stylesheet" href="auditoria.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="hospital-icon">
                    <i class="fas fa-clipboard-list"></i>
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
                <a href="control-accesos.html" class="nav-item">
                    <i class="fas fa-lock"></i>Control de Accesos
                </a>
                <a href="respaldo-datos.html" class="nav-item">
                    <i class="fas fa-database"></i>Respaldo de Datos
                </a>
                <a href="reportes.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>Reportes
                </a>
                <a href="auditoria.html" class="nav-item active">
                    <i class="fas fa-search"></i>Auditoría
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
                <h1><i class="fas fa-search"></i> Auditoría del Sistema</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchAudit" placeholder="Buscar en logs..." onkeyup="searchAudit()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">8</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalEvents">0</h3>
                            <p>Eventos Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="criticalEvents">0</h3>
                            <p>Eventos Críticos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="securityEvents">0</h3>
                            <p>Eventos Seguridad</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="logSize">0 MB</h3>
                            <p>Tamaño Logs</p>
                        </div>
                    </div>
                </div>

                <!-- Filtros de Auditoría -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-filter"></i> Filtros de Búsqueda</h3>
                        <div class="filter-options">
                            <div class="filter-group">
                                <label>Tipo de Evento:</label>
                                <select id="eventType" class="setting-select" onchange="applyFilters()">
                                    <option value="all">Todos los Eventos</option>
                                    <option value="security">Seguridad</option>
                                    <option value="system">Sistema</option>
                                    <option value="user">Usuario</option>
                                    <option value="database">Base de Datos</option>
                                    <option value="network">Red</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Nivel de Severidad:</label>
                                <select id="severityLevel" class="setting-select" onchange="applyFilters()">
                                    <option value="all">Todos los Niveles</option>
                                    <option value="critical">Crítico</option>
                                    <option value="high">Alto</option>
                                    <option value="medium">Medio</option>
                                    <option value="low">Bajo</option>
                                    <option value="info">Informativo</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Usuario:</label>
                                <select id="userFilter" class="setting-select" onchange="applyFilters()">
                                    <option value="all">Todos los Usuarios</option>
                                    <!-- Opciones se cargarán dinámicamente -->
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Fecha Desde:</label>
                                <input type="date" id="dateFrom" class="setting-select" onchange="applyFilters()">
                            </div>
                            <div class="filter-group">
                                <label>Fecha Hasta:</label>
                                <input type="date" id="dateTo" class="setting-select" onchange="applyFilters()">
                            </div>
                            <div class="filter-actions">
                                <button class="section-btn" onclick="clearFilters()">
                                    <i class="fas fa-eraser"></i> Limpiar Filtros
                                </button>
                                <button class="section-btn btn-success" onclick="exportAuditLogs()">
                                    <i class="fas fa-download"></i> Exportar Logs
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3><i class="fas fa-chart-bar"></i> Resumen de Actividad</h3>
                        <div class="activity-summary">
                            <div class="summary-item">
                                <span class="summary-label">Actividad de Usuarios:</span>
                                <div class="summary-bar">
                                    <div class="summary-fill" style="width: 75%"></div>
                                </div>
                                <span class="summary-value">75%</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Eventos de Seguridad:</span>
                                <div class="summary-bar">
                                    <div class="summary-fill security" style="width: 45%"></div>
                                </div>
                                <span class="summary-value">45%</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Errores del Sistema:</span>
                                <div class="summary-bar">
                                    <div class="summary-fill error" style="width: 15%"></div>
                                </div>
                                <span class="summary-value">15%</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Actividad de Base de Datos:</span>
                                <div class="summary-bar">
                                    <div class="summary-fill database" style="width: 60%"></div>
                                </div>
                                <span class="summary-value">60%</span>
                            </div>
                        </div>
                        <div class="real-time-indicator">
                            <i class="fas fa-circle" style="color: #28a745;"></i>
                            <span>Monitoreo en Tiempo Real: <strong id="realTimeStatus">Activo</strong></span>
                            <button class="section-btn btn-warning" onclick="toggleRealTime()">
                                <i class="fas fa-pause"></i> Pausar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Logs de Auditoría -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-history"></i> Logs de Auditoría
                        <div class="section-actions">
                            <button class="section-btn" onclick="refreshLogs()">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                            <button class="section-btn btn-danger" onclick="clearOldLogs()">
                                <i class="fas fa-trash"></i> Limpiar Antiguos
                            </button>
                            <button class="section-btn" onclick="showLogSettings()">
                                <i class="fas fa-cog"></i> Configuración
                            </button>
                        </div>
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha/Hora</th>
                                    <th>Usuario</th>
                                    <th>Tipo de Evento</th>
                                    <th>Descripción</th>
                                    <th>Severidad</th>
                                    <th>IP/Origen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="auditTableBody">
                                <!-- Los logs se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Alertas de Seguridad -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-bell"></i> Alertas de Seguridad Recientes
                        <div class="section-actions">
                            <button class="section-btn" onclick="markAllAsRead()">
                                <i class="fas fa-check-double"></i> Marcar Todo Leído
                            </button>
                        </div>
                    </h2>
                    
                    <div class="alerts-grid">
                        <!-- Las alertas se cargarán dinámicamente -->
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2><i class="fas fa-bolt"></i> Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="#" class="action-card" onclick="generateAuditReport()">
                            <i class="fas fa-file-pdf"></i>
                            <span>Reporte de Auditoría</span>
                        </a>
                        <a href="#" class="action-card" onclick="showComplianceReport()">
                            <i class="fas fa-shield-alt"></i>
                            <span>Cumplimiento Normativo</span>
                        </a>
                        <a href="#" class="action-card" onclick="manageAlertRules()">
                            <i class="fas fa-bell"></i>
                            <span>Reglas de Alerta</span>
                        </a>
                        <a href="#" class="action-card" onclick="showSystemHealth()">
                            <i class="fas fa-heartbeat"></i>
                            <span>Salud del Sistema</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para Detalles del Log -->
    <div class="modal-overlay" id="logDetailModal">
        <div class="modal modal-large">
            <div class="modal-header">
                <h3>Detalles del Evento de Auditoría</h3>
                <button class="close-modal" onclick="closeLogDetailModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="logDetails">
                    <!-- Los detalles se cargarán dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Configuración de Logs -->
    <div class="modal-overlay" id="logSettingsModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Configuración de Auditoría</h3>
                <button class="close-modal" onclick="closeLogSettingsModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="logSettingsForm">
                    <div class="setting-group">
                        <h4>Niveles de Log</h4>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" id="logInfo" checked>
                                <span>Informativo</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="logWarning" checked>
                                <span>Advertencias</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="logError" checked>
                                <span>Errores</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="logCritical" checked>
                                <span>Críticos</span>
                            </label>
                        </div>
                    </div>

                    <div class="setting-group">
                        <h4>Retención de Logs</h4>
                        <div class="form-group">
                            <label>Días de retención:</label>
                            <select id="retentionDays" class="setting-select">
                                <option value="30">30 días</option>
                                <option value="60">60 días</option>
                                <option value="90" selected>90 días</option>
                                <option value="180">180 días</option>
                                <option value="365">1 año</option>
                            </select>
                        </div>
                    </div>

                    <div class="setting-group">
                        <h4>Alertas Automáticas</h4>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" id="alertCritical" checked>
                                <span>Alertar eventos críticos</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="alertSecurity" checked>
                                <span>Alertar eventos de seguridad</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="alertFailedLogin" checked>
                                <span>Alertar intentos fallidos</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="section-btn" style="background: #95a5a6;" onclick="closeLogSettingsModal()">Cancelar</button>
                        <button type="submit" class="section-btn">Guardar Configuración</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="auditoria.js"></script>
</body>
</html>