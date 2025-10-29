// respaldo-datos.js - Manteniendo el diseño del recepcionista

// Datos de ejemplo para respaldos
let backups = [
    {
        id: 1,
        name: "Respaldo_Completo_2024_01_15",
        timestamp: new Date(2024, 0, 15, 2, 0, 0),
        type: "Completo",
        size: 2.5,
        status: "success",
        location: "Local",
        verified: true
    },
    {
        id: 2,
        name: "Respaldo_Incremental_2024_01_16",
        timestamp: new Date(2024, 0, 16, 2, 0, 0),
        type: "Incremental",
        size: 0.8,
        status: "success",
        location: "Nube",
        verified: true
    },
    {
        id: 3,
        name: "Respaldo_Diferencial_2024_01_17",
        timestamp: new Date(2024, 0, 17, 2, 0, 0),
        type: "Diferencial",
        size: 1.2,
        status: "success",
        location: "Local",
        verified: true
    },
    {
        id: 4,
        name: "Respaldo_Completo_2024_01_18",
        timestamp: new Date(2024, 0, 18, 2, 0, 0),
        type: "Completo",
        size: 2.6,
        status: "failed",
        location: "Nube",
        verified: false
    },
    {
        id: 5,
        name: "Respaldo_Incremental_2024_01_19",
        timestamp: new Date(2024, 0, 19, 2, 0, 0),
        type: "Incremental",
        size: 0.9,
        status: "success",
        location: "Local",
        verified: true
    }
];

// Datos de ejemplo para programaciones
let schedules = [
    {
        id: 1,
        name: "Respaldo Diario Nocturno",
        frequency: "Diario",
        nextRun: new Date(2024, 0, 20, 2, 0, 0),
        type: "Incremental",
        destination: "Nube",
        enabled: true
    },
    {
        id: 2,
        name: "Respaldo Semanal Completo",
        frequency: "Semanal",
        nextRun: new Date(2024, 0, 21, 3, 0, 0),
        type: "Completo",
        destination: "Local",
        enabled: true
    },
    {
        id: 3,
        name: "Respaldo Mensual Archivo",
        frequency: "Mensual",
        nextRun: new Date(2024, 1, 1, 4, 0, 0),
        type: "Completo",
        destination: "Externo",
        enabled: false
    }
];

// Configuración del sistema
let systemConfig = {
    totalSpace: 50,
    usedSpace: 32.5,
    lastVerification: new Date(Date.now() - 2 * 60 * 60 * 1000),
    retentionPeriod: 30
};

// Variables globales
let currentEditingSchedule = null;

// Inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    loadBackupsTable();
    loadSchedulesTable();
    updateStatistics();
    updateSystemStatus();
});

