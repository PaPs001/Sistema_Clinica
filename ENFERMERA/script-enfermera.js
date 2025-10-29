// script-enfermera.js - Versión mejorada para enfermera
console.log('Script enfermera mejorado cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Enfermera');
    
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

        // Buscador mejorado para enfermera
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterPatientsAndAlerts(searchTerm);
            });
            
            // Agregar funcionalidad de búsqueda con Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performNurseSearch(this.value);
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
        setupNurseActionButtons();

        // Logout
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                    logout();
                }
            });
        }

        // Botones de filtro y exportación específicos para enfermera
        const filterAlertsBtn = document.getElementById('filter-alerts');
        const markAllReadBtn = document.getElementById('mark-all-read');
        const filterPatientsBtn = document.getElementById('filter-patients');
        const exportPatientsBtn = document.getElementById('export-patients');
        
        if (filterAlertsBtn) {
            filterAlertsBtn.addEventListener('click', showAlertFilters);
        }
        
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', markAllAlertsAsRead);
        }
        
        if (filterPatientsBtn) {
            filterPatientsBtn.addEventListener('click', showPatientFilters);
        }
        
        if (exportPatientsBtn) {
            exportPatientsBtn.addEventListener('click', exportPatientReport);
        }

        // Simular actualizaciones en tiempo real (para demo)
        simulateRealTimeUpdates();

        console.log('Todos los event listeners configurados correctamente para enfermera');
        
    } catch (error) {
        console.error('Error al configurar el dashboard de enfermera:', error);
    }
});

function setupNurseActionButtons() {
    // Botones de alertas
    const alertViewButtons = document.querySelectorAll('.alert-actions .btn-view');
    const alertCancelButtons = document.querySelectorAll('.alert-actions .btn-cancel');
    
    alertViewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const alertCard = this.closest('.alert-card');
            const patientName = alertCard.querySelector('strong').textContent;
            const alertType = alertCard.querySelector('h3').textContent;
            attendToAlert(patientName, alertType);
        });
    });
    
    alertCancelButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const alertCard = this.closest('.alert-card');
            const patientName = alertCard.querySelector('strong').textContent;
            postponeAlert(patientName);
        });
    });
    
    // Botones de pacientes
    const patientSignosButtons = document.querySelectorAll('.patients-table .btn-view');
    const patientMedicarButtons = document.querySelectorAll('.patients-table .btn-cancel');
    
    patientSignosButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            recordVitalSigns(patientName);
        });
    });
    
    patientMedicarButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            administerMedication(patientName);
        });
    });
    
    // Botones de tareas
    const taskButtons = document.querySelectorAll('.tasks-list .btn-view');
    taskButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const taskItem = this.closest('.task-item');
            const taskTitle = taskItem.querySelector('h4').textContent;
            handleTaskAction(taskItem, taskTitle);
        });
    });
}

