<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - Panel Admin</title>
    <link rel="stylesheet" href="configuracion.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="hospital-icon">
                    <i class="fas fa-cogs"></i>
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
                <a href="auditoria.html" class="nav-item">
                    <i class="fas fa-search"></i>Auditoría
                </a>
                <a href="configuracion.html" class="nav-item active">
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
                <h1><i class="fas fa-cogs"></i> Configuración del Sistema</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchConfig" placeholder="Buscar configuración..." onkeyup="searchConfig()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas del Sistema -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="uptime">99.8%</h3>
                            <p>Disponibilidad</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="databaseSize">2.4 GB</h3>
                            <p>Tamaño Base de Datos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="activeUsers">156</h3>
                            <p>Usuarios Activos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="securityScore">92%</h3>
                            <p>Puntuación Seguridad</p>
                        </div>
                    </div>
                </div>

                <!-- Navegación de Configuración -->
                <div class="config-navigation">
                    <div class="nav-tabs">
                        <button class="nav-tab active" data-tab="general">
                            <i class="fas fa-sliders-h"></i> General
                        </button>
                        <button class="nav-tab" data-tab="seguridad">
                            <i class="fas fa-shield-alt"></i> Seguridad
                        </button>
                        <button class="nav-tab" data-tab="notificaciones">
                            <i class="fas fa-bell"></i> Notificaciones
                        </button>
                        <button class="nav-tab" data-tab="integraciones">
                            <i class="fas fa-plug"></i> Integraciones
                        </button>
                        <button class="nav-tab" data-tab="avanzado">
                            <i class="fas fa-cog"></i> Avanzado
                        </button>
                    </div>
                </div>

                <!-- Contenido de Configuración General -->
                <div class="config-content active" id="general-tab">
                    <div class="health-info">
                        <div class="info-card">
                            <h3><i class="fas fa-info-circle"></i> Información del Sistema</h3>
                            <div class="system-info">
                                <div class="info-item">
                                    <span class="info-label">Nombre del Sistema:</span>
                                    <span class="info-value">Hospital Management Pro</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Versión:</span>
                                    <span class="info-value">v2.4.1</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Última Actualización:</span>
                                    <span class="info-value">15 Ene 2024</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Licencia:</span>
                                    <span class="info-value status-badge success">Activa</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Base de Datos:</span>
                                    <span class="info-value">MySQL 8.0</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-card">
                            <h3><i class="fas fa-palette"></i> Personalización</h3>
                            <div class="personalization-options">
                                <div class="option-group">
                                    <label>Tema de Interfaz:</label>
                                    <select id="themeSelect" class="setting-select">
                                        <option value="light">Claro</option>
                                        <option value="dark">Oscuro</option>
                                        <option value="auto">Automático</option>
                                    </select>
                                </div>
                                <div class="option-group">
                                    <label>Idioma:</label>
                                    <select id="languageSelect" class="setting-select">
                                        <option value="es">Español</option>
                                        <option value="en">English</option>
                                        <option value="pt">Português</option>
                                    </select>
                                </div>
                                <div class="option-group">
                                    <label>Zona Horaria:</label>
                                    <select id="timezoneSelect" class="setting-select">
                                        <option value="America/Mexico_City">CDMX (UTC-6)</option>
                                        <option value="America/Bogota">Bogotá (UTC-5)</option>
                                        <option value="America/Lima">Lima (UTC-5)</option>
                                    </select>
                                </div>
                                <div class="option-group">
                                    <label>Formato de Fecha:</label>
                                    <select id="dateFormat" class="setting-select">
                                        <option value="dd/mm/yyyy">DD/MM/AAAA</option>
                                        <option value="mm/dd/yyyy">MM/DD/AAAA</option>
                                        <option value="yyyy-mm-dd">AAAA-MM-DD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="recent-section">
                        <h2>
                            <i class="fas fa-wrench"></i> Configuración de Módulos
                        </h2>
                        <div class="modules-grid">
                            @hasPermission('ver_usuarios')
                            <div class="module-card">
                                <div class="module-header">
                                    <i class="fas fa-users"></i>
                                    <h4>Gestión de Usuarios</h4>
                                </div>
                                <div class="module-status">
                                    <span class="status-badge success">Activo</span>
                                </div>
                                <div class="module-settings">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span>Registro automático</span>
                                </div>
                                <button class="section-btn" onclick="configureModule('users')">
                                    <i class="fas fa-cog"></i> Configurar
                                </button>
                            </div>
                            @endhasPermission

                            <div class="module-card">
                                <div class="module-header">
                                    <i class="fas fa-file-invoice"></i>
                                    <h4>Facturación</h4>
                                </div>
                                <div class="module-status">
                                    <span class="status-badge success">Activo</span>
                                </div>
                                <div class="module-settings">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span>IVA automático</span>
                                </div>
                                <button class="section-btn" onclick="configureModule('billing')">
                                    <i class="fas fa-cog"></i> Configurar
                                </button>
                            </div>

                            <div class="module-card">
                                <div class="module-header">
                                    <i class="fas fa-pills"></i>
                                    <h4>Inventario</h4>
                                </div>
                                <div class="module-status">
                                    <span class="status-badge warning">En Mantenimiento</span>
                                </div>
                                <div class="module-settings">
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                    <span>Alertas de stock</span>
                                </div>
                                <button class="section-btn" onclick="configureModule('inventory')">
                                    <i class="fas fa-cog"></i> Configurar
                                </button>
                            </div>

                            @hasPermission('ver_reportes')
                            <div class="module-card">
                                <div class="module-header">
                                    <i class="fas fa-chart-line"></i>
                                    <h4>Reportes</h4>
                                </div>
                                <div class="module-status">
                                    <span class="status-badge success">Activo</span>
                                </div>
                                <div class="module-settings">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span>Generación automática</span>
                                </div>
                                <button class="section-btn" onclick="configureModule('reports')">
                                    <i class="fas fa-cog"></i> Configurar
                                </button>
                            </div>
                            @endhasPermission
                        </div>
                    </div>
                </div>

                <!-- Contenido de Configuración de Seguridad -->
                <div class="config-content" id="seguridad-tab">
                    <div class="health-info">
                        <div class="info-card">
                            <h3><i class="fas fa-user-lock"></i> Autenticación</h3>
                            <div class="security-options">
                                <div class="option-group">
                                    <label class="switch">
                                        <input type="checkbox" id="twoFactorAuth" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span>Autenticación de dos factores</span>
                                </div>
                                <div class="option-group">
                                    <label class="switch">
                                        <input type="checkbox" id="sessionTimeout" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span>Timeout de sesión automático</span>
                                </div>
                                <div class="option-group">
                                    <label>Timeout de sesión (minutos):</label>
                                    <select id="sessionTimeoutValue" class="setting-select">
                                        <option value="15">15 minutos</option>
                                        <option value="30" selected>30 minutos</option>
                                        <option value="60">60 minutos</option>
                                        <option value="120">2 horas</option>
                                    </select>
                                </div>
                                <div class="option-group">
                                    <label>Máximo de sesiones por usuario:</label>
                                    <select id="maxSessions" class="setting-select">
                                        <option value="1">1 sesión</option>
                                        <option value="3" selected>3 sesiones</option>
                                        <option value="5">5 sesiones</option>
                                        <option value="10">10 sesiones</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="info-card">
                            <h3><i class="fas fa-ban"></i> Políticas de Acceso</h3>
                            <div class="access-policies">
                                <div class="option-group">
                                    <label>Política de contraseñas:</label>
                                    <select id="passwordPolicy" class="setting-select">
                                        <option value="basic">Básica</option>
                                        <option value="standard" selected>Estándar</option>
                                        <option value="strict">Estricta</option>
                                        <option value="custom">Personalizada</option>
                                    </select>
                                </div>
                                <div class="option-group">
                                    <label>Longitud mínima:</label>
                                    <input type="number" id="minPasswordLength" class="setting-input" value="8" min="6" max="20">
                                </div>
                                <div class="option-group">
                                    <label>Días para expiración:</label>
                                    <input type="number" id="passwordExpiry" class="setting-input" value="90" min="30" max="365">
                                </div>
                                <div class="option-group">
                                    <label class="switch">
                                        <input type="checkbox" id="passwordHistory" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span>Prevenir reutilización de contraseñas</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="recent-section">
                        <h2>
                            <i class="fas fa-network-wired"></i> Configuración de Red
                        </h2>
                        <div class="network-settings">
                            <div class="setting-group">
                                <label>IPs Permitidas:</label>
                                <div class="ip-list">
                                    <div class="ip-item">
                                        <span>192.168.1.0/24</span>
                                        <button class="btn-action btn-delete" onclick="removeIP('192.168.1.0/24')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="ip-item">
                                        <span>10.0.0.0/16</span>
                                        <button class="btn-action btn-delete" onclick="removeIP('10.0.0.0/16')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="ip-add">
                                    <input type="text" id="newIP" placeholder="Ej: 192.168.1.100" class="setting-input">
                                    <button class="section-btn" onclick="addIP()">
                                        <i class="fas fa-plus"></i> Agregar IP
                                    </button>
                                </div>
                            </div>
                            <div class="setting-group">
                                <label class="switch">
                                    <input type="checkbox" id="firewallEnabled" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Firewall habilitado</span>
                            </div>
                            <div class="setting-group">
                                <label class="switch">
                                    <input type="checkbox" id="sslEnabled" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>SSL/TLS obligatorio</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido de Configuración de Notificaciones -->
                <div class="config-content" id="notificaciones-tab">
                    <div class="health-info">
                        <div class="info-card">
                            <h3><i class="fas fa-envelope"></i> Configuración de Email</h3>
                            <div class="email-settings">
                                <div class="option-group">
                                    <label>Servidor SMTP:</label>
                                    <input type="text" id="smtpServer" class="setting-input" value="smtp.hospital.com">
                                </div>
                                <div class="option-group">
                                    <label>Puerto:</label>
                                    <input type="number" id="smtpPort" class="setting-input" value="587">
                                </div>
                                <div class="option-group">
                                    <label>Seguridad:</label>
                                    <select id="smtpSecurity" class="setting-select">
                                        <option value="none">Ninguna</option>
                                        <option value="tls" selected>TLS</option>
                                        <option value="ssl">SSL</option>
                                    </select>
                                </div>
                                <div class="option-group">
                                    <label>Email del sistema:</label>
                                    <input type="email" id="systemEmail" class="setting-input" value="sistema@hospital.com">
                                </div>
                                <button class="section-btn" onclick="testEmailConfig()">
                                    <i class="fas fa-paper-plane"></i> Probar Configuración
                                </button>
                            </div>
                        </div>

                        <div class="info-card">
                            <h3><i class="fas fa-bell"></i> Preferencias de Notificaciones</h3>
                            <div class="notification-preferences">
                                <div class="preference-group">
                                    <h4>Notificaciones por Email</h4>
                                    <div class="checkbox-list">
                                        <label class="checkbox-item">
                                            <input type="checkbox" checked>
                                            <span>Alertas de seguridad</span>
                                        </label>
                                        <label class="checkbox-item">
                                            <input type="checkbox" checked>
                                            <span>Reportes diarios</span>
                                        </label>
                                        <label class="checkbox-item">
                                            <input type="checkbox">
                                            <span>Notificaciones de respaldo</span>
                                        </label>
                                        <label class="checkbox-item">
                                            <input type="checkbox" checked>
                                            <span>Alertas de errores</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="preference-group">
                                    <h4>Notificaciones en Sistema</h4>
                                    <div class="checkbox-list">
                                        <label class="checkbox-item">
                                            <input type="checkbox" checked>
                                            <span>Nuevos usuarios</span>
                                        </label>
                                        <label class="checkbox-item">
                                            <input type="checkbox" checked>
                                            <span>Actividad sospechosa</span>
                                        </label>
                                        <label class="checkbox-item">
                                            <input type="checkbox">
                                            <span>Actualizaciones del sistema</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido de Configuración de Integraciones -->
                <div class="config-content" id="integraciones-tab">
                    <div class="health-info">
                        <div class="info-card">
                            <h3><i class="fas fa-cloud"></i> Servicios en la Nube</h3>
                            <div class="cloud-services">
                                <div class="service-card">
                                    <div class="service-header">
                                        <i class="fab fa-aws"></i>
                                        <h4>Amazon Web Services</h4>
                                    </div>
                                    <div class="service-status">
                                        <span class="status-badge success">Conectado</span>
                                    </div>
                                    <div class="service-info">
                                        <div class="info-item">
                                            <span>Región:</span>
                                            <span>us-east-1</span>
                                        </div>
                                        <div class="info-item">
                                            <span>Última sincronización:</span>
                                            <span>Hace 2 horas</span>
                                        </div>
                                    </div>
                                    <button class="section-btn" onclick="configureAWS()">
                                        <i class="fas fa-cog"></i> Configurar
                                    </button>
                                </div>

                                <div class="service-card">
                                    <div class="service-header">
                                        <i class="fas fa-database"></i>
                                        <h4>Backup en Nube</h4>
                                    </div>
                                    <div class="service-status">
                                        <span class="status-badge warning">Pendiente</span>
                                    </div>
                                    <div class="service-info">
                                        <div class="info-item">
                                            <span>Proveedor:</span>
                                            <span>No configurado</span>
                                        </div>
                                        <div class="info-item">
                                            <span>Estado:</span>
                                            <span>Requiere configuración</span>
                                        </div>
                                    </div>
                                    <button class="section-btn" onclick="setupCloudBackup()">
                                        <i class="fas fa-play"></i> Configurar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="info-card">
                            <h3><i class="fas fa-exchange-alt"></i> APIs y Webhooks</h3>
                            <div class="api-settings">
                                <div class="option-group">
                                    <label>API Key:</label>
                                    <div class="api-key-container">
                                        <input type="text" id="apiKey" class="setting-input" value="sk_live_**********" readonly>
                                        <button class="section-btn" onclick="regenerateAPIKey()">
                                            <i class="fas fa-redo"></i> Regenerar
                                        </button>
                                    </div>
                                </div>
                                <div class="option-group">
                                    <label>Webhook URL:</label>
                                    <input type="url" id="webhookUrl" class="setting-input" placeholder="https://ejemplo.com/webhook">
                                </div>
                                <div class="option-group">
                                    <label class="switch">
                                        <input type="checkbox" id="webhookEnabled">
                                        <span class="slider"></span>
                                    </label>
                                    <span>Webhooks habilitados</span>
                                </div>
                                <div class="option-group">
                                    <label>Secret Key:</label>
                                    <input type="text" id="webhookSecret" class="setting-input" placeholder="Clave secreta para webhooks">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido de Configuración Avanzada -->
                <div class="config-content" id="avanzado-tab">
                    <div class="health-info">
                        <div class="info-card">
                            <h3><i class="fas fa-database"></i> Base de Datos</h3>
                            <div class="database-settings">
                                <div class="option-group">
                                    <label>Tipo de Base de Datos:</label>
                                    <span class="info-value">MySQL 8.0</span>
                                </div>
                                <div class="option-group">
                                    <label>Host:</label>
                                    <input type="text" id="dbHost" class="setting-input" value="localhost">
                                </div>
                                <div class="option-group">
                                    <label>Puerto:</label>
                                    <input type="number" id="dbPort" class="setting-input" value="3306">
                                </div>
                                <div class="option-group">
                                    <label>Nombre de BD:</label>
                                    <input type="text" id="dbName" class="setting-input" value="hospital_db">
                                </div>
                                <div class="option-group">
                                    <label>Usuario:</label>
                                    <input type="text" id="dbUser" class="setting-input" value="******" readonly>
                                </div>
                                <button class="section-btn btn-warning" onclick="testDatabaseConnection()">
                                    <i class="fas fa-plug"></i> Probar Conexión
                                </button>
                            </div>
                        </div>

                        <div class="info-card">
                            <h3><i class="fas fa-tools"></i> Mantenimiento</h3>
                            <div class="maintenance-actions">
                                <div class="action-group">
                                    <h4>Limpieza del Sistema</h4>
                                    <button class="section-btn" onclick="clearCache()">
                                        <i class="fas fa-broom"></i> Limpiar Cache
                                    </button>
                                    <button class="section-btn" onclick="optimizeDatabase()">
                                        <i class="fas fa-hammer"></i> Optimizar BD
                                    </button>
                                    <button class="section-btn btn-warning" onclick="clearLogs()">
                                        <i class="fas fa-trash"></i> Limpiar Logs
                                    </button>
                                </div>
                                <div class="action-group">
                                    <h4>Actualizaciones</h4>
                                    <div class="update-info">
                                        <span>Versión actual: v2.4.1</span>
                                        <span class="status-badge success">Actualizado</span>
                                    </div>
                                    <button class="section-btn" onclick="checkForUpdates()">
                                        <i class="fas fa-sync"></i> Buscar Actualizaciones
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="recent-section">
                        <h2>
                            <i class="fas fa-exclamation-triangle"></i> Operaciones Peligrosas
                        </h2>
                        <div class="danger-zone">
                            <div class="danger-item">
                                <div class="danger-info">
                                    <h4>Restablecer Configuración</h4>
                                    <p>Vuelve a la configuración predeterminada del sistema. Esta acción no se puede deshacer.</p>
                                </div>
                                <button class="section-btn btn-danger" onclick="showResetModal()">
                                    <i class="fas fa-undo"></i> Restablecer
                                </button>
                            </div>
                            <div class="danger-item">
                                <div class="danger-info">
                                    <h4>Eliminar Todos los Datos</h4>
                                    <p>Elimina permanentemente todos los datos del sistema. ¡Extrema precaución!</p>
                                </div>
                                <button class="section-btn btn-danger" onclick="showDeleteModal()">
                                    <i class="fas fa-trash"></i> Eliminar Todo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones de Guardado -->
                <div class="save-actions">
                    <button class="section-btn btn-success" onclick="saveAllSettings()">
                        <i class="fas fa-save"></i> Guardar Todos los Cambios
                    </button>
                    <button class="section-btn" onclick="resetChanges()">
                        <i class="fas fa-times"></i> Descartar Cambios
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de Confirmación de Restablecimiento -->
    <div class="modal-overlay" id="resetModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Confirmar Restablecimiento</h3>
                <button class="close-modal" onclick="closeResetModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="warning-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>¡Advertencia!</strong>
                        <p>Estás a punto de restablecer toda la configuración del sistema a los valores predeterminados. Esta acción no se puede deshacer.</p>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="section-btn" style="background: #95a5a6;" onclick="closeResetModal()">Cancelar</button>
                    <button type="button" class="section-btn btn-danger" onclick="resetToDefaults()">Confirmar Restablecimiento</button>
                </div>
            </div>
        </div>
    </div>

    <script src="configuracion.js"></script>
</body>
</html>