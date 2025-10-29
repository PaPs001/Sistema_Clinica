// script-agenda.js - Funcionalidades para Agenda Médica
console.log('Script de agenda cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Agenda');
    
    try {
        // Inicializar componentes
        initializeAgenda();
        setupEventListeners();
        loadAgendaData();
        
        console.log('Agenda inicializada correctamente');
        
    } catch (error) {
        console.error('Error al inicializar agenda:', error);
    }
});

function initializeAgenda() {
    // Configurar fecha actual
    updateCurrentDate();
    
    // Inicializar datos de ejemplo
    initializeSampleAppointments();
    
    // Configurar vista por defecto
    switchView('day');
}

function setupEventListeners() {
    // Navegación de fecha
    const prevDayBtn = document.getElementById('prev-day');
    const nextDayBtn = document.getElementById('next-day');
    const todayBtn = document.getElementById('today-btn');
    
    if (prevDayBtn) {
        prevDayBtn.addEventListener('click', navigateToPreviousDay);
    }
    
    if (nextDayBtn) {
        nextDayBtn.addEventListener('click', navigateToNextDay);
    }
    
    if (todayBtn) {
        todayBtn.addEventListener('click', navigateToToday);
    }
    
    // Cambio de vista
    const viewOptions = document.querySelectorAll('.view-option');
    viewOptions.forEach(option => {
        option.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            switchView(view);
        });
    });
    
    // Filtros
    const doctorFilter = document.getElementById('doctor-filter');
    const statusFilter = document.getElementById('status-filter');
    
    if (doctorFilter) {
        doctorFilter.addEventListener('change', applyFilters);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
    
    // Botón imprimir
    const printBtn = document.getElementById('print-agenda');
    if (printBtn) {
        printBtn.addEventListener('click', printAgenda);
    }
    
    // Citas clickeables
    setupAppointmentClickHandlers();
    
    // Modal de detalles
    const detailsModal = document.getElementById('appointment-details-modal');
    const closeModalBtn = detailsModal?.querySelector('.close-modal');
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            detailsModal.classList.remove('active');
        });
    }
    
    if (detailsModal) {
        detailsModal.addEventListener('click', function(e) {
            if (e.target === detailsModal) {
                detailsModal.classList.remove('active');
            }
        });
    }
    
    // Acciones del modal
    const editAppointmentBtn = document.getElementById('edit-appointment');
    const cancelAppointmentBtn = document.getElementById('cancel-appointment');
    const sendReminderBtn = document.getElementById('send-reminder');
    
    if (editAppointmentBtn) {
        editAppointmentBtn.addEventListener('click', editCurrentAppointment);
    }
    
    if (cancelAppointmentBtn) {
        cancelAppointmentBtn.addEventListener('click', cancelCurrentAppointment);
    }
    
    if (sendReminderBtn) {
        sendReminderBtn.addEventListener('click', sendReminderForCurrentAppointment);
    }
}

function setupAppointmentClickHandlers() {
    const appointmentCards = document.querySelectorAll('.appointment-card');
    appointmentCards.forEach(card => {
        card.addEventListener('click', function() {
            const appointmentData = getAppointmentDataFromCard(this);
            showAppointmentDetails(appointmentData);
        });
    });
}

function getAppointmentDataFromCard(card) {
    const slot = card.closest('.appointment-slot');
    const doctorColumn = card.closest('.doctor-column');
    
    return {
        time: slot.getAttribute('data-time'),
        patient: card.querySelector('.appointment-patient').textContent,
        doctor: doctorColumn.getAttribute('data-doctor'),
        room: doctorColumn.querySelector('.consultorio').textContent,
        type: card.classList[1], // consulta, control, emergencia
        status: card.querySelector('.appointment-status').textContent.toLowerCase()
    };
}

