// script-recordatorios.js - Funcionalidades para Gestión de Recordatorios
console.log('Script de recordatorios cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Recordatorios');
    
    try {
        // Inicializar componentes
        initializeRemindersManagement();
        setupEventListeners();
        loadRemindersData();
        
        console.log('Gestión de recordatorios inicializada correctamente');
        
    } catch (error) {
        console.error('Error al inicializar gestión de recordatorios:', error);
    }
});

function initializeRemindersManagement() {
    // Configurar contador de caracteres para SMS
    const messageTextarea = document.getElementById('reminder-message');
    if (messageTextarea) {
        messageTextarea.addEventListener('input', updateCharacterCount);
    }
    
    // Inicializar datos de ejemplo
    initializeSampleReminders();
    
    // Configurar selección múltiple
    setupBulkSelection();
}

function setupEventListeners() {
    // Botón nuevo recordatorio
    const newReminderBtn = document.getElementById('new-reminder-btn');
    if (newReminderBtn) {
        newReminderBtn.addEventListener('click', showNewReminderModal);
    }
    
    // Filtros
    const applyFiltersBtn = document.getElementById('apply-filters');
    const resetFiltersBtn = document.getElementById('reset-filters');
    
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyReminderFilters);
    }
    
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', resetReminderFilters);
    }
    
    // Búsqueda
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', searchReminders);
    }
    
    // Acciones masivas
    const sendBulkBtn = document.getElementById('send-bulk-reminders');
    const scheduleBulkBtn = document.getElementById('schedule-reminders');
    const deleteBulkBtn = document.getElementById('delete-reminders');
    
    if (sendBulkBtn) {
        sendBulkBtn.addEventListener('click', sendBulkReminders);
    }
    
    if (scheduleBulkBtn) {
        scheduleBulkBtn.addEventListener('click', scheduleBulkReminders);
    }
    
    if (deleteBulkBtn) {
        deleteBulkBtn.addEventListener('click', deleteBulkReminders);
    }
    
    // Botones de acción individuales
    setupIndividualActions();
    
    // Botones de exportar y actualizar
    const exportRemindersBtn = document.getElementById('export-reminders');
    const refreshRemindersBtn = document.getElementById('refresh-reminders');
    
    if (exportRemindersBtn) {
        exportRemindersBtn.addEventListener('click', exportRemindersData);
    }
    
    if (refreshRemindersBtn) {
        refreshRemindersBtn.addEventListener('click', refreshRemindersList);
    }
    
    // Plantillas
    const useTemplateBtns = document.querySelectorAll('.btn-use-template');
    useTemplateBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const templateCard = this.closest('.template-card');
            const templateName = templateCard.querySelector('h4').textContent;
            useTemplate(templateName);
        });
    });
    
    // Modal de nuevo recordatorio
    const newReminderModal = document.getElementById('new-reminder-modal');
    const closeModalBtn = newReminderModal?.querySelector('.close-modal');
    const cancelReminderBtn = document.getElementById('cancel-reminder');
    const sendNowBtn = document.getElementById('send-now-btn');
    const newReminderForm = document.getElementById('new-reminder-form');
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            newReminderModal.classList.remove('active');
        });
    }
    
    if (cancelReminderBtn) {
        cancelReminderBtn.addEventListener('click', function() {
            newReminderModal.classList.remove('active');
        });
    }
    
    if (sendNowBtn) {
        sendNowBtn.addEventListener('click', function() {
            if (validateReminderForm()) {
                sendReminderImmediately();
            }
        });
    }
    
    if (newReminderForm) {
        newReminderForm.addEventListener('submit', handleNewReminderSubmit);
    }
    
    if (newReminderModal) {
        newReminderModal.addEventListener('click', function(e) {
            if (e.target === newReminderModal) {
                newReminderModal.classList.remove('active');
            }
        });
    }
    
    // Cambios en el formulario
    const channelSelect = document.getElementById('reminder-channel-select');
    if (channelSelect) {
        channelSelect.addEventListener('change', updateChannelRestrictions);
    }
    
    // Paginación
    setupPagination();
}

function setupBulkSelection() {
    const reminderCheckboxes = document.querySelectorAll('.reminder-select');
    
    reminderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.reminder-card');
            if (this.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
            
            updateBulkActionsState();
        });
    });
}

function updateBulkActionsState() {
    const checkedCount = document.querySelectorAll('.reminder-select:checked').length;
    const bulkButtons = document.querySelectorAll('.bulk-actions .section-btn');
    
    bulkButtons.forEach(btn => {
        if (checkedCount > 0) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });
}

