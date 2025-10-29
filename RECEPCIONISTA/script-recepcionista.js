// script-recepcionista.js - Versión mejorada para recepcionista
console.log('Script recepcionista mejorado cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Recepcionista');
    
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

        // Buscador mejorado para recepcionista
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterAppointmentsAndPatients(searchTerm);
            });
            
            // Agregar funcionalidad de búsqueda con Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performReceptionSearch(this.value);
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
        setupReceptionActionButtons();

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

        // Botones específicos para recepcionista
        const filterAppointmentsBtn = document.getElementById('filter-appointments');
        const exportScheduleBtn = document.getElementById('export-schedule');
        const callNextBtn = document.getElementById('call-next');
        const refreshWaitingBtn = document.getElementById('refresh-waiting');
        
        if (filterAppointmentsBtn) {
            filterAppointmentsBtn.addEventListener('click', showAppointmentFilters);
        }
        
        if (exportScheduleBtn) {
            exportScheduleBtn.addEventListener('click', exportDailySchedule);
        }
        
        if (callNextBtn) {
            callNextBtn.addEventListener('click', callNextPatient);
        }
        
        if (refreshWaitingBtn) {
            refreshWaitingBtn.addEventListener('click', refreshWaitingList);
        }

        // Simular actualizaciones en tiempo real (para demo)
        simulateReceptionRealTimeUpdates();

        console.log('Todos los event listeners configurados correctamente para recepcionista');
        
    } catch (error) {
        console.error('Error al configurar el dashboard de recepcionista:', error);
    }
});

function setupReceptionActionButtons() {
    // Botones de citas
    const appointmentButtons = document.querySelectorAll('.appointments-table .btn-view');
    const rescheduleButtons = document.querySelectorAll('.appointments-table .btn-cancel');
    
    appointmentButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            const action = this.textContent.toLowerCase();
            handleAppointmentAction(patientName, action);
        });
    });
    
    rescheduleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            rescheduleAppointment(patientName);
        });
    });
    
    // Botones de pacientes en espera
    const waitingAttendButtons = document.querySelectorAll('.waiting-actions .btn-view');
    const waitingDelayButtons = document.querySelectorAll('.waiting-actions .btn-cancel');
    
    waitingAttendButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const waitingCard = this.closest('.waiting-card');
            const patientName = waitingCard.querySelector('h3').textContent;
            attendWaitingPatient(patientName);
        });
    });
    
    waitingDelayButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const waitingCard = this.closest('.waiting-card');
            const patientName = waitingCard.querySelector('h3').textContent;
            informDelay(patientName);
        });
    });
    
    // Botones de nuevos pacientes
    const registerButtons = document.querySelectorAll('.new-patients-list .btn-view');
    registerButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const patientItem = this.closest('.patient-item');
            const patientName = patientItem.querySelector('h4').textContent.split(' - ')[0];
            registerNewPatient(patientName);
        });
    });
    
    // Botones de llamadas
    const callButtons = document.querySelectorAll('.calls-list .btn-view');
    callButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const callItem = this.closest('.call-item');
            const callTitle = callItem.querySelector('h4').textContent;
            makePhoneCall(callTitle);
        });
    });
}

