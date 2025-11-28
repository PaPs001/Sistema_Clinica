// control-accesos.js - Manteniendo el diseño del recepcionista

// Datos de ejemplo para sesiones activas
let activeSessions = [
    {
        id: 1,
        username: "admin",
        role: "Administrador",
        ip: "192.168.1.100",
        loginTime: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 horas atrás
        lastActivity: new Date(Date.now() - 5 * 60 * 1000), // 5 minutos atrás
        device: "Windows 10 - Chrome",
        location: "Oficina Central"
    },
    {
        id: 2,
        username: "maria.garcia",
        role: "Supervisor",
        ip: "192.168.1.105",
        loginTime: new Date(Date.now() - 1 * 60 * 60 * 1000), // 1 hora atrás
        lastActivity: new Date(Date.now() - 2 * 60 * 1000), // 2 minutos atrás
        device: "macOS - Safari",
        location: "Sucursal Norte"
    },
    {
        id: 3,
        username: "carlos.lopez",
        role: "Operador",
        ip: "192.168.1.110",
        loginTime: new Date(Date.now() - 30 * 60 * 1000), // 30 minutos atrás
        lastActivity: new Date(Date.now() - 10 * 60 * 1000), // 10 minutos atrás
        device: "Windows 11 - Firefox",
        location: "Oficina Central"
    }
];

// Datos de ejemplo para intentos fallidos
let failedAttempts = [
    {
        id: 1,
        username: "usuario.invalido",
        timestamp: new Date(Date.now() - 10 * 60 * 1000), // 10 minutos atrás
        ip: "192.168.1.120",
        reason: "Contraseña incorrecta",
        action: "Bloqueo temporal"
    },
    {
        id: 2,
        username: "admin",
        timestamp: new Date(Date.now() - 25 * 60 * 1000), // 25 minutos atrás
        ip: "192.168.1.125",
        reason: "Contraseña expirada",
        action: "Requerir cambio"
    },
    {
        id: 3,
        username: "juan.perez",
        timestamp: new Date(Date.now() - 45 * 60 * 1000), // 45 minutos atrás
        ip: "192.168.1.130",
        reason: "Usuario inactivo",
        action: "Cuenta suspendida"
    }
];

// Configuración de seguridad
let securitySettings = {
    passwordExpiration: true,
    passwordComplexity: true,
    passwordHistory: true,
    minPasswordLength: 10,
    accountLockout: true,
    maxAttempts: 5,
    lockoutDuration: 15
};

// Inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    loadActiveSessions();
    loadFailedAttempts();
    loadSecuritySettings();
    updateStatistics();
});