function updateCurrentDate() {
    const currentDateElement = document.getElementById('current-date');
    if (currentDateElement) {
        const today = new Date();
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        currentDateElement.textContent = today.toLocaleDateString('es-ES', options);
    }
}

function navigateToPreviousDay() {
    console.log('Navegando al día anterior');
    // En una implementación real, esto cargaría los datos del día anterior
    showToast('Cargando agenda del día anterior...', 'success');
}

function navigateToNextDay() {
    console.log('Navegando al día siguiente');
    // En una implementación real, esto cargaría los datos del día siguiente
    showToast('Cargando agenda del día siguiente...', 'success');
}

function navigateToToday() {
    console.log('Navegando a hoy');
    updateCurrentDate();
    showToast('Mostrando agenda de hoy', 'success');
}

function switchView(view) {
    console.log('Cambiando a vista:', view);
    
    // Remover clase active de todas las vistas y opciones
    document.querySelectorAll('.agenda-view').forEach(view => {
        view.classList.remove('active');
    });
    
    document.querySelectorAll('.view-option').forEach(option => {
        option.classList.remove('active');
    });
    
    // Activar vista seleccionada
    const targetView = document.querySelector(`.${view}-view`);
    const targetOption = document.querySelector(`[data-view="${view}"]`);
    
    if (targetView) {
        targetView.classList.add('active');
    }
    
    if (targetOption) {
        targetOption.classList.add('active');
    }
    
    // Cargar datos específicos de la vista
    loadViewData(view);
    
    showToast(`Vista cambiada a: ${getViewName(view)}`, 'success');
}

function getViewName(view) {
    const viewNames = {
        'day': 'Día',
        'week': 'Semana',
        'month': 'Mes'
    };
    return viewNames[view] || view;
}

function loadViewData(view) {
    console.log('Cargando datos para vista:', view);
    
    // Simular carga de datos
    const loadingSlots = document.querySelectorAll('.appointment-slot');
    loadingSlots.forEach(slot => {
        slot.classList.add('loading-slot');
    });
    
    setTimeout(() => {
        loadingSlots.forEach(slot => {
            slot.classList.remove('loading-slot');
        });
        
        // En una implementación real, aquí se cargarían los datos del servidor
        console.log('Datos cargados para vista:', view);
    }, 1000);
}

function applyFilters() {
    const doctorFilter = document.getElementById('doctor-filter').value;
    const statusFilter = document.getElementById('status-filter').value;
    
    console.log('Aplicando filtros - Médico:', doctorFilter, 'Estado:', statusFilter);
    
    const doctorColumns = document.querySelectorAll('.doctor-column');
    let visibleColumns = 0;
    let visibleAppointments = 0;
    
    doctorColumns.forEach(column => {
        const doctorName = column.getAttribute('data-doctor');
        let showColumn = true;
        
        // Filtrar por médico
        if (doctorFilter && doctorName !== doctorFilter) {
            showColumn = false;
        }
        
        // Filtrar citas dentro de la columna
        const appointments = column.querySelectorAll('.appointment-card');
        appointments.forEach(appointment => {
            const appointmentStatus = appointment.querySelector('.appointment-status').textContent.toLowerCase();
            const statusMap = {
                'confirmada': 'confirmada',
                'pendiente': 'pendiente',
                'en espera': 'en-consulta',
                'en consulta': 'en-consulta'
            };
            
            let showAppointment = true;
            
            if (statusFilter && statusMap[appointmentStatus] !== statusFilter) {
                showAppointment = false;
            }
            
            appointment.style.display = showAppointment ? 'block' : 'none';
            if (showAppointment) visibleAppointments++;
        });
        
        column.style.display = showColumn ? 'block' : 'none';
        if (showColumn) visibleColumns++;
    });
    
    console.log(`Mostrando ${visibleAppointments} citas en ${visibleColumns} columnas`);
    
    if (visibleAppointments === 0) {
        showToast('No se encontraron citas con los filtros aplicados', 'warning');
    } else {
        showToast(`Filtros aplicados: ${visibleAppointments} citas mostradas`, 'success');
    }
}