function setupIndividualActions() {
    // Botones de enviar
    const sendButtons = document.querySelectorAll('.btn-send');
    sendButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.reminder-card');
            sendReminderNow(card);
        });
    });
    
    // Botones de editar
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.reminder-card');
            editReminder(card);
        });
    });
    
    // Botones de cancelar
    const cancelButtons = document.querySelectorAll('.btn-cancel');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.reminder-card');
            cancelReminder(card);
        });
    });
    
    // Botones de ver
    const viewButtons = document.querySelectorAll('.btn-view');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.reminder-card');
            viewReminderDetails(card);
        });
    });
    
    // Botones de reenviar
    const resendButtons = document.querySelectorAll('.btn-resend');
    resendButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.reminder-card');
            resendReminder(card);
        });
    });
    
    // Botones de reintentar
    const retryButtons = document.querySelectorAll('.btn-retry');
    retryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.reminder-card');
            retryReminder(card);
        });
    });
}

function setupPagination() {
    const paginationBtns = document.querySelectorAll('.pagination-btn:not(:disabled)');
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('active')) return;
            
            // Remover clase active de todos los botones
            document.querySelectorAll('.pagination-btn').forEach(b => {
                b.classList.remove('active');
            });
            
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Simular cambio de página
            const pageNumber = this.textContent.trim();
            if (!isNaN(pageNumber) || pageNumber.includes('...')) {
                loadPage(parseInt(pageNumber) || 1);
            } else if (this.querySelector('.fa-chevron-right')) {
                loadNextPage();
            } else if (this.querySelector('.fa-chevron-left')) {
                loadPreviousPage();
            }
        });
    });
}

function showNewReminderModal() {
    const modal = document.getElementById('new-reminder-modal');
    if (modal) {
        modal.classList.add('active');
        
        // Resetear formulario
        document.getElementById('new-reminder-form').reset();
        updateCharacterCount();
    }
}

function updateCharacterCount() {
    const messageTextarea = document.getElementById('reminder-message');
    const charCount = document.getElementById('char-count');
    const smsWarning = document.getElementById('sms-warning');
    const channelSelect = document.getElementById('reminder-channel-select');
    
    if (messageTextarea && charCount) {
        const count = messageTextarea.value.length;
        charCount.textContent = count;
        
        // Mostrar advertencia para SMS
        if (channelSelect && channelSelect.value === 'sms' && count > 160) {
            smsWarning.style.display = 'inline';
            smsWarning.style.color = 'var(--danger-color)';
        } else {
            smsWarning.style.display = 'inline';
            smsWarning.style.color = 'var(--warning-color)';
        }
    }
}

function updateChannelRestrictions() {
    const channelSelect = document.getElementById('reminder-channel-select');
    const messageTextarea = document.getElementById('reminder-message');
    
    if (channelSelect && messageTextarea) {
        if (channelSelect.value === 'sms') {
            messageTextarea.maxLength = 160;
            messageTextarea.placeholder = 'Escriba el mensaje SMS (máximo 160 caracteres)...';
        } else {
            messageTextarea.removeAttribute('maxLength');
            messageTextarea.placeholder = 'Escriba el mensaje del recordatorio...';
        }
        updateCharacterCount();
    }
}

