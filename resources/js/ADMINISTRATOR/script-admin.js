// script-admin.js - Versión mejorada para administrador
console.log('Script administrador mejorado cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Administrador');
    
    try {
        // Navegación activa
        const navItems = document.querySelectorAll('.nav-item');
        if (navItems.length === 0) {
            console.error('No se encontraron elementos .nav-item');
            return;
        }
        
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                
                // Redirigir a la página correspondiente
                const href = this.getAttribute('href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });
        });

        // Buscador mejorado para administrador
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterUsersAndReports(searchTerm);
            });
            
            // Agregar funcionalidad de búsqueda con Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performAdminSearch(this.value);
                }
            });
        }

        // Notificaciones con modal
        const notificationBell = document.querySelector('.notifications');
        const notificationsModal = document.getElementById('notifications-modal');
        const closeModal = document.querySelector('.close-modal');
        
        if (notificationBell && notificationsModal) {
            notificationBell.addEventListener('click', function() {
                notificationsModal.classList.add('active');
                // Marcar notificaciones como leídas
                markNotificationsAsRead();
            });
            
            closeModal.addEventListener('click', function() {
                notificationsModal.classList.remove('active');
            });
            
            // Cerrar modal al hacer clic fuera
            notificationsModal.addEventListener('click', function(e) {
                if (e.target === notificationsModal) {
                    notificationsModal.classList.remove('active');
                }
            });
        }

        // Configurar botones de acción
        setupAdminActionButtons();

        // Botones de filtro y exportación específicos para administrador
        const filterRolesBtn = document.getElementById('filter-roles');
        const addUserBtn = document.getElementById('add-user');
        const managePermissionsBtn = document.getElementById('manage-permissions');
        const accessLogBtn = document.getElementById('access-log');
        const backupNowBtn = document.getElementById('backup-now');
        const scheduleBackupBtn = document.getElementById('schedule-backup');
        
        if (filterRolesBtn) {
            filterRolesBtn.addEventListener('click', showRoleFilters);
        }
        
        if (addUserBtn) {
            addUserBtn.addEventListener('click', addNewUser);
        }
        
        if (managePermissionsBtn) {
            managePermissionsBtn.addEventListener('click', managePermissions);
        }
        
        if (accessLogBtn) {
            accessLogBtn.addEventListener('click', showAccessLog);
        }
        
        if (backupNowBtn) {
            backupNowBtn.addEventListener('click', performBackup);
        }
        
        if (scheduleBackupBtn) {
            scheduleBackupBtn.addEventListener('click', scheduleBackup);
        }

        // Simular actualizaciones en tiempo real (para demo)
        simulateAdminRealTimeUpdates();

        console.log('Todos los event listeners configurados correctamente para administrador');
        
    } catch (error) {
        console.error('Error al configurar el dashboard de administrador:', error);
    }
});

function setupAdminActionButtons() {
    // Botones de gestión de usuarios
    const userEditButtons = document.querySelectorAll('.users-table .btn-view');
    const userToggleButtons = document.querySelectorAll('.users-table .btn-cancel');
    
    userEditButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const userName = row.querySelector('.user-info strong').textContent;
            const userRole = row.querySelector('td:nth-child(2)').textContent;
            editUserRole(userName, userRole);
        });
    });
    
    userToggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const userName = row.querySelector('.user-info strong').textContent;
            const currentStatus = row.querySelector('.status-badge').textContent;
            toggleUserStatus(userName, currentStatus);
        });
    });
    
    // Botones de control de accesos
    const accessConfigButtons = document.querySelectorAll('.access-actions .btn-view');
    const accessUsersButtons = document.querySelectorAll('.access-actions .btn-cancel');
    
    accessConfigButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const accessCard = this.closest('.access-card');
            const roleName = accessCard.querySelector('h3').textContent;
            configureRolePermissions(roleName);
        });
    });
    
    accessUsersButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const accessCard = this.closest('.access-card');
            const roleName = accessCard.querySelector('h3').textContent;
            viewRoleUsers(roleName);
        });
    });
    
    // Botones de reportes
    const reportButtons = document.querySelectorAll('.reports-list .btn-view');
    reportButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const reportItem = this.closest('.report-item');
            const reportTitle = reportItem.querySelector('h4').textContent;
            viewReport(reportTitle);
        });
    });
}