function filterPatientsAndAlerts(searchTerm) {
    // Filtrar pacientes en la tabla
    const patientRows = document.querySelectorAll('.patients-table tbody tr');
    let visiblePatients = 0;
    
    patientRows.forEach(row => {
        const patientName = row.querySelector('.patient-info strong')?.textContent?.toLowerCase() || '';
        const room = row.querySelector('td:nth-child(2)')?.textContent?.toLowerCase() || '';
        
        if (patientName.includes(searchTerm) || room.includes(searchTerm)) {
            row.style.display = '';
            visiblePatients++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Filtrar alertas
    const alertCards = document.querySelectorAll('.alert-card');
    let visibleAlerts = 0;
    
    alertCards.forEach(card => {
        const patientName = card.querySelector('strong')?.textContent?.toLowerCase() || '';
        const alertType = card.querySelector('h3')?.textContent?.toLowerCase() || '';
        
        if (patientName.includes(searchTerm) || alertType.includes(searchTerm)) {
            card.style.display = '';
            visibleAlerts++;
        } else {
            card.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visiblePatients} pacientes y ${visibleAlerts} alertas`);
}

function performNurseSearch(searchTerm) {
    if (searchTerm.trim() === '') return;
    
    console.log(`Realizando búsqueda de enfermera: ${searchTerm}`);
    // En una implementación real, esto buscaría en pacientes, tratamientos, medicamentos, etc.
    alert(`Buscando: "${searchTerm}"\nEsta funcionalidad buscaría en todos los registros de pacientes y procedimientos.`);
}

function showAlertFilters() {
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
        <h3>Filtrar Alertas</h3>
        <div style="margin: 15px 0;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-critical" checked> Alertas Críticas
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-warning" checked> Alertas de Advertencia
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-urgent"> Solo Urgentes
            </label>
        </div>
        <button onclick="applyAlertFilters(this.parentElement)" style="
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

function applyAlertFilters(modal) {
    const criticalChecked = document.getElementById('filter-critical').checked;
    const warningChecked = document.getElementById('filter-warning').checked;
    
    const alertCards = document.querySelectorAll('.alert-card');
    alertCards.forEach(card => {
        if (card.classList.contains('critical') && !criticalChecked) {
            card.style.display = 'none';
        } else if (card.classList.contains('warning') && !warningChecked) {
            card.style.display = 'none';
        } else {
            card.style.display = '';
        }
    });
    
    modal.remove();
}

function markAllAlertsAsRead() {
    const alertCards = document.querySelectorAll('.alert-card');
    let markedCount = 0;
    
    alertCards.forEach(card => {
        if (card.style.display !== 'none') {
            card.style.opacity = '0.6';
            markedCount++;
        }
    });
    
    // Actualizar badge de notificaciones
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        const currentCount = parseInt(notificationBadge.textContent);
        const newCount = Math.max(0, currentCount - markedCount);
        notificationBadge.textContent = newCount;
        
        if (newCount === 0) {
            notificationBadge.style.display = 'none';
        }
    }
    
    alert(`Se marcaron ${markedCount} alertas como leídas`);
}

function showPatientFilters() {
    // Similar a showAlertFilters pero para pacientes
    alert('Funcionalidad de filtro de pacientes - Se abriría un modal para filtrar por condición, habitación, etc.');
}

function exportPatientReport() {
    console.log('Exportando reporte de pacientes...');
    alert('Generando reporte de pacientes en formato PDF...\nEste reporte incluiría la lista de pacientes activos con sus signos vitales y tratamientos.');
}

function attendToAlert(patientName, alertType) {
    console.log(`Atendiendo alerta: ${alertType} para ${patientName}`);
    // En una implementación real, esto marcaría la alerta como atendida
    alert(`Atendiendo a ${patientName}\nAlerta: ${alertType}\nSe registrará la atención en el sistema.`);
}

function postponeAlert(patientName) {
    console.log(`Posponiendo alerta para ${patientName}`);
    if (confirm(`¿Posponer la alerta para ${patientName} por 30 minutos?`)) {
        alert(`Alerta para ${patientName} pospuesta por 30 minutos.`);
        // En una implementación real, esto reprogramaría la alerta
    }
}

function recordVitalSigns(patientName) {
    console.log(`Registrando signos vitales para ${patientName}`);
    // Simular redirección a página de signos vitales
    alert(`Redirigiendo a registro de signos vitales para ${patientName}`);
    // window.location.href = `signos-vitales.html?patient=${encodeURIComponent(patientName)}`;
}

function administerMedication(patientName) {
    console.log(`Administrando medicación a ${patientName}`);
    // Simular redirección a página de medicamentos
    alert(`Redirigiendo a administración de medicamentos para ${patientName}`);
    // window.location.href = `medicamentos.html?patient=${encodeURIComponent(patientName)}`;
}

function handleTaskAction(taskItem, taskTitle) {
    if (taskItem.classList.contains('completed')) {
        // Ver tarea completada
        alert(`Viendo detalles de tarea completada: ${taskTitle}`);
    } else if (taskItem.classList.contains('urgent')) {
        // Realizar tarea urgente
        if (confirm(`¿Marcar como realizada: ${taskTitle}?`)) {
            taskItem.classList.remove('urgent');
            taskItem.classList.add('completed');
            taskItem.querySelector('.task-status').textContent = 'Completado';
            taskItem.querySelector('.task-status').className = 'task-status completed';
            alert(`Tarea "${taskTitle}" marcada como completada.`);
        }
    } else {
        // Registrar tarea normal
        alert(`Registrando: ${taskTitle}`);
        // En una implementación real, esto abriría un formulario de registro
    }
}

function markNotificationsAsRead() {
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        notificationBadge.textContent = '0';
        notificationBadge.style.display = 'none';
    }
}

function simulateRealTimeUpdates() {
    // Simular actualizaciones en tiempo real (solo para demo)
    setInterval(() => {
        // Ocasionalmente agregar una nueva alerta (solo en demo)
        if (Math.random() < 0.1) { // 10% de probabilidad cada intervalo
            addDemoAlert();
        }
    }, 30000); // Cada 30 segundos
}

function addDemoAlert() {
    const alertsGrid = document.querySelector('.alerts-grid');
    if (!alertsGrid) return;
    
    const demoPatients = ['Juan Pérez', 'María Rodríguez', 'Luis García'];
    const demoAlerts = [
        { type: 'warning', title: 'Temperatura Elevada', reading: '38.5°C' },
        { type: 'critical', title: 'Frecuencia Cardíaca Alta', reading: '120 lpm' },
        { type: 'warning', title: 'Presión Baja', reading: '90/60 mmHg' }
    ];
    
    const randomPatient = demoPatients[Math.floor(Math.random() * demoPatients.length)];
    const randomAlert = demoAlerts[Math.floor(Math.random() * demoAlerts.length)];
    const randomRoom = Math.floor(Math.random() * 400) + 100;
    
    const alertCard = document.createElement('div');
    alertCard.className = `alert-card ${randomAlert.type}`;
    alertCard.innerHTML = `
        <div class="alert-header">
            <h3>${randomAlert.title}</h3>
            <span class="alert-badge">${randomAlert.type === 'critical' ? 'Urgente' : 'Alta'}</span>
        </div>
        <div class="alert-details">
            <p><i class="fas fa-user-injured"></i> <strong>Paciente:</strong> ${randomPatient} - Hab. ${randomRoom}</p>
            <p><i class="fas fa-heartbeat"></i> <strong>Lectura:</strong> ${randomAlert.reading}</p>
            <p><i class="fas fa-clock"></i> <strong>Hora:</strong> ${new Date().toLocaleTimeString()}</p>
        </div>
        <div class="alert-actions">
            <button class="btn-view">Atender</button>
            <button class="btn-cancel">Posponer</button>
        </div>
    `;
    
    // Agregar event listeners a los nuevos botones
    alertCard.querySelector('.btn-view').addEventListener('click', function() {
        attendToAlert(randomPatient, randomAlert.title);
    });
    
    alertCard.querySelector('.btn-cancel').addEventListener('click', function() {
        postponeAlert(randomPatient);
    });
    
    alertsGrid.appendChild(alertCard);
    
    // Actualizar badge de notificaciones
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        const currentCount = parseInt(notificationBadge.textContent) || 0;
        notificationBadge.textContent = currentCount + 1;
        notificationBadge.style.display = 'flex';
    }
    
    console.log('Nueva alerta demo agregada');
}

function logout() {
    console.log('Cerrando sesión de enfermera...');
    localStorage.removeItem('enfermeraLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const enfermeraLoggedIn = localStorage.getItem('enfermeraLoggedIn');
    if (!enfermeraLoggedIn) {
        console.log('No hay sesión activa de enfermera, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión de enfermera activa');
    }
}

// Inicialización
checkSession();
console.log('Script enfermera inicializado');