// Cargar sesiones activas
function loadActiveSessions() {
    const tbody = document.getElementById('sessionsTableBody');
    tbody.innerHTML = '';

    activeSessions.forEach(session => {
        const row = document.createElement('tr');
        const activeTime = calculateActiveTime(session.loginTime);
        const lastActivity = calculateTimeAgo(session.lastActivity);

        row.innerHTML = `
            <td>
                <strong>${session.username}</strong>
            </td>
            <td>${session.role}</td>
            <td>${session.ip}</td>
            <td>${formatDateTime(session.loginTime)}</td>
            <td>${lastActivity}</td>
            <td>${activeTime}</td>
            <td>
                <button class="btn-action btn-details" onclick="showSessionDetails(${session.id})" title="Ver detalles">
                    <i class="fas fa-info-circle"></i>
                </button>
                <button class="btn-action btn-terminate" onclick="terminateSession(${session.id})" title="Terminar sesión">
                    <i class="fas fa-power-off"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Cargar intentos fallidos
function loadFailedAttempts() {
    const tbody = document.getElementById('failedAttemptsTableBody');
    tbody.innerHTML = '';

    failedAttempts.forEach(attempt => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${attempt.username}</td>
            <td>${formatDateTime(attempt.timestamp)}</td>
            <td>${attempt.ip}</td>
            <td>${attempt.reason}</td>
            <td>
                <span class="status-badge warning">${attempt.action}</span>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Cargar configuración de seguridad
function loadSecuritySettings() {
    document.getElementById('passwordExpiration').checked = securitySettings.passwordExpiration;
    document.getElementById('passwordComplexity').checked = securitySettings.passwordComplexity;
    document.getElementById('passwordHistory').checked = securitySettings.passwordHistory;
    document.getElementById('minPasswordLength').value = securitySettings.minPasswordLength;
    document.getElementById('accountLockout').checked = securitySettings.accountLockout;
    document.getElementById('maxAttempts').value = securitySettings.maxAttempts;
    document.getElementById('lockoutDuration').value = securitySettings.lockoutDuration;
}

// Actualizar estadísticas
function updateStatistics() {
    document.getElementById('totalSessions').textContent = activeSessions.length;
    document.getElementById('blockedUsers').textContent = failedAttempts.filter(a => a.action.includes('Bloqueo')).length;
    document.getElementById('failedAttempts').textContent = failedAttempts.length;
    
    // Calcular nivel de seguridad basado en la configuración
    const securityScore = calculateSecurityScore();
    document.getElementById('securityLevel').textContent = securityScore >= 8 ? 'Alto' : securityScore >= 5 ? 'Medio' : 'Bajo';
}

// Calcular puntuación de seguridad
function calculateSecurityScore() {
    let score = 0;
    if (securitySettings.passwordExpiration) score += 2;
    if (securitySettings.passwordComplexity) score += 2;
    if (securitySettings.passwordHistory) score += 1;
    if (securitySettings.accountLockout) score += 2;
    if (securitySettings.minPasswordLength >= 10) score += 2;
    if (securitySettings.maxAttempts <= 5) score += 1;
    return score;
}

// Buscar en sesiones e intentos fallidos
function searchAccess() {
    const searchTerm = document.getElementById('searchAccess').value.toLowerCase();
    
    // Filtrar sesiones
    const filteredSessions = activeSessions.filter(session => 
        session.username.toLowerCase().includes(searchTerm) || 
        session.role.toLowerCase().includes(searchTerm) ||
        session.ip.includes(searchTerm)
    );
    
    // Filtrar intentos fallidos
    const filteredAttempts = failedAttempts.filter(attempt => 
        attempt.username.toLowerCase().includes(searchTerm) || 
        attempt.ip.includes(searchTerm) ||
        attempt.reason.toLowerCase().includes(searchTerm)
    );
    
    // Actualizar tablas
    updateSessionsTable(filteredSessions);
    updateFailedAttemptsTable(filteredAttempts);
}

function updateSessionsTable(sessions) {
    const tbody = document.getElementById('sessionsTableBody');
    tbody.innerHTML = '';

    sessions.forEach(session => {
        const row = document.createElement('tr');
        const activeTime = calculateActiveTime(session.loginTime);
        const lastActivity = calculateTimeAgo(session.lastActivity);

        row.innerHTML = `
            <td>
                <strong>${session.username}</strong>
            </td>
            <td>${session.role}</td>
            <td>${session.ip}</td>
            <td>${formatDateTime(session.loginTime)}</td>
            <td>${lastActivity}</td>
            <td>${activeTime}</td>
            <td>
                <button class="btn-action btn-details" onclick="showSessionDetails(${session.id})" title="Ver detalles">
                    <i class="fas fa-info-circle"></i>
                </button>
                <button class="btn-action btn-terminate" onclick="terminateSession(${session.id})" title="Terminar sesión">
                    <i class="fas fa-power-off"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

function updateFailedAttemptsTable(attempts) {
    const tbody = document.getElementById('failedAttemptsTableBody');
    tbody.innerHTML = '';

    attempts.forEach(attempt => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${attempt.username}</td>
            <td>${formatDateTime(attempt.timestamp)}</td>
            <td>${attempt.ip}</td>
            <td>${attempt.reason}</td>
            <td>
                <span class="status-badge warning">${attempt.action}</span>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Mostrar detalles de sesión
function showSessionDetails(sessionId) {
    const session = activeSessions.find(s => s.id === sessionId);
    if (!session) return;

    const modal = document.getElementById('sessionModal');
    const details = document.getElementById('sessionDetails');
    
    const activeTime = calculateActiveTime(session.loginTime);
    const lastActivity = calculateTimeAgo(session.lastActivity);

    details.innerHTML = `
        <div class="session-detail">
            <strong>Usuario:</strong> ${session.username}
        </div>
        <div class="session-detail">
            <strong>Rol:</strong> ${session.role}
        </div>
        <div class="session-detail">
            <strong>IP:</strong> ${session.ip}
        </div>
        <div class="session-detail">
            <strong>Dispositivo:</strong> ${session.device}
        </div>
        <div class="session-detail">
            <strong>Ubicación:</strong> ${session.location}
        </div>
        <div class="session-detail">
            <strong>Inicio de sesión:</strong> ${formatDateTime(session.loginTime)}
        </div>
        <div class="session-detail">
            <strong>Última actividad:</strong> ${lastActivity}
        </div>
        <div class="session-detail">
            <strong>Tiempo activo:</strong> ${activeTime}
        </div>
    `;
    
    modal.classList.add('active');
}

// Cerrar modal de detalles
function closeSessionModal() {
    document.getElementById('sessionModal').classList.remove('active');
}

// Terminar sesión individual
function terminateSession(sessionId) {
    const session = activeSessions.find(s => s.id === sessionId);
    if (!session) return;

    if (confirm(`¿Estás seguro de que deseas terminar la sesión de ${session.username}?`)) {
        activeSessions = activeSessions.filter(s => s.id !== sessionId);
        loadActiveSessions();
        updateStatistics();
        showNotification(`Sesión de ${session.username} terminada correctamente`, 'success');
    }
}

// Terminar todas las sesiones
function terminateAllSessions() {
    if (confirm('¿Estás seguro de que deseas terminar todas las sesiones activas?')) {
        activeSessions = [];
        loadActiveSessions();
        updateStatistics();
        showNotification('Todas las sesiones han sido terminadas', 'success');
    }
}

// Refrescar sesiones
function refreshSessions() {
    showNotification('Sesiones actualizadas', 'info');
    // En una aplicación real, aquí harías una llamada al servidor
    loadActiveSessions();
}

// Guardar configuración de seguridad
function saveSecuritySettings() {
    securitySettings = {
        passwordExpiration: document.getElementById('passwordExpiration').checked,
        passwordComplexity: document.getElementById('passwordComplexity').checked,
        passwordHistory: document.getElementById('passwordHistory').checked,
        minPasswordLength: parseInt(document.getElementById('minPasswordLength').value),
        accountLockout: document.getElementById('accountLockout').checked,
        maxAttempts: parseInt(document.getElementById('maxAttempts').value),
        lockoutDuration: parseInt(document.getElementById('lockoutDuration').value)
    };
    
    showNotification('Configuración de seguridad guardada correctamente', 'success');
    updateStatistics();
}

// Limpiar registros de intentos fallidos
function clearFailedAttempts() {
    if (confirm('¿Estás seguro de que deseas limpiar todos los registros de intentos fallidos?')) {
        failedAttempts = [];
        loadFailedAttempts();
        updateStatistics();
        showNotification('Registros de intentos fallidos limpiados', 'success');
    }
}

// Funciones de utilidad
function calculateActiveTime(loginTime) {
    const diff = Date.now() - loginTime.getTime();
    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    return `${hours}h ${minutes}m`;
}

function calculateTimeAgo(timestamp) {
    const diff = Date.now() - timestamp.getTime();
    const minutes = Math.floor(diff / (1000 * 60));
    
    if (minutes < 1) return 'Ahora mismo';
    if (minutes < 60) return `Hace ${minutes} min`;
    
    const hours = Math.floor(minutes / 60);
    return `Hace ${hours} h`;
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

// Funciones de las acciones rápidas
function showAccessLogs() {
    showNotification('Mostrando logs de acceso...', 'info');
    // Implementar lógica para mostrar logs
}

function manageIPWhitelist() {
    showNotification('Abriendo gestión de IPs permitidas...', 'info');
    // Implementar lógica para gestionar IPs
}

function generateSecurityReport() {
    showNotification('Generando reporte de seguridad...', 'info');
    // Implementar lógica para generar reporte
}

function showSecurityAlerts() {
    showNotification('Mostrando alertas de seguridad...', 'info');
    // Implementar lógica para mostrar alertas
}

// Función de logout
function logout() {
    if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
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
document.getElementById('sessionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSessionModal();
    }
});