function filterAppointmentsAndPatients(searchTerm) {
    // Filtrar citas en la tabla
    const appointmentRows = document.querySelectorAll('.appointments-table tbody tr');
    let visibleAppointments = 0;
    
    appointmentRows.forEach(row => {
        const patientName = row.querySelector('.patient-info strong')?.textContent?.toLowerCase() || '';
        const doctorName = row.querySelector('td:nth-child(3)')?.textContent?.toLowerCase() || '';
        
        if (patientName.includes(searchTerm) || doctorName.includes(searchTerm)) {
            row.style.display = '';
            visibleAppointments++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Filtrar pacientes en espera
    const waitingCards = document.querySelectorAll('.waiting-card');
    let visibleWaiting = 0;
    
    waitingCards.forEach(card => {
        const patientName = card.querySelector('h3')?.textContent?.toLowerCase() || '';
        const doctorName = card.querySelector('strong')?.textContent?.toLowerCase() || '';
        
        if (patientName.includes(searchTerm) || doctorName.includes(searchTerm)) {
            card.style.display = '';
            visibleWaiting++;
        } else {
            card.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleAppointments} citas y ${visibleWaiting} pacientes en espera`);
}

function performReceptionSearch(searchTerm) {
    if (searchTerm.trim() === '') return;
    
    console.log(`Realizando búsqueda de recepcionista: ${searchTerm}`);
    alert(`Buscando: "${searchTerm}"\nEsta funcionalidad buscaría en citas, pacientes y registros de recepción.`);
}

function showAppointmentFilters() {
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
        <h3>Filtrar Citas</h3>
        <div style="margin: 15px 0;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-confirmed" checked> Confirmadas
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-waiting" checked> En espera
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-in-progress" checked> En consulta
            </label>
        </div>
        <div style="margin: 15px 0;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-urgent"> Solo Urgentes
            </label>
        </div>
        <button onclick="applyAppointmentFilters(this.parentElement)" style="
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

function applyAppointmentFilters(modal) {
    const confirmedChecked = document.getElementById('filter-confirmed').checked;
    const waitingChecked = document.getElementById('filter-waiting').checked;
    const inProgressChecked = document.getElementById('filter-in-progress').checked;
    
    const appointmentRows = document.querySelectorAll('.appointments-table tbody tr');
    appointmentRows.forEach(row => {
        const status = row.querySelector('.status-badge').textContent.toLowerCase();
        
        let showRow = false;
        
        if ((status.includes('confirmada') && confirmedChecked) ||
            (status.includes('espera') && waitingChecked) ||
            (status.includes('consulta') && inProgressChecked)) {
            showRow = true;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
    
    modal.remove();
}

function exportDailySchedule() {
    console.log('Exportando agenda del día...');
    alert('Generando reporte de agenda diaria en formato PDF...\nEste reporte incluirá todas las citas programadas para hoy.');
}

function callNextPatient() {
    console.log('Llamando al siguiente paciente...');
    // Encontrar el primer paciente en espera
    const firstWaitingCard = document.querySelector('.waiting-card');
    if (firstWaitingCard) {
        const patientName = firstWaitingCard.querySelector('h3').textContent;
        const doctorName = firstWaitingCard.querySelector('strong').textContent;
        const room = firstWaitingCard.querySelector('.waiting-details p:nth-child(2) strong').textContent;
        
        // Simular llamada por altavoz
        simulateAnnouncement(patientName, doctorName, room);
        
        // Mover a "En consulta"
        moveToInProgress(firstWaitingCard);
    } else {
        alert('No hay pacientes en espera en este momento.');
    }
}

function refreshWaitingList() {
    console.log('Actualizando lista de espera...');
    // En una implementación real, esto obtendría datos actualizados del servidor
    alert('Lista de espera actualizada.\nSe sincronizaron los tiempos de espera y estados.');
}

function handleAppointmentAction(patientName, action) {
    console.log(`${action} cita para ${patientName}`);
    
    switch(action) {
        case 'llegada':
            markPatientArrival(patientName);
            break;
        case 'detalles':
            showAppointmentDetails(patientName);
            break;
        case 'llamar':
            callPatient(patientName);
            break;
        default:
            alert(`Acción: ${action} para ${patientName}`);
    }
}

function rescheduleAppointment(patientName) {
    console.log(`Reagendando cita para ${patientName}`);
    alert(`Reagendando cita para: ${patientName}\nSe abrirá el calendario para seleccionar nueva fecha y hora.`);
}

function attendWaitingPatient(patientName) {
    console.log(`Atendiendo a paciente en espera: ${patientName}`);
    alert(`Atendiendo a: ${patientName}\nEl paciente será dirigido al consultorio correspondiente.`);
}

function informDelay(patientName) {
    console.log(`Informando demora a: ${patientName}`);
    alert(`Informando demora a: ${patientName}\nSe notificará al paciente sobre el tiempo de espera estimado.`);
}

function registerNewPatient(patientName) {
    console.log(`Registrando nuevo paciente: ${patientName}`);
    alert(`Registrando nuevo paciente: ${patientName}\nSe abrirá formulario de registro de expediente digital.`);
}

function makePhoneCall(callTitle) {
    console.log(`Realizando llamada: ${callTitle}`);
    alert(`Realizando llamada: ${callTitle}\nSe conectará con el paciente para confirmar cita/resultados.`);
}

function markPatientArrival(patientName) {
    console.log(`Marcando llegada de: ${patientName}`);
    alert(`Llegada registrada para: ${patientName}\nEl paciente ha sido agregado a la lista de espera.`);
}

function showAppointmentDetails(patientName) {
    console.log(`Mostrando detalles de cita de: ${patientName}`);
    alert(`Mostrando detalles completos de la cita para: ${patientName}`);
}

function callPatient(patientName) {
    console.log(`Llamando a: ${patientName}`);
    alert(`Llamando a: ${patientName}\nSe notificará al paciente que el médico está listo.`);
}

function simulateAnnouncement(patientName, doctorName, room) {
    // Simular anuncio por altavoz
    const announcement = `Atención por favor. ${patientName}, favor dirigirse al consultorio ${room} con el ${doctorName}.`;
    console.log(`Anuncio: ${announcement}`);
    alert(`🔊 ANUNCIO:\n\n"${announcement}"`);
}

function moveToInProgress(waitingCard) {
    // Simular movimiento de paciente de "espera" a "en consulta"
    waitingCard.style.opacity = '0.5';
    setTimeout(() => {
        waitingCard.remove();
        // Actualizar contador de espera
        updateWaitingCount();
    }, 2000);
}

function updateWaitingCount() {
    const waitingCount = document.querySelectorAll('.waiting-card').length;
    const waitingStat = document.querySelector('.stat-card:nth-child(3) h3');
    if (waitingStat) {
        waitingStat.textContent = waitingCount;
    }
}

function markNotificationsAsRead() {
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        notificationBadge.textContent = '0';
        notificationBadge.style.display = 'none';
    }
}

function simulateReceptionRealTimeUpdates() {
    // Simular actualizaciones en tiempo real para recepcionista
    setInterval(() => {
        // Ocasionalmente agregar un nuevo paciente en espera (solo en demo)
        if (Math.random() < 0.08) { // 8% de probabilidad cada intervalo
            addDemoWaitingPatient();
        }
        
        // Ocasionalmente agregar una nueva llamada pendiente
        if (Math.random() < 0.06) { // 6% de probabilidad cada intervalo
            addDemoPendingCall();
        }
    }, 30000); // Cada 30 segundos
}

function addDemoWaitingPatient() {
    const waitingGrid = document.querySelector('.waiting-grid');
    if (!waitingGrid) return;
    
    const demoPatients = ['Pedro Martínez', 'Lucía Hernández', 'Jorge Ramírez', 'Isabel Castro'];
    const demoDoctors = ['Dra. Elena Morales', 'Dr. Roberto Silva', 'Dr. Carlos Mendoza'];
    const demoRooms = ['405', '208', '301', '102'];
    const demoReasons = ['Control rutinario', 'Dolor de cabeza', 'Revisión de resultados', 'Consulta general'];
    
    const randomPatient = demoPatients[Math.floor(Math.random() * demoPatients.length)];
    const randomDoctor = demoDoctors[Math.floor(Math.random() * demoDoctors.length)];
    const randomRoom = demoRooms[Math.floor(Math.random() * demoRooms.length)];
    const randomReason = demoReasons[Math.floor(Math.random() * demoReasons.length)];
    const isUrgent = Math.random() < 0.3; // 30% de probabilidad de ser urgente
    
    const waitingCard = document.createElement('div');
    waitingCard.className = `waiting-card ${isUrgent ? 'urgent' : ''}`;
    waitingCard.innerHTML = `
        <div class="waiting-header">
            <h3>${randomPatient}</h3>
            <span class="waiting-badge">${isUrgent ? 'Urgente' : 'Normal'}</span>
        </div>
        <div class="waiting-details">
            <p><i class="fas fa-user-md"></i> <strong>Médico:</strong> ${randomDoctor}</p>
            <p><i class="fas fa-door-open"></i> <strong>Consultorio:</strong> ${randomRoom}</p>
            <p><i class="fas fa-clock"></i> <strong>Tiempo de espera:</strong> 0 min</p>
            <p><i class="fas fa-stethoscope"></i> <strong>Motivo:</strong> ${randomReason}</p>
        </div>
        <div class="waiting-actions">
            <button class="btn-view">Atender</button>
            <button class="btn-cancel">Informar Demora</button>
        </div>
    `;
    
    // Agregar event listeners a los nuevos botones
    waitingCard.querySelector('.btn-view').addEventListener('click', function() {
        attendWaitingPatient(randomPatient);
    });
    
    waitingCard.querySelector('.btn-cancel').addEventListener('click', function() {
        informDelay(randomPatient);
    });
    
    waitingGrid.appendChild(waitingCard);
    
    // Actualizar contador de espera
    updateWaitingCount();
    
    // Actualizar badge de notificaciones
    const notificationBadge = document.querySelector('.notification-badge');
    if (notificationBadge) {
        const currentCount = parseInt(notificationBadge.textContent) || 0;
        notificationBadge.textContent = currentCount + 1;
        notificationBadge.style.display = 'flex';
    }
    
    console.log('Nuevo paciente en espera demo agregado');
}

function addDemoPendingCall() {
    const callsList = document.querySelector('.calls-list');
    if (!callsList) return;
    
    const demoPatients = ['Ana López', 'Carlos Ruiz', 'Miguel Torres', 'Laura García'];
    const demoCallTypes = ['Recordatorio de cita', 'Confirmación de cita', 'Resultados de análisis', 'Cambio de cita'];
    
    const randomPatient = demoPatients[Math.floor(Math.random() * demoPatients.length)];
    const randomCallType = demoCallTypes[Math.floor(Math.random() * demoCallTypes.length)];
    
    const callItem = document.createElement('div');
    callItem.className = 'call-item';
    callItem.innerHTML = `
        <div class="call-icon">
            <i class="fas fa-phone-volume"></i>
        </div>
        <div class="call-details">
            <h4>${randomCallType} - ${randomPatient}</h4>
            <p><i class="fas fa-calendar"></i> Cita próxima</p>
            <p><i class="fas fa-clock"></i> Pendiente desde: ${new Date().toLocaleTimeString()}</p>
        </div>
        <button class="btn-view">Llamar</button>
    `;
    
    // Agregar event listener al botón de llamada
    callItem.querySelector('.btn-view').addEventListener('click', function() {
        makePhoneCall(`${randomCallType} - ${randomPatient}`);
    });
    
    callsList.appendChild(callItem);
    
    console.log('Nueva llamada pendiente demo agregada');
}

function logout() {
    console.log('Cerrando sesión de recepcionista...');
    localStorage.removeItem('recepcionistaLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const recepcionistaLoggedIn = localStorage.getItem('recepcionistaLoggedIn');
    if (!recepcionistaLoggedIn) {
        console.log('No hay sesión activa de recepcionista, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión de recepcionista activa');
    }
}

// Inicialización
checkSession();
console.log('Script recepcionista inicializado');