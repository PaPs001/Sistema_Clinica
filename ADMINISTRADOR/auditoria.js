// auditoria.js - Manteniendo el diseño del recepcionista

// Datos de ejemplo para logs de auditoría
let auditLogs = [
    {
        id: 1,
        timestamp: new Date(2024, 0, 19, 14, 30, 0),
        username: "admin",
        eventType: "security",
        description: "Inicio de sesión exitoso desde IP 192.168.1.100",
        severity: "info",
        ip: "192.168.1.100",
        details: {
            userAgent: "Chrome/120.0 Windows 10",
            location: "Oficina Central",
            sessionId: "sess_abc123"
        }
    },
    {
        id: 2,
        timestamp: new Date(2024, 0, 19, 14, 25, 0),
        username: "usuario.invalido",
        eventType: "security",
        description: "Intento fallido de inicio de sesión",
        severity: "high",
        ip: "192.168.1.150",
        details: {
            userAgent: "Firefox/115.0 Linux",
            reason: "Contraseña incorrecta",
            attempts: 3
        }
    },
    {
        id: 3,
        timestamp: new Date(2024, 0, 19, 14, 15, 0),
        username: "maria.garcia",
        eventType: "user",
        description: "Modificación de perfil de usuario",
        severity: "low",
        ip: "192.168.1.105",
        details: {
            changes: ["email", "telefono"],
            targetUser: "carlos.lopez"
        }
    },
    {
        id: 4,
        timestamp: new Date(2024, 0, 19, 14, 0, 0),
        username: "system",
        eventType: "system",
        description: "Respaldo automático completado exitosamente",
        severity: "info",
        ip: "localhost",
        details: {
            backupType: "incremental",
            size: "2.1 GB",
            duration: "15m 30s"
        }
    },
    {
        id: 5,
        timestamp: new Date(2024, 0, 19, 13, 45, 0),
        username: "admin",
        eventType: "database",
        description: "Consulta compleja ejecutada en base de datos principal",
        severity: "medium",
        ip: "192.168.1.100",
        details: {
            database: "principal",
            queryType: "SELECT",
            executionTime: "2.5s",
            rowsReturned: 1250
        }
    },
    {
        id: 6,
        timestamp: new Date(2024, 0, 19, 13, 30, 0),
        username: "system",
        eventType: "security",
        description: "Intento de acceso no autorizado a archivo de configuración",
        severity: "critical",
        ip: "192.168.1.200",
        details: {
            file: "/etc/config/sistema.conf",
            action: "blocked",
            reason: "IP no autorizada"
        }
    }
];

// Datos de ejemplo para alertas de seguridad
let securityAlerts = [
    {
        id: 1,
        title: "Múltiples intentos fallidos de acceso",
        timestamp: new Date(2024, 0, 19, 14, 25, 0),
        severity: "high",
        description: "Se detectaron 5 intentos fallidos de inicio de sesión desde la IP 192.168.1.150 en los últimos 10 minutos.",
        read: false
    },
    {
        id: 2,
        title: "Acceso desde ubicación inusual",
        timestamp: new Date(2024, 0, 19, 13, 45, 0),
        severity: "medium",
        description: "El usuario admin inició sesión desde una ubicación no reconocida (IP: 201.150.100.50).",
        read: false
    },
    {
        id: 3,
        title: "Uso elevado de recursos del sistema",
        timestamp: new Date(2024, 0, 19, 12, 30, 0),
        severity: "medium",
        description: "La base de datos principal muestra un uso del 95% de CPU durante los últimos 15 minutos.",
        read: true
    },
    {
        id: 4,
        title: "Configuración de seguridad modificada",
        timestamp: new Date(2024, 0, 19, 11, 15, 0),
        severity: "critical",
        description: "Se modificaron las políticas de contraseñas sin autorización explícita.",
        read: false
    }
];

// Configuración de auditoría
let auditConfig = {
    realTimeMonitoring: true,
    retentionDays: 90,
    logLevels: {
        info: true,
        warning: true,
        error: true,
        critical: true
    },
    alerts: {
        critical: true,
        security: true,
        failedLogin: true
    }
};

// Variables globales
let currentFilters = {
    eventType: 'all',
    severityLevel: 'all',
    user: 'all',
    dateFrom: null,
    dateTo: null
};
let realTimeInterval = null;

// Inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    loadAuditTable();
    loadSecurityAlerts();
    loadUserFilter();
    updateStatistics();
    initializeDateFilters();
    startRealTimeMonitoring();
});

// Cargar tabla de auditoría
function loadAuditTable() {
    const tbody = document.getElementById('auditTableBody');
    tbody.innerHTML = '';

    const filteredLogs = filterLogs(auditLogs);
    
    filteredLogs.forEach(log => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${formatDateTime(log.timestamp)}</td>
            <td>
                <strong>${log.username}</strong>
                ${log.username === 'system' ? ' <i class="fas fa-cog" style="color: #6c757d;"></i>' : ''}
            </td>
            <td>
                <span class="event-badge ${log.eventType}">${getEventTypeName(log.eventType)}</span>
            </td>
            <td>${log.description}</td>
            <td>
                <span class="severity-badge ${log.severity}">${getSeverityName(log.severity)}</span>
            </td>
            <td>${log.ip}</td>
            <td>
                <button class="btn-action btn-details" onclick="showLogDetails(${log.id})" title="Ver detalles">
                    <i class="fas fa-search"></i>
                </button>
                <button class="btn-action btn-export" onclick="exportLog(${log.id})" title="Exportar">
                    <i class="fas fa-download"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Cargar alertas de seguridad
function loadSecurityAlerts() {
    const grid = document.querySelector('.alerts-grid');
    grid.innerHTML = '';

    securityAlerts.forEach(alert => {
        const alertCard = document.createElement('div');
        alertCard.className = `alert-card ${alert.severity} ${alert.read ? 'read' : ''}`;
        
        alertCard.innerHTML = `
            <div class="alert-header">
                <div>
                    <div class="alert-title">${alert.title}</div>
                    <div class="alert-time">${formatDateTime(alert.timestamp)}</div>
                </div>
                <span class="alert-badge ${alert.severity}">${getSeverityName(alert.severity)}</span>
            </div>
            <div class="alert-description">${alert.description}</div>
            <div class="alert-actions">
                ${!alert.read ? `
                    <button class="section-btn" onclick="markAlertAsRead(${alert.id})">
                        <i class="fas fa-check"></i> Marcar Leído
                    </button>
                ` : ''}
                <button class="section-btn" onclick="investigateAlert(${alert.id})">
                    <i class="fas fa-search"></i> Investigar
                </button>
            </div>
        `;
        
        grid.appendChild(alertCard);
    });
}

// Cargar filtro de usuarios
function loadUserFilter() {
    const select = document.getElementById('userFilter');
    const users = [...new Set(auditLogs.map(log => log.username))];
    
    users.forEach(user => {
        const option = document.createElement('option');
        option.value = user;
        option.textContent = user;
        select.appendChild(option);
    });
}

// Inicializar filtros de fecha
function initializeDateFilters() {
    const today = new Date();
    const oneWeekAgo = new Date();
    oneWeekAgo.setDate(today.getDate() - 7);
    
    document.getElementById('dateFrom').valueAsDate = oneWeekAgo;
    document.getElementById('dateTo').valueAsDate = today;
}

// Actualizar estadísticas
function updateStatistics() {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const todayEvents = auditLogs.filter(log => 
        new Date(log.timestamp) >= today
    ).length;
    
    document.getElementById('totalEvents').textContent = todayEvents;
    
    const criticalEvents = auditLogs.filter(log => 
        log.severity === 'critical'
    ).length;
    document.getElementById('criticalEvents').textContent = criticalEvents;
    
    const securityEvents = auditLogs.filter(log => 
        log.eventType === 'security'
    ).length;
    document.getElementById('securityEvents').textContent = securityEvents;
    
    const logSize = (auditLogs.length * 0.5).toFixed(1); // Simulación de tamaño
    document.getElementById('logSize').textContent = logSize + ' MB';
}

// Aplicar filtros
function applyFilters() {
    currentFilters = {
        eventType: document.getElementById('eventType').value,
        severityLevel: document.getElementById('severityLevel').value,
        user: document.getElementById('userFilter').value,
        dateFrom: document.getElementById('dateFrom').value ? new Date(document.getElementById('dateFrom').value) : null,
        dateTo: document.getElementById('dateTo').value ? new Date(document.getElementById('dateTo').value) : null
    };
    
    loadAuditTable();
}

// Filtrar logs
function filterLogs(logs) {
    return logs.filter(log => {
        // Filtro por tipo de evento
        if (currentFilters.eventType !== 'all' && log.eventType !== currentFilters.eventType) {
            return false;
        }
        
        // Filtro por nivel de severidad
        if (currentFilters.severityLevel !== 'all' && log.severity !== currentFilters.severityLevel) {
            return false;
        }
        
        // Filtro por usuario
        if (currentFilters.user !== 'all' && log.username !== currentFilters.user) {
            return false;
        }
        
        // Filtro por fecha
        const logDate = new Date(log.timestamp);
        if (currentFilters.dateFrom && logDate < currentFilters.dateFrom) {
            return false;
        }
        if (currentFilters.dateTo) {
            const endOfDay = new Date(currentFilters.dateTo);
            endOfDay.setHours(23, 59, 59, 999);
            if (logDate > endOfDay) {
                return false;
            }
        }
        
        return true;
    });
}

// Limpiar filtros
function clearFilters() {
    document.getElementById('eventType').value = 'all';
    document.getElementById('severityLevel').value = 'all';
    document.getElementById('userFilter').value = 'all';
    initializeDateFilters();
    
    applyFilters();
}

// Buscar en logs
function searchAudit() {
    const searchTerm = document.getElementById('searchAudit').value.toLowerCase();
    const filteredLogs = auditLogs.filter(log => 
        log.description.toLowerCase().includes(searchTerm) ||
        log.username.toLowerCase().includes(searchTerm) ||
        log.ip.includes(searchTerm)
    );
    
    updateAuditTable(filteredLogs);
}

function updateAuditTable(filteredLogs) {
    const tbody = document.getElementById('auditTableBody');
    tbody.innerHTML = '';

    filteredLogs.forEach(log => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${formatDateTime(log.timestamp)}</td>
            <td>
                <strong>${log.username}</strong>
                ${log.username === 'system' ? ' <i class="fas fa-cog" style="color: #6c757d;"></i>' : ''}
            </td>
            <td>
                <span class="event-badge ${log.eventType}">${getEventTypeName(log.eventType)}</span>
            </td>
            <td>${log.description}</td>
            <td>
                <span class="severity-badge ${log.severity}">${getSeverityName(log.severity)}</span>
            </td>
            <td>${log.ip}</td>
            <td>
                <button class="btn-action btn-details" onclick="showLogDetails(${log.id})" title="Ver detalles">
                    <i class="fas fa-search"></i>
                </button>
                <button class="btn-action btn-export" onclick="exportLog(${log.id})" title="Exportar">
                    <i class="fas fa-download"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Mostrar detalles del log
function showLogDetails(logId) {
    const log = auditLogs.find(l => l.id === logId);
    if (!log) return;

    const modal = document.getElementById('logDetailModal');
    const details = document.getElementById('logDetails');
    
    details.innerHTML = `
        <div class="log-detail">
            <strong>ID del Evento:</strong> ${log.id}
        </div>
        <div class="log-detail">
            <strong>Fecha y Hora:</strong> ${formatDateTime(log.timestamp)}
        </div>
        <div class="log-detail">
            <strong>Usuario:</strong> ${log.username}
        </div>
        <div class="log-detail">
            <strong>Tipo de Evento:</strong> 
            <span class="event-badge ${log.eventType}">${getEventTypeName(log.eventType)}</span>
        </div>
        <div class="log-detail">
            <strong>Severidad:</strong> 
            <span class="severity-badge ${log.severity}">${getSeverityName(log.severity)}</span>
        </div>
        <div class="log-detail">
            <strong>Descripción:</strong> ${log.description}
        </div>
        <div class="log-detail">
            <strong>Dirección IP:</strong> ${log.ip}
        </div>
        <div class="log-detail">
            <strong>Detalles Adicionales:</strong>
            <pre style="margin-top: 10px; background: #f8f9fa; padding: 10px; border-radius: 5px; white-space: pre-wrap;">${JSON.stringify(log.details, null, 2)}</pre>
        </div>
    `;
    
    modal.classList.add('active');
}

// Cerrar modal de detalles
function closeLogDetailModal() {
    document.getElementById('logDetailModal').classList.remove('active');
}

// Exportar log individual
function exportLog(logId) {
    const log = auditLogs.find(l => l.id === logId);
    if (!log) return;
    
    showNotification(`Exportando log ${log.id}...`, 'info');
    // En una aplicación real, aquí generarías el archivo de exportación
}

// Exportar todos los logs
function exportAuditLogs() {
    const filteredLogs = filterLogs(auditLogs);
    showNotification(`Exportando ${filteredLogs.length} logs de auditoría...`, 'info');
    // En una aplicación real, aquí generarías el archivo de exportación
}

// Refrescar logs
function refreshLogs() {
    showNotification('Actualizando logs...', 'info');
    loadAuditTable();
    updateStatistics();
}

// Limpiar logs antiguos
function clearOldLogs() {
    const retentionDays = auditConfig.retentionDays;
    const cutoffDate = new Date();
    cutoffDate.setDate(cutoffDate.getDate() - retentionDays);
    
    const oldLogs = auditLogs.filter(log => new Date(log.timestamp) < cutoffDate);
    
    if (oldLogs.length === 0) {
        showNotification('No hay logs antiguos para limpiar', 'info');
        return;
    }
    
    if (confirm(`¿Eliminar ${oldLogs.length} logs anteriores a ${formatDate(cutoffDate)}?`)) {
        auditLogs = auditLogs.filter(log => new Date(log.timestamp) >= cutoffDate);
        loadAuditTable();
        updateStatistics();
        showNotification(`${oldLogs.length} logs antiguos eliminados`, 'success');
    }
}

// Mostrar configuración de logs
function showLogSettings() {
    document.getElementById('logInfo').checked = auditConfig.logLevels.info;
    document.getElementById('logWarning').checked = auditConfig.logLevels.warning;
    document.getElementById('logError').checked = auditConfig.logLevels.error;
    document.getElementById('logCritical').checked = auditConfig.logLevels.critical;
    
    document.getElementById('retentionDays').value = auditConfig.retentionDays;
    
    document.getElementById('alertCritical').checked = auditConfig.alerts.critical;
    document.getElementById('alertSecurity').checked = auditConfig.alerts.security;
    document.getElementById('alertFailedLogin').checked = auditConfig.alerts.failedLogin;
    
    document.getElementById('logSettingsModal').classList.add('active');
}

// Cerrar configuración de logs
function closeLogSettingsModal() {
    document.getElementById('logSettingsModal').classList.remove('active');
}

// Guardar configuración de logs
document.getElementById('logSettingsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    auditConfig = {
        realTimeMonitoring: auditConfig.realTimeMonitoring,
        retentionDays: parseInt(document.getElementById('retentionDays').value),
        logLevels: {
            info: document.getElementById('logInfo').checked,
            warning: document.getElementById('logWarning').checked,
            error: document.getElementById('logError').checked,
            critical: document.getElementById('logCritical').checked
        },
        alerts: {
            critical: document.getElementById('alertCritical').checked,
            security: document.getElementById('alertSecurity').checked,
            failedLogin: document.getElementById('alertFailedLogin').checked
        }
    };
    
    closeLogSettingsModal();
    showNotification('Configuración de auditoría guardada', 'success');
});

// Gestión de alertas
function markAlertAsRead(alertId) {
    const alert = securityAlerts.find(a => a.id === alertId);
    if (alert) {
        alert.read = true;
        loadSecurityAlerts();
        showNotification('Alerta marcada como leída', 'success');
    }
}

function markAllAsRead() {
    securityAlerts.forEach(alert => {
        alert.read = true;
    });
    loadSecurityAlerts();
    showNotification('Todas las alertas marcadas como leídas', 'success');
}

function investigateAlert(alertId) {
    const alert = securityAlerts.find(a => a.id === alertId);
    if (alert) {
        showNotification(`Investigando alerta: ${alert.title}`, 'info');
        // En una aplicación real, aquí navegarías a la investigación
    }
}

// Monitoreo en tiempo real
function startRealTimeMonitoring() {
    if (auditConfig.realTimeMonitoring) {
        realTimeInterval = setInterval(() => {
            // Simular nuevo evento en tiempo real
            if (Math.random() > 0.7) { // 30% de probabilidad
                addRandomEvent();
            }
        }, 10000); // Cada 10 segundos
    }
}

function toggleRealTime() {
    const button = document.querySelector('.real-time-indicator button');
    const status = document.getElementById('realTimeStatus');
    
    if (auditConfig.realTimeMonitoring) {
        clearInterval(realTimeInterval);
        auditConfig.realTimeMonitoring = false;
        status.textContent = 'Pausado';
        button.innerHTML = '<i class="fas fa-play"></i> Reanudar';
        button.className = 'section-btn btn-success';
    } else {
        startRealTimeMonitoring();
        auditConfig.realTimeMonitoring = true;
        status.textContent = 'Activo';
        button.innerHTML = '<i class="fas fa-pause"></i> Pausar';
        button.className = 'section-btn btn-warning';
    }
}

function addRandomEvent() {
    const eventTypes = ['security', 'system', 'user', 'database', 'network'];
    const severities = ['info', 'low', 'medium', 'high', 'critical'];
    const users = ['admin', 'maria.garcia', 'carlos.lopez', 'system', 'usuario.invalido'];
    
    const newEvent = {
        id: Math.max(...auditLogs.map(l => l.id)) + 1,
        timestamp: new Date(),
        username: users[Math.floor(Math.random() * users.length)],
        eventType: eventTypes[Math.floor(Math.random() * eventTypes.length)],
        description: `Evento automático generado - ${new Date().toLocaleTimeString()}`,
        severity: severities[Math.floor(Math.random() * severities.length)],
        ip: `192.168.1.${Math.floor(Math.random() * 255)}`,
        details: {
            autoGenerated: true,
            timestamp: new Date().toISOString()
        }
    };
    
    auditLogs.unshift(newEvent);
    
    // Mantener un máximo de 1000 logs para performance
    if (auditLogs.length > 1000) {
        auditLogs = auditLogs.slice(0, 1000);
    }
    
    loadAuditTable();
    updateStatistics();
    
    // Si es un evento crítico, generar alerta
    if (newEvent.severity === 'critical' && auditConfig.alerts.critical) {
        const newAlert = {
            id: Math.max(...securityAlerts.map(a => a.id)) + 1,
            title: 'Evento Crítico Detectado',
            timestamp: new Date(),
            severity: 'critical',
            description: newEvent.description,
            read: false
        };
        securityAlerts.unshift(newAlert);
        loadSecurityAlerts();
    }
}

// Funciones de utilidad
function getEventTypeName(type) {
    const types = {
        'security': 'Seguridad',
        'system': 'Sistema',
        'user': 'Usuario',
        'database': 'Base de Datos',
        'network': 'Red'
    };
    return types[type] || type;
}

function getSeverityName(severity) {
    const severities = {
        'critical': 'Crítico',
        'high': 'Alto',
        'medium': 'Medio',
        'low': 'Bajo',
        'info': 'Informativo'
    };
    return severities[severity] || severity;
}

function formatDateTime(date) {
    return date.toLocaleString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatDate(date) {
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

// Funciones de las acciones rápidas
function generateAuditReport() {
    showNotification('Generando reporte de auditoría...', 'info');
    // Implementar lógica para generar reporte
}

function showComplianceReport() {
    showNotification('Mostrando reporte de cumplimiento...', 'info');
    // Implementar lógica para mostrar cumplimiento
}

function manageAlertRules() {
    showNotification('Abriendo gestión de reglas de alerta...', 'info');
    // Implementar lógica para gestionar reglas
}

function showSystemHealth() {
    showNotification('Mostrando salud del sistema...', 'info');
    // Implementar lógica para mostrar salud
}

// Función de logout
function logout() {
    if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        if (realTimeInterval) {
            clearInterval(realTimeInterval);
        }
        showNotification('Sesión cerrada correctamente', 'info');
        // En una aplicación real, aquí redirigirías al login
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 1000);
    }
}

// Mostrar notificación
function showNotification(message, type = 'info') {
    // En una aplicación real, usarías un sistema de notificaciones más sofisticado
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff'};
        color: white;
        border-radius: 5px;
        z-index: 1001;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Cerrar modales al hacer clic fuera de ellos
document.getElementById('logDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLogDetailModal();
    }
});

document.getElementById('logSettingsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLogSettingsModal();
    }
});