function showAppointmentDetails(appointmentData) {
    console.log('Mostrando detalles de cita:', appointmentData);
    
    // Llenar modal con datos
    document.getElementById('detail-patient-name').textContent = appointmentData.patient;
    document.getElementById('detail-patient-phone').textContent = '555-123-4567';
    document.getElementById('detail-patient-email').textContent = 'paciente@ejemplo.com';
    document.getElementById('detail-doctor').textContent = appointmentData.doctor;
    document.getElementById('detail-room').textContent = appointmentData.room;
    document.getElementById('detail-datetime').textContent = `${appointmentData.time} - ${document.getElementById('current-date').textContent}`;
    document.getElementById('detail-type').textContent = getAppointmentTypeName(appointmentData.type);
    document.getElementById('detail-status').textContent = appointmentData.status;
    
    // Almacenar datos actuales para las acciones
    window.currentAppointmentData = appointmentData;
    
    // Mostrar modal
    const modal = document.getElementById('appointment-details-modal');
    modal.classList.add('active');
}

function getAppointmentTypeName(type) {
    const typeNames = {
        'consulta': 'Consulta',
        'control': 'Control',
        'emergencia': 'Urgencia'
    };
    return typeNames[type] || type;
}

function editCurrentAppointment() {
    if (!window.currentAppointmentData) return;
    
    console.log('Editando cita:', window.currentAppointmentData);
    showToast(`Editando cita de ${window.currentAppointmentData.patient}`, 'success');
    
    // Cerrar modal
    document.getElementById('appointment-details-modal').classList.remove('active');
    
    // En una implementación real, redirigiría a la página de edición
}

function cancelCurrentAppointment() {
    if (!window.currentAppointmentData) return;
    
    const patientName = window.currentAppointmentData.patient;
    
    if (confirm(`¿Está seguro de que desea cancelar la cita de ${patientName}?`)) {
        console.log('Cancelando cita:', window.currentAppointmentData);
        
        // Simular cancelación
        showToast(`Cita de ${patientName} cancelada`, 'success');
        
        // Cerrar modal
        document.getElementById('appointment-details-modal').classList.remove('active');
        
        // En una implementación real, actualizaría la interfaz y la base de datos
    }
}

function sendReminderForCurrentAppointment() {
    if (!window.currentAppointmentData) return;
    
    const patientName = window.currentAppointmentData.patient;
    console.log('Enviando recordatorio para:', window.currentAppointmentData);
    
    showToast(`Recordatorio enviado a ${patientName}`, 'success');
}

function printAgenda() {
    console.log('Imprimiendo agenda...');
    showToast('Preparando agenda para impresión...', 'success');
    
    // Simular delay de impresión
    setTimeout(() => {
        // En una implementación real, abriría el diálogo de impresión
        window.print();
        showToast('Agenda enviada a impresión', 'success');
    }, 1000);
}

function loadAgendaData() {
    // En una implementación real, esto cargaría datos del servidor
    console.log('Cargando datos de agenda...');
}

function initializeSampleAppointments() {
    // Datos de ejemplo para demostración
    console.log('Inicializando citas de ejemplo para agenda');
}

// ===== FUNCIONES AUXILIARES =====

function showToast(message, type = 'success') {
    // Remover toast existente
    const existingToast = document.querySelector('.toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animación de entrada
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    // Auto-remover después de 3 segundos
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// ===== VERIFICACIÓN DE SESIÓN =====

function checkSession() {
    const recepcionistaLoggedIn = localStorage.getItem('recepcionistaLoggedIn');
    if (!recepcionistaLoggedIn) {
        console.log('No hay sesión activa de recepcionista');
        // window.location.href = 'index.html';
    }
}

// Inicialización
checkSession();
console.log('Script de agenda completamente cargado');