// Cargar tabla de respaldos
function loadBackupsTable() {
    const tbody = document.getElementById('backupsTableBody');
    tbody.innerHTML = '';

    backups.forEach(backup => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>
                <strong>${backup.name}</strong>
                ${backup.verified ? ' <i class="fas fa-check-circle" style="color: #28a745;" title="Verificado"></i>' : ''}
            </td>
            <td>${formatDateTime(backup.timestamp)}</td>
            <td>
                <span class="status-badge ${getTypeBadgeClass(backup.type)}">${backup.type}</span>
            </td>
            <td>${backup.size} GB</td>
            <td>
                <span class="status-badge ${backup.status === 'success' ? 'success' : 'danger'}">
                    ${backup.status === 'success' ? 'Éxito' : 'Fallido'}
                </span>
            </td>
            <td>${backup.location}</td>
            <td>
                <button class="btn-action btn-restore" onclick="showRestoreModal(${backup.id})" title="Restaurar">
                    <i class="fas fa-undo"></i>
                </button>
                <button class="btn-action btn-download" onclick="downloadBackup(${backup.id})" title="Descargar">
                    <i class="fas fa-download"></i>
                </button>
                <button class="btn-action btn-delete" onclick="deleteBackup(${backup.id})" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Cargar tabla de programaciones
function loadSchedulesTable() {
    const tbody = document.getElementById('schedulesTableBody');
    tbody.innerHTML = '';

    schedules.forEach(schedule => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>
                <strong>${schedule.name}</strong>
            </td>
            <td>${schedule.frequency}</td>
            <td>${formatDateTime(schedule.nextRun)}</td>
            <td>${schedule.type}</td>
            <td>${schedule.destination}</td>
            <td>
                <span class="status-badge ${schedule.enabled ? 'success' : 'danger'}">
                    ${schedule.enabled ? 'Activa' : 'Inactiva'}
                </span>
            </td>
            <td>
                <button class="btn-action btn-edit" onclick="editSchedule(${schedule.id})" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action ${schedule.enabled ? 'btn-warning' : 'btn-success'}" 
                        onclick="toggleSchedule(${schedule.id})" 
                        title="${schedule.enabled ? 'Desactivar' : 'Activar'}">
                    <i class="fas fa-power-off"></i>
                </button>
                <button class="btn-action btn-delete" onclick="deleteSchedule(${schedule.id})" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Actualizar estadísticas
function updateStatistics() {
    document.getElementById('totalBackups').textContent = backups.length;
    
    const totalSize = backups.reduce((sum, backup) => sum + backup.size, 0);
    document.getElementById('totalSize').textContent = totalSize.toFixed(1) + ' GB';
    
    const successfulBackups = backups.filter(b => b.status === 'success').length;
    document.getElementById('successfulBackups').textContent = successfulBackups;
    
    const nextBackup = schedules.find(s => s.enabled)?.nextRun;
    document.getElementById('nextBackup').textContent = nextBackup ? formatTime(nextBackup) : 'No programado';
}

// Actualizar estado del sistema
function updateSystemStatus() {
    const diskUsage = (systemConfig.usedSpace / systemConfig.totalSpace) * 100;
    const progressBar = document.getElementById('diskSpaceProgress');
    progressBar.style.width = diskUsage + '%';
    
    if (diskUsage > 80) {
        progressBar.className = 'progress-fill danger';
    } else if (diskUsage > 60) {
        progressBar.className = 'progress-fill warning';
    } else {
        progressBar.className = 'progress-fill';
    }
    
    document.getElementById('lastVerification').textContent = calculateTimeAgo(systemConfig.lastVerification);
    document.getElementById('retentionPeriod').textContent = systemConfig.retentionPeriod + ' días';
    
    const integrityStatus = backups.filter(b => b.verified).length / backups.length;
    const integrityElement = document.getElementById('integrityStatus');
    if (integrityStatus >= 0.9) {
        integrityElement.textContent = 'Óptima';
        integrityElement.className = 'status-badge success';
    } else if (integrityStatus >= 0.7) {
        integrityElement.textContent = 'Aceptable';
        integrityElement.className = 'status-badge warning';
    } else {
        integrityElement.textContent = 'Crítica';
        integrityElement.className = 'status-badge danger';
    }
}

// Buscar respaldos
function searchBackups() {
    const searchTerm = document.getElementById('searchBackups').value.toLowerCase();
    const filteredBackups = backups.filter(backup => 
        backup.name.toLowerCase().includes(searchTerm) || 
        backup.type.toLowerCase().includes(searchTerm) ||
        backup.location.toLowerCase().includes(searchTerm)
    );
    
    updateBackupsTable(filteredBackups);
}

function updateBackupsTable(filteredBackups) {
    const tbody = document.getElementById('backupsTableBody');
    tbody.innerHTML = '';

    filteredBackups.forEach(backup => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>
                <strong>${backup.name}</strong>
                ${backup.verified ? ' <i class="fas fa-check-circle" style="color: #28a745;" title="Verificado"></i>' : ''}
            </td>
            <td>${formatDateTime(backup.timestamp)}</td>
            <td>
                <span class="status-badge ${getTypeBadgeClass(backup.type)}">${backup.type}</span>
            </td>
            <td>${backup.size} GB</td>
            <td>
                <span class="status-badge ${backup.status === 'success' ? 'success' : 'danger'}">
                    ${backup.status === 'success' ? 'Éxito' : 'Fallido'}
                </span>
            </td>
            <td>${backup.location}</td>
            <td>
                <button class="btn-action btn-restore" onclick="showRestoreModal(${backup.id})" title="Restaurar">
                    <i class="fas fa-undo"></i>
                </button>
                <button class="btn-action btn-download" onclick="downloadBackup(${backup.id})" title="Descargar">
                    <i class="fas fa-download"></i>
                </button>
                <button class="btn-action btn-delete" onclick="deleteBackup(${backup.id})" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Crear respaldo manual
function createManualBackup() {
    const type = document.getElementById('backupType').value;
    const database = document.getElementById('databaseSelect').value;
    const destination = document.getElementById('backupDestination').value;
    const compression = document.getElementById('compressionLevel').value;
    
    showNotification(`Iniciando respaldo ${type} de ${database}...`, 'info');
    
    // Simular proceso de respaldo
    setTimeout(() => {
        const newBackup = {
            id: Math.max(...backups.map(b => b.id)) + 1,
            name: `Respaldo_${getTypeName(type)}_${formatDate(new Date())}`,
            timestamp: new Date(),
            type: getTypeName(type),
            size: parseFloat((Math.random() * 2 + 0.5).toFixed(1)),
            status: 'success',
            location: getDestinationName(destination),
            verified: true
        };
        
        backups.unshift(newBackup);
        loadBackupsTable();
        updateStatistics();
        updateSystemStatus();
        showNotification('Respaldo creado exitosamente', 'success');
    }, 2000);
}

// Crear respaldo rápido
function createQuickBackup() {
    showNotification('Iniciando respaldo rápido...', 'info');
    
    setTimeout(() => {
        const newBackup = {
            id: Math.max(...backups.map(b => b.id)) + 1,
            name: `Respaldo_Rapido_${formatDate(new Date())}`,
            timestamp: new Date(),
            type: 'Incremental',
            size: parseFloat((Math.random() * 1 + 0.2).toFixed(1)),
            status: 'success',
            location: 'Local',
            verified: true
        };
        
        backups.unshift(newBackup);
        loadBackupsTable();
        updateStatistics();
        updateSystemStatus();
        showNotification('Respaldo rápido completado', 'success');
    }, 1500);
}

// Verificar integridad de respaldos
function verifyBackups() {
    showNotification('Verificando integridad de respaldos...', 'info');
    
    setTimeout(() => {
        backups.forEach(backup => {
            backup.verified = Math.random() > 0.2; // 80% de probabilidad de estar verificado
        });
        
        loadBackupsTable();
        updateSystemStatus();
        showNotification('Verificación de integridad completada', 'success');
    }, 3000);
}

// Limpiar respaldos antiguos
function cleanOldBackups() {
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - systemConfig.retentionPeriod);
    
    const oldBackups = backups.filter(b => b.timestamp < thirtyDaysAgo);
    
    if (oldBackups.length === 0) {
        showNotification('No hay respaldos antiguos para limpiar', 'info');
        return;
    }
    
    if (confirm(`¿Eliminar ${oldBackups.length} respaldos antiguos?`)) {
        backups = backups.filter(b => b.timestamp >= thirtyDaysAgo);
        loadBackupsTable();
        updateStatistics();
        updateSystemStatus();
        showNotification(`${oldBackups.length} respaldos antiguos eliminados`, 'success');
    }
}

// Mostrar modal de restauración
function showRestoreModal(backupId) {
    const backup = backups.find(b => b.id === backupId);
    if (!backup) return;

    const select = document.getElementById('restoreBackupSelect');
    select.innerHTML = '';
    
    backups.forEach(b => {
        const option = document.createElement('option');
        option.value = b.id;
        option.textContent = `${b.name} (${formatDateTime(b.timestamp)})`;
        if (b.id === backupId) option.selected = true;
        select.appendChild(option);
    });
    
    document.getElementById('restoreModal').classList.add('active');
}

// Cerrar modal de restauración
function closeRestoreModal() {
    document.getElementById('restoreModal').classList.remove('active');
}

// Ejecutar restauración
function executeRestore() {
    const backupId = document.getElementById('restoreBackupSelect').value;
    const restoreType = document.getElementById('restoreType').value;
    const verify = document.getElementById('verifyBeforeRestore').checked;
    
    const backup = backups.find(b => b.id == backupId);
    if (!backup) return;
    
    showNotification(`Iniciando restauración ${restoreType}...`, 'info');
    
    setTimeout(() => {
        closeRestoreModal();
        showNotification(`Restauración completada exitosamente desde ${backup.name}`, 'success');
    }, 3000);
}

// Descargar respaldo
function downloadBackup(backupId) {
    const backup = backups.find(b => b.id === backupId);
    if (!backup) return;
    
    showNotification(`Preparando descarga de ${backup.name}...`, 'info');
    // En una aplicación real, aquí iniciarías la descarga del archivo
}

// Eliminar respaldo
function deleteBackup(backupId) {
    const backup = backups.find(b => b.id === backupId);
    if (!backup) return;
    
    if (confirm(`¿Estás seguro de que deseas eliminar el respaldo "${backup.name}"?`)) {
        backups = backups.filter(b => b.id !== backupId);
        loadBackupsTable();
        updateStatistics();
        updateSystemStatus();
        showNotification('Respaldo eliminado correctamente', 'success');
    }
}

// Agregar nueva programación
function addNewSchedule() {
    currentEditingSchedule = null;
    document.getElementById('scheduleModalTitle').textContent = 'Nueva Programación de Respaldo';
    document.getElementById('scheduleForm').reset();
    document.getElementById('scheduleModal').classList.add('active');
}

// Editar programación
function editSchedule(scheduleId) {
    const schedule = schedules.find(s => s.id === scheduleId);
    if (!schedule) return;

    currentEditingSchedule = schedule;
    document.getElementById('scheduleModalTitle').textContent = 'Editar Programación';
    
    document.getElementById('scheduleName').value = schedule.name;
    document.getElementById('scheduleFrequency').value = schedule.frequency.toLowerCase();
    document.getElementById('scheduleTime').value = '02:00'; // Valor por defecto
    document.getElementById('scheduleType').value = schedule.type;
    document.getElementById('scheduleDestination').value = getDestinationKey(schedule.destination);
    document.getElementById('scheduleEnabled').checked = schedule.enabled;
    
    document.getElementById('scheduleModal').classList.add('active');
}

// Cerrar modal de programación
function closeScheduleModal() {
    document.getElementById('scheduleModal').classList.remove('active');
    currentEditingSchedule = null;
}

// Manejar envío del formulario de programación
document.getElementById('scheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('scheduleName').value;
    const frequency = document.getElementById('scheduleFrequency').value;
    const time = document.getElementById('scheduleTime').value;
    const type = document.getElementById('scheduleType').value;
    const destination = document.getElementById('scheduleDestination').value;
    const enabled = document.getElementById('scheduleEnabled').checked;
    
    // Calcular próxima ejecución
    const nextRun = calculateNextRun(frequency, time);
    
    if (currentEditingSchedule) {
        // Actualizar programación existente
        currentEditingSchedule.name = name;
        currentEditingSchedule.frequency = getFrequencyName(frequency);
        currentEditingSchedule.nextRun = nextRun;
        currentEditingSchedule.type = getTypeName(type);
        currentEditingSchedule.destination = getDestinationName(destination);
        currentEditingSchedule.enabled = enabled;
    } else {
        // Crear nueva programación
        const newSchedule = {
            id: Math.max(...schedules.map(s => s.id)) + 1,
            name: name,
            frequency: getFrequencyName(frequency),
            nextRun: nextRun,
            type: getTypeName(type),
            destination: getDestinationName(destination),
            enabled: enabled
        };
        schedules.push(newSchedule);
    }
    
    loadSchedulesTable();
    updateStatistics();
    closeScheduleModal();
    showNotification(currentEditingSchedule ? 'Programación actualizada' : 'Programación creada', 'success');
});

// Alternar estado de programación
function toggleSchedule(scheduleId) {
    const schedule = schedules.find(s => s.id === scheduleId);
    if (!schedule) return;
    
    schedule.enabled = !schedule.enabled;
    loadSchedulesTable();
    updateStatistics();
    showNotification(`Programación ${schedule.enabled ? 'activada' : 'desactivada'}`, 'success');
}

// Eliminar programación
function deleteSchedule(scheduleId) {
    const schedule = schedules.find(s => s.id === scheduleId);
    if (!schedule) return;
    
    if (confirm(`¿Estás seguro de que deseas eliminar la programación "${schedule.name}"?`)) {
        schedules = schedules.filter(s => s.id !== scheduleId);
        loadSchedulesTable();
        updateStatistics();
        showNotification('Programación eliminada correctamente', 'success');
    }
}

// Funciones de utilidad
function getTypeBadgeClass(type) {
    switch(type.toLowerCase()) {
        case 'completo': return 'info';
        case 'incremental': return 'success';
        case 'diferencial': return 'warning';
        default: return 'info';
    }
}

function getTypeName(key) {
    const types = {
        'full': 'Completo',
        'incremental': 'Incremental',
        'differential': 'Diferencial'
    };
    return types[key] || key;
}

function getDestinationName(key) {
    const destinations = {
        'local': 'Local',
        'cloud': 'Nube',
        'external': 'Externo'
    };
    return destinations[key] || key;
}

function getDestinationKey(name) {
    const keys = {
        'Local': 'local',
        'Nube': 'cloud',
        'Externo': 'external'
    };
    return keys[name] || name;
}

function getFrequencyName(key) {
    const frequencies = {
        'daily': 'Diario',
        'weekly': 'Semanal',
        'monthly': 'Mensual',
        'custom': 'Personalizado'
    };
    return frequencies[key] || key;
}

function calculateNextRun(frequency, time) {
    const nextRun = new Date();
    const [hours, minutes] = time.split(':').map(Number);
    
    nextRun.setHours(hours, minutes, 0, 0);
    
    switch(frequency) {
        case 'daily':
            nextRun.setDate(nextRun.getDate() + 1);
            break;
        case 'weekly':
            nextRun.setDate(nextRun.getDate() + 7);
            break;
        case 'monthly':
            nextRun.setMonth(nextRun.getMonth() + 1);
            break;
    }
    
    return nextRun;
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
    }).replace(/\//g, '_');
}

function formatTime(date) {
    return date.toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function calculateTimeAgo(timestamp) {
    const diff = Date.now() - timestamp.getTime();
    const hours = Math.floor(diff / (1000 * 60 * 60));
    
    if (hours < 1) return 'Hace menos de 1 hora';
    if (hours === 1) return 'Hace 1 hora';
    return `Hace ${hours} horas`;
}

// Funciones de las acciones rápidas
function showRestoreOptions() {
    showNotification('Mostrando opciones de restauración...', 'info');
    // Podría abrir el modal de restauración directamente
}

function manageStorage() {
    showNotification('Abriendo gestión de almacenamiento...', 'info');
    // Implementar lógica para gestionar almacenamiento
}

function showBackupLogs() {
    showNotification('Mostrando logs de respaldo...', 'info');
    // Implementar lógica para mostrar logs
}

function refreshBackups() {
    showNotification('Actualizando lista de respaldos...', 'info');
    loadBackupsTable();
}

function exportBackupReport() {
    showNotification('Generando reporte de respaldos...', 'info');
    // Implementar lógica para exportar reporte
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
document.getElementById('restoreModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRestoreModal();
    }
});

document.getElementById('scheduleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeScheduleModal();
    }
});