function filterUsersAndReports(searchTerm) {
    // Filtrar usuarios en la tabla
    const userRows = document.querySelectorAll('.users-table tbody tr');
    let visibleUsers = 0;
    
    userRows.forEach(row => {
        const userName = row.querySelector('.user-info strong')?.textContent?.toLowerCase() || '';
        const userRole = row.querySelector('td:nth-child(2)')?.textContent?.toLowerCase() || '';
        const userDept = row.querySelector('td:nth-child(3)')?.textContent?.toLowerCase() || '';
        
        if (userName.includes(searchTerm) || userRole.includes(searchTerm) || userDept.includes(searchTerm)) {
            row.style.display = '';
            visibleUsers++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Filtrar reportes
    const reportItems = document.querySelectorAll('.report-item');
    let visibleReports = 0;
    
    reportItems.forEach(item => {
        const reportTitle = item.querySelector('h4')?.textContent?.toLowerCase() || '';
        
        if (reportTitle.includes(searchTerm)) {
            item.style.display = '';
            visibleReports++;
        } else {
            item.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleUsers} usuarios y ${visibleReports} reportes`);
}

function performAdminSearch(searchTerm) {
    if (searchTerm.trim() === '') return;
    
    console.log(`Realizando búsqueda de administrador: ${searchTerm}`);
    alert(`Buscando: "${searchTerm}"\nEsta funcionalidad buscaría en todos los registros de usuarios y configuraciones.`);
}

function showRoleFilters() {
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        z-index: 1000;
        max-width: 400px;
        width: 90%;
    `;
    
    modal.innerHTML = `
        <h3>Filtrar Usuarios por Rol</h3>
        <div style="margin: 15px 0;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-medicos" checked> Médicos
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-enfermeras" checked> Enfermeras
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-recepcionistas" checked> Recepcionistas
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-administradores"> Administradores
            </label>
        </div>
        <div style="margin: 15px 0;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-activos" checked> Solo Activos
            </label>
        </div>
        <button onclick="applyRoleFilters(this.parentElement)" style="
            background: #061175;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        ">Aplicar</button>
        <button onclick="this.parentElement.remove()" style="
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        ">Cancelar</button>
    `;
    
    document.body.appendChild(modal);
}

function applyRoleFilters(modal) {
    const medicosChecked = document.getElementById('filter-medicos').checked;
    const enfermerasChecked = document.getElementById('filter-enfermeras').checked;
    const recepcionistasChecked = document.getElementById('filter-recepcionistas').checked;
    const activosChecked = document.getElementById('filter-activos').checked;
    
    const userRows = document.querySelectorAll('.users-table tbody tr');
    userRows.forEach(row => {
        const userRole = row.querySelector('td:nth-child(2)').textContent;
        const userStatus = row.querySelector('.status-badge').textContent;
        
        let showRow = false;
        
        // Filtrar por rol
        if ((userRole === 'Médico' && medicosChecked) ||
            (userRole === 'Enfermera' && enfermerasChecked) ||
            (userRole === 'Recepcionista' && recepcionistasChecked)) {
            showRow = true;
        }
        
        // Filtrar por estado
        if (activosChecked && userStatus !== 'Activo') {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
    
    modal.remove();
}

function addNewUser() {
    console.log('Agregando nuevo usuario...');
    alert('Abriendo formulario para agregar nuevo usuario.\nSe podrá asignar rol, permisos y datos de acceso.');
}

function managePermissions() {
    console.log('Gestionando permisos del sistema...');
    alert('Abriendo panel de gestión de permisos.\nSe podrán configurar los niveles de acceso para cada rol.');
}

function showAccessLog() {
    console.log('Mostrando historial de accesos...');
    alert('Abriendo historial completo de accesos al sistema.\nSe mostrarán todos los inicios de sesión y acciones realizadas.');
}

function performBackup() {
    console.log('Realizando respaldo de datos...');
    if (confirm('¿Estás seguro de que quieres realizar un respaldo completo de la base de datos ahora?')) {
        alert('Iniciando respaldo de datos...\nEste proceso puede tomar varios minutos.\nLos usuarios pueden experimentar lentitud temporal.');
        // Simular progreso
        simulateBackupProgress();
    }
}

function scheduleBackup() {
    console.log('Programando respaldo de datos...');
    alert('Abriendo calendario para programar respaldo automático.\nSe podrá establecer frecuencia y hora preferida.');
}

function editUserRole(userName, currentRole) {
    console.log(`Editando rol de ${userName} (actual: ${currentRole})`);
    alert(`Editando rol de usuario: ${userName}\nRol actual: ${currentRole}\nSe abrirá formulario para modificar permisos y acceso.`);
}

function toggleUserStatus(userName, currentStatus) {
    console.log(`Cambiando estado de ${userName} (actual: ${currentStatus})`);
    const newStatus = currentStatus === 'Activo' ? 'Inactivo' : 'Activo';
    
    if (confirm(`¿${currentStatus === 'Activo' ? 'Desactivar' : 'Activar'} el usuario ${userName}?`)) {
        alert(`Usuario ${userName} ${currentStatus === 'Activo' ? 'desactivado' : 'activado'} correctamente.`);
        // En una implementación real, esto actualizaría el estado en la base de datos
    }
}

function configureRolePermissions(roleName) {
    console.log(`Configurando permisos para rol: ${roleName}`);
    alert(`Configurando permisos para: ${roleName}\nSe abrirá panel detallado de configuración de accesos.`);
}

function viewRoleUsers(roleName) {
    console.log(`Viendo usuarios del rol: ${roleName}`);
    alert(`Mostrando todos los usuarios con rol: ${roleName}\nSe filtrará la tabla de usuarios.`);
}

function viewReport(reportTitle) {
    console.log(`Viendo reporte: ${reportTitle}`);
    alert(`Abriendo reporte: ${reportTitle}\nSe mostrará en formato detallado con opciones de exportación.`);
}

function markNotificationsAsRead() {
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        notificationBadge.textContent = '0';
        notificationBadge.style.display = 'none';
    }
}

function simulateBackupProgress() {
    // Simular progreso de respaldo
    let progress = 0;
    const interval = setInterval(() => {
        progress += 10;
        console.log(`Progreso del respaldo: ${progress}%`);
        
        if (progress >= 100) {
            clearInterval(interval);
            alert('Respaldo completado exitosamente.\nLos datos han sido guardados en el servidor de respaldo.');
        }
    }, 500);
}

function simulateAdminRealTimeUpdates() {
    // Simular actualizaciones en tiempo real para administrador
    setInterval(() => {
        // Ocasionalmente agregar una nueva notificación del sistema
        if (Math.random() < 0.05) { // 5% de probabilidad cada intervalo
            addSystemNotification();
        }
    }, 45000); // Cada 45 segundos
}

function addSystemNotification() {
    const notificationBadge = document.querySelector('.notification-badge');
    if (!notificationBadge) return;
    
    const currentCount = parseInt(notificationBadge.textContent) || 0;
    notificationBadge.textContent = currentCount + 1;
    notificationBadge.style.display = 'flex';
    
    console.log('Nueva notificación del sistema agregada');
}

function logout() {
    console.log('Cerrando sesión de administrador...');
    localStorage.removeItem('adminLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const adminLoggedIn = localStorage.getItem('adminLoggedIn');
    if (!adminLoggedIn) {
        console.log('No hay sesión activa de administrador, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión de administrador activa');
    }
}

// Inicialización
checkSession();
console.log('Script administrador inicializado');