function validateReminderForm() {
    const typeSelect = document.getElementById('reminder-type-select');
    const channelSelect = document.getElementById('reminder-channel-select');
    const scheduleSelect = document.getElementById('reminder-schedule');
    const messageTextarea = document.getElementById('reminder-message');
    
    let isValid = true;
    
    if (!typeSelect.value) {
        showFieldError(typeSelect, 'Seleccione el tipo de recordatorio');
        isValid = false;
    } else {
        clearFieldError(typeSelect);
    }
    
    if (!channelSelect.value) {
        showFieldError(channelSelect, 'Seleccione el canal de envío');
        isValid = false;
    } else {
        clearFieldError(channelSelect);
    }
    
    if (!scheduleSelect.value) {
        showFieldError(scheduleSelect, 'Seleccione la programación');
        isValid = false;
    } else {
        clearFieldError(scheduleSelect);
    }
    
    if (!messageTextarea.value.trim()) {
        showFieldError(messageTextarea, 'El mensaje es obligatorio');
        isValid = false;
    } else if (channelSelect.value === 'sms' && messageTextarea.value.length > 160) {
        showFieldError(messageTextarea, 'El mensaje SMS no puede exceder 160 caracteres');
        isValid = false;
    } else {
        clearFieldError(messageTextarea);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    const formGroup = field.closest('.form-group');
    formGroup.classList.add('error');
    
    // Remover mensaje de error existente
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Agregar nuevo mensaje de error
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    formGroup.appendChild(errorElement);
}

function clearFieldError(field) {
    const formGroup = field.closest('.form-group');
    formGroup.classList.remove('error');
    
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
}

function handleNewReminderSubmit(e) {
    e.preventDefault();
    
    if (!validateReminderForm()) {
        return;
    }
    
    const formData = {
        type: document.getElementById('reminder-type-select').value,
        channel: document.getElementById('reminder-channel-select').value,
        patient: document.getElementById('reminder-patient').value,
        schedule: document.getElementById('reminder-schedule').value,
        message: document.getElementById('reminder-message').value,
        notes: document.getElementById('reminder-notes').value
    };
    
    console.log('Creando nuevo recordatorio:', formData);
    
    // Mostrar loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    submitBtn.disabled = true;
    
    // Simular guardado
    setTimeout(() => {
        // Agregar recordatorio a la lista
        addReminderToList(formData);
        
        // Cerrar modal y resetear formulario
        document.getElementById('new-reminder-modal').classList.remove('active');
        e.target.reset();
        
        // Restaurar botón
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Mostrar notificación
        showToast('Recordatorio creado exitosamente', 'success');
        
    }, 1500);
}

function sendReminderImmediately() {
    if (!validateReminderForm()) {
        return;
    }
    
    const formData = {
        type: document.getElementById('reminder-type-select').value,
        channel: document.getElementById('reminder-channel-select').value,
        patient: document.getElementById('reminder-patient').value,
        message: document.getElementById('reminder-message').value
    };
    
    console.log('Enviando recordatorio inmediatamente:', formData);
    
    const sendNowBtn = document.getElementById('send-now-btn');
    const originalText = sendNowBtn.innerHTML;
    sendNowBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    sendNowBtn.disabled = true;
    
    // Simular envío
    setTimeout(() => {
        // Cerrar modal
        document.getElementById('new-reminder-modal').classList.remove('active');
        document.getElementById('new-reminder-form').reset();
        
        // Restaurar botón
        sendNowBtn.innerHTML = originalText;
        sendNowBtn.disabled = false;
        
        // Mostrar notificación
        showToast('Recordatorio enviado exitosamente', 'success');
        
    }, 2000);
}

function addReminderToList(reminderData) {
    const remindersList = document.querySelector('.reminders-list');
    if (!remindersList) return;
    
    const reminderCard = document.createElement('div');
    reminderCard.className = 'reminder-card';
    reminderCard.setAttribute('data-type', reminderData.type);
    reminderCard.setAttribute('data-status', 'programado');
    reminderCard.setAttribute('data-channel', reminderData.channel);
    
    const typeNames = {
        'cita': 'Cita',
        'pago': 'Pago',
        'medicamento': 'Medicamento',
        'resultado': 'Resultados',
        'general': 'General'
    };
    
    const channelIcons = {
        'sms': 'mobile-alt',
        'email': 'envelope',
        'llamada': 'phone',
        'push': 'bell'
    };
    
    reminderCard.innerHTML = `
        <div class="reminder-checkbox">
            <input type="checkbox" class="reminder-select">
        </div>
        <div class="reminder-icon">
            <i class="fas fa-${getReminderIcon(reminderData.type)}"></i>
        </div>
        <div class="reminder-content">
            <div class="reminder-header">
                <h4>Nuevo Recordatorio - ${typeNames[reminderData.type]}</h4>
                <span class="reminder-badge type-${reminderData.type}">${typeNames[reminderData.type]}</span>
            </div>
            <div class="reminder-details">
                <p><i class="fas fa-comment"></i> <strong>Mensaje:</strong> ${reminderData.message}</p>
                ${reminderData.notes ? `<p><i class="fas fa-sticky-note"></i> <strong>Notas:</strong> ${reminderData.notes}</p>` : ''}
            </div>
            <div class="reminder-meta">
                <span class="meta-item">
                    <i class="fas fa-${channelIcons[reminderData.channel]}"></i> ${reminderData.channel.toUpperCase()}
                </span>
                <span class="meta-item">
                    <i class="fas fa-clock"></i> Programado para: ${new Date().toLocaleDateString()}
                </span>
                <span class="meta-item">
                    <i class="fas fa-user"></i> ${getPatientLabel(reminderData.patient)}
                </span>
            </div>
        </div>
        <div class="reminder-actions">
            <span class="status-badge scheduled">Programado</span>
            <div class="action-buttons">
                <button class="btn-send" title="Enviar ahora">
                    <i class="fas fa-paper-plane"></i>
                </button>
                <button class="btn-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-cancel" title="Cancelar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    // Agregar event listeners a los nuevos botones
    setupIndividualActionsForCard(reminderCard);
    
    // Insertar al principio de la lista
    remindersList.insertBefore(reminderCard, remindersList.firstChild);
}

function getReminderIcon(type) {
    const icons = {
        'cita': 'calendar-check',
        'pago': 'file-invoice-dollar',
        'medicamento': 'pills',
        'resultado': 'file-medical',
        'general': 'bullhorn'
    };
    return icons[type] || 'bell';
}

function getPatientLabel(patientType) {
    const labels = {
        'individual': 'Paciente individual',
        'grupo': 'Grupo de pacientes',
        'todos': 'Todos los pacientes'
    };
    return labels[patientType] || 'No especificado';
}

function setupIndividualActionsForCard(card) {
    card.querySelector('.btn-send').addEventListener('click', function() {
        sendReminderNow(card);
    });
    
    card.querySelector('.btn-edit').addEventListener('click', function() {
        editReminder(card);
    });
    
    card.querySelector('.btn-cancel').addEventListener('click', function() {
        cancelReminder(card);
    });
}

function applyReminderFilters() {
    const typeFilter = document.getElementById('reminder-type').value;
    const statusFilter = document.getElementById('reminder-status').value;
    const channelFilter = document.getElementById('reminder-channel').value;
    const dateFilter = document.getElementById('date-range').value;
    
    console.log('Aplicando filtros:', { typeFilter, statusFilter, channelFilter, dateFilter });
    
    const reminderCards = document.querySelectorAll('.reminder-card');
    let visibleCards = 0;
    
    reminderCards.forEach(card => {
        const cardType = card.getAttribute('data-type');
        const cardStatus = card.getAttribute('data-status');
        const cardChannel = card.getAttribute('data-channel');
        
        let showCard = true;
        
        if (typeFilter && cardType !== typeFilter) {
            showCard = false;
        }
        
        if (statusFilter && cardStatus !== statusFilter) {
            showCard = false;
        }
        
        if (channelFilter && cardChannel !== channelFilter) {
            showCard = false;
        }
        
        // Filtro de fecha simulado
        if (dateFilter && !matchesDateFilter(card, dateFilter)) {
            showCard = false;
        }
        
        card.style.display = showCard ? 'flex' : 'none';
        if (showCard) visibleCards++;
    });
    
    console.log(`Mostrando ${visibleCards} recordatorios`);
    
    if (visibleCards === 0) {
        showToast('No se encontraron recordatorios con los criterios seleccionados', 'warning');
    } else {
        showToast(`Filtros aplicados: ${visibleCards} recordatorios mostrados`, 'success');
    }
}

function matchesDateFilter(card, dateFilter) {
    // En una implementación real, esto verificaría la fecha del recordatorio
    // Por ahora, es una implementación simulada
    const randomMatch = Math.random() > 0.2; // 80% de probabilidad de coincidir
    return randomMatch;
}

function resetReminderFilters() {
    document.getElementById('reminder-type').value = '';
    document.getElementById('reminder-status').value = '';
    document.getElementById('reminder-channel').value = '';
    document.getElementById('date-range').value = 'hoy';
    
    const reminderCards = document.querySelectorAll('.reminder-card');
    reminderCards.forEach(card => {
        card.style.display = 'flex';
    });
    
    showToast('Filtros restablecidos', 'success');
}

function searchReminders(e) {
    const searchTerm = e.target.value.toLowerCase();
    const reminderCards = document.querySelectorAll('.reminder-card');
    
    reminderCards.forEach(card => {
        const reminderTitle = card.querySelector('h4').textContent.toLowerCase();
        const reminderMessage = card.querySelector('.reminder-details p:last-child').textContent.toLowerCase();
        
        if (reminderTitle.includes(searchTerm) || reminderMessage.includes(searchTerm)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

// Funciones de acciones individuales
function sendReminderNow(card) {
    const reminderTitle = card.querySelector('h4').textContent;
    console.log('Enviando recordatorio:', reminderTitle);
    
    // Simular envío
    const statusBadge = card.querySelector('.status-badge');
    statusBadge.textContent = 'Enviado';
    statusBadge.className = 'status-badge sent';
    
    showToast('Recordatorio enviado exitosamente', 'success');
}

function editReminder(card) {
    const reminderTitle = card.querySelector('h4').textContent;
    console.log('Editando recordatorio:', reminderTitle);
    
    showNewReminderModal();
    showToast(`Editando: ${reminderTitle}`, 'success');
}

function cancelReminder(card) {
    const reminderTitle = card.querySelector('h4').textContent;
    
    if (confirm(`¿Está seguro de que desea cancelar este recordatorio: "${reminderTitle}"?`)) {
        console.log('Cancelando recordatorio:', reminderTitle);
        card.remove();
        showToast('Recordatorio cancelado', 'success');
    }
}

function viewReminderDetails(card) {
    const reminderTitle = card.querySelector('h4').textContent;
    console.log('Viendo detalles de:', reminderTitle);
    
    showToast(`Mostrando detalles de: ${reminderTitle}`, 'success');
}

function resendReminder(card) {
    const reminderTitle = card.querySelector('h4').textContent;
    console.log('Reenviando recordatorio:', reminderTitle);
    
    showToast('Recordatorio reenviado', 'success');
}

function retryReminder(card) {
    const reminderTitle = card.querySelector('h4').textContent;
    console.log('Reintentando envío de:', reminderTitle);
    
    // Simular reintento
    const statusBadge = card.querySelector('.status-badge');
    statusBadge.textContent = 'Pendiente';
    statusBadge.className = 'status-badge pending';
    
    showToast('Reintentando envío del recordatorio', 'success');
}

// Funciones de acciones masivas
function sendBulkReminders() {
    const selectedCount = document.querySelectorAll('.reminder-select:checked').length;
    
    if (selectedCount === 0) {
        showToast('Seleccione al menos un recordatorio para enviar', 'warning');
        return;
    }
    
    console.log(`Enviando ${selectedCount} recordatorios en lote`);
    
    // Simular envío masivo
    document.querySelectorAll('.reminder-select:checked').forEach(checkbox => {
        const card = checkbox.closest('.reminder-card');
        const statusBadge = card.querySelector('.status-badge');
        if (statusBadge.textContent === 'Pendiente' || statusBadge.textContent === 'Programado') {
            statusBadge.textContent = 'Enviado';
            statusBadge.className = 'status-badge sent';
        }
    });
    
    showToast(`${selectedCount} recordatorios enviados exitosamente`, 'success');
}

function scheduleBulkReminders() {
    const selectedCount = document.querySelectorAll('.reminder-select:checked').length;
    
    if (selectedCount === 0) {
        showToast('Seleccione al menos un recordatorio para programar', 'warning');
        return;
    }
    
    console.log(`Programando ${selectedCount} recordatorios`);
    showToast(`${selectedCount} recordatorios programados para envío`, 'success');
}

function deleteBulkReminders() {
    const selectedCount = document.querySelectorAll('.reminder-select:checked').length;
    
    if (selectedCount === 0) {
        showToast('Seleccione al menos un recordatorio para eliminar', 'warning');
        return;
    }
    
    if (confirm(`¿Está seguro de que desea eliminar ${selectedCount} recordatorios seleccionados?`)) {
        document.querySelectorAll('.reminder-select:checked').forEach(checkbox => {
            const card = checkbox.closest('.reminder-card');
            card.remove();
        });
        
        showToast(`${selectedCount} recordatorios eliminados`, 'success');
    }
}

function useTemplate(templateName) {
    console.log('Usando plantilla:', templateName);
    showNewReminderModal();
    showToast(`Plantilla "${templateName}" cargada`, 'success');
    
    // En una implementación real, aquí se cargaría el contenido de la plantilla
}

function exportRemindersData() {
    console.log('Exportando datos de recordatorios...');
    showToast('Generando archivo de exportación...', 'success');
    
    setTimeout(() => {
        showToast('Datos de recordatorios exportados exitosamente', 'success');
    }, 2000);
}

function refreshRemindersList() {
    const refreshBtn = document.getElementById('refresh-reminders');
    const originalText = refreshBtn.innerHTML;
    
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        loadRemindersData();
        refreshBtn.innerHTML = originalText;
        refreshBtn.disabled = false;
        showToast('Lista de recordatorios actualizada', 'success');
    }, 1500);
}

function loadPage(pageNumber) {
    console.log('Cargando página:', pageNumber);
    showToast(`Cargando página ${pageNumber}...`, 'success');
}

function loadNextPage() {
    console.log('Cargando siguiente página');
}

function loadPreviousPage() {
    console.log('Cargando página anterior');
}

function loadRemindersData() {
    // En una implementación real, esto cargaría datos del servidor
    console.log('Cargando datos de recordatorios...');
}

function initializeSampleReminders() {
    // Datos de ejemplo para demostración
    console.log('Inicializando recordatorios de ejemplo');
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
console.log('Script de recordatorios completamente cargado');