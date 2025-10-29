// script-registro-paciente.js - Funcionalidades para Registro de Pacientes
console.log('Script de registro de pacientes cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Registro de Pacientes');
    
    try {
        // Inicializar componentes
        initializePatientRegistration();
        setupEventListeners();
        loadRecentPatients();
        
        console.log('Registro de pacientes inicializado correctamente');
        
    } catch (error) {
        console.error('Error al inicializar registro de pacientes:', error);
    }
});

function initializePatientRegistration() {
    // Configurar fecha máxima para fecha de nacimiento (hoy)
    const dobInput = document.getElementById('patient-dob');
    if (dobInput) {
        const today = new Date().toISOString().split('T')[0];
        dobInput.max = today;
    }
    
    // Configurar formato de teléfono
    const phoneInput = document.getElementById('patient-phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', formatPhoneNumber);
    }
    
    // Inicializar datos de ejemplo
    initializeSampleData();
}

function setupEventListeners() {
    // Formulario principal
    const registrationForm = document.getElementById('patient-registration-form');
    if (registrationForm) {
        registrationForm.addEventListener('submit', handlePatientRegistration);
    }
    
    // Botón limpiar formulario
    const clearFormBtn = document.getElementById('clear-form');
    if (clearFormBtn) {
        clearFormBtn.addEventListener('click', clearRegistrationForm);
    }
    
    // Registro rápido
    const quickRegistrationBtn = document.getElementById('quick-registration-btn');
    const quickRegistrationModal = document.getElementById('quick-registration-modal');
    const cancelQuickRegistrationBtn = document.getElementById('cancel-quick-registration');
    const quickRegistrationForm = document.getElementById('quick-registration-form');
    
    if (quickRegistrationBtn) {
        quickRegistrationBtn.addEventListener('click', function() {
            quickRegistrationModal.classList.add('active');
        });
    }
    
    if (cancelQuickRegistrationBtn) {
        cancelQuickRegistrationBtn.addEventListener('click', function() {
            quickRegistrationModal.classList.remove('active');
        });
    }
    
    if (quickRegistrationForm) {
        quickRegistrationForm.addEventListener('submit', handleQuickRegistration);
    }
    
    // Cerrar modal al hacer clic fuera
    if (quickRegistrationModal) {
        quickRegistrationModal.addEventListener('click', function(e) {
            if (e.target === quickRegistrationModal) {
                quickRegistrationModal.classList.remove('active');
            }
        });
    }
    
    // Botones de acción en pacientes recientes
    setupRecentPatientsActions();
    
    // Botones de exportar y actualizar
    const exportPatientsBtn = document.getElementById('export-patients');
    const refreshPatientsBtn = document.getElementById('refresh-patients');
    
    if (exportPatientsBtn) {
        exportPatientsBtn.addEventListener('click', exportPatientsData);
    }
    
    if (refreshPatientsBtn) {
        refreshPatientsBtn.addEventListener('click', refreshRecentPatients);
    }
    
    // Búsqueda de pacientes
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', searchPatients);
    }
}

function setupRecentPatientsActions() {
    // Botones de ver detalles
    const viewButtons = document.querySelectorAll('.recent-patient-card .btn-view');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.recent-patient-card');
            const patientName = card.querySelector('h4').textContent;
            viewPatientDetails(patientName);
        });
    });
    
    // Botones de editar
    const editButtons = document.querySelectorAll('.recent-patient-card .btn-cancel');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.recent-patient-card');
            const patientName = card.querySelector('h4').textContent;
            editPatient(patientName);
        });
    });
}

function handlePatientRegistration(e) {
    e.preventDefault();
    
    // Obtener datos del formulario
    const formData = new FormData(e.target);
    const patientData = {
        name: formData.get('patient-name'),
        email: formData.get('patient-email'),
        phone: formData.get('patient-phone'),
        dob: formData.get('patient-dob'),
        gender: formData.get('patient-gender'),
        id: formData.get('patient-id'),
        address: formData.get('patient-address'),
        city: formData.get('patient-city'),
        state: formData.get('patient-state'),
        zip: formData.get('patient-zip'),
        bloodType: formData.get('patient-blood-type'),
        allergies: formData.get('patient-allergies'),
        medications: formData.get('patient-medications'),
        conditions: formData.get('patient-conditions'),
        notes: formData.get('patient-notes'),
        consent: formData.get('patient-consent') === 'on'
    };
    
    // Validar datos
    if (!validatePatientData(patientData)) {
        return;
    }
    
    // Mostrar loading
    const submitBtn = document.getElementById('submit-patient');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    submitBtn.disabled = true;
    
    // Simular envío de datos
    console.log('Registrando paciente:', patientData);
    
    setTimeout(() => {
        // Agregar paciente a la lista de recientes
        addPatientToRecentList(patientData);
        
        // Limpiar formulario
        e.target.reset();
        
        // Restaurar botón
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Mostrar notificación de éxito
        showToast('Paciente registrado exitosamente', 'success');
        
        // Actualizar estadísticas
        updatePatientStats();
        
    }, 2000);
}

function handleQuickRegistration(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const quickData = {
        name: formData.get('quick-name'),
        phone: formData.get('quick-phone'),
        dob: formData.get('quick-dob')
    };
    
    // Validar datos mínimos
    if (!quickData.name || !quickData.phone) {
        showToast('Nombre y teléfono son obligatorios', 'error');
        return;
    }
    
    // Mostrar loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    submitBtn.disabled = true;
    
    console.log('Registro rápido de paciente:', quickData);
    
    setTimeout(() => {
        // Cerrar modal
        document.getElementById('quick-registration-modal').classList.remove('active');
        
        // Limpiar formulario rápido
        e.target.reset();
        
        // Restaurar botón
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Mostrar notificación
        showToast('Paciente registrado rápidamente', 'success');
        
        // Agregar a lista de recientes (datos mínimos)
        addPatientToRecentList(quickData);
        
    }, 1500);
}

function validatePatientData(data) {
    let isValid = true;
    
    // Validar campos obligatorios
    if (!data.name) {
        showFieldError('patient-name', 'El nombre es obligatorio');
        isValid = false;
    } else {
        clearFieldError('patient-name');
    }
    
    if (!data.phone) {
        showFieldError('patient-phone', 'El teléfono es obligatorio');
        isValid = false;
    } else {
        clearFieldError('patient-phone');
    }
    
    if (!data.dob) {
        showFieldError('patient-dob', 'La fecha de nacimiento es obligatoria');
        isValid = false;
    } else {
        clearFieldError('patient-dob');
    }
    
    if (!data.gender) {
        showFieldError('patient-gender', 'El género es obligatorio');
        isValid = false;
    } else {
        clearFieldError('patient-gender');
    }
    
    if (!data.id) {
        showFieldError('patient-id', 'La identificación es obligatoria');
        isValid = false;
    } else {
        clearFieldError('patient-id');
    }
    
    if (!data.address) {
        showFieldError('patient-address', 'La dirección es obligatoria');
        isValid = false;
    } else {
        clearFieldError('patient-address');
    }
    
    if (!data.consent) {
        showToast('Debe obtener el consentimiento del paciente', 'error');
        isValid = false;
    }
    
    // Validar formato de email si se proporciona
    if (data.email && !isValidEmail(data.email)) {
        showFieldError('patient-email', 'El formato del email no es válido');
        isValid = false;
    } else if (data.email) {
        clearFieldError('patient-email');
    }
    
    return isValid;
}

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
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

function clearFieldError(fieldId) {
    const field = document.getElementById(fieldId);
    const formGroup = field.closest('.form-group');
    
    formGroup.classList.remove('error');
    
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function formatPhoneNumber(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length > 0) {
        value = value.match(/.{1,3}/g).join('-');
    }
    
    e.target.value = value;
}

function addPatientToRecentList(patientData) {
    const recentGrid = document.querySelector('.recent-patients-grid');
    if (!recentGrid) return;
    
    const patientCard = document.createElement('div');
    patientCard.className = 'recent-patient-card';
    patientCard.innerHTML = `
        <div class="patient-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="patient-details">
            <h4>${patientData.name}</h4>
            <p><i class="fas fa-phone"></i> ${patientData.phone || 'No proporcionado'}</p>
            <p><i class="fas fa-envelope"></i> ${patientData.email || 'No proporcionado'}</p>
            <p><i class="fas fa-calendar"></i> Registrado ${new Date().toLocaleString()}</p>
        </div>
        <div class="patient-actions">
            <button class="btn-view" aria-label="Ver detalles">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-cancel" aria-label="Editar">
                <i class="fas fa-edit"></i>
            </button>
        </div>
    `;
    
    // Agregar event listeners
    patientCard.querySelector('.btn-view').addEventListener('click', function() {
        viewPatientDetails(patientData.name);
    });
    
    patientCard.querySelector('.btn-cancel').addEventListener('click', function() {
        editPatient(patientData.name);
    });
    
    // Insertar al principio
    recentGrid.insertBefore(patientCard, recentGrid.firstChild);
    
    // Limitar a 10 tarjetas
    const cards = recentGrid.querySelectorAll('.recent-patient-card');
    if (cards.length > 10) {
        recentGrid.removeChild(cards[cards.length - 1]);
    }
}

function clearRegistrationForm() {
    if (confirm('¿Está seguro de que desea limpiar todo el formulario? Se perderán todos los datos no guardados.')) {
        document.getElementById('patient-registration-form').reset();
        showToast('Formulario limpiado', 'success');
        
        // Limpiar errores
        document.querySelectorAll('.form-group.error').forEach(group => {
            group.classList.remove('error');
            const errorMessage = group.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        });
    }
}

function viewPatientDetails(patientName) {
    console.log('Viendo detalles de:', patientName);
    
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.3);
        z-index: 1000;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    `;
    
    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="color: var(--primary-color); margin: 0;">Detalles del Paciente</h3>
            <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #666;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-color) 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                <i class="fas fa-user"></i>
            </div>
            <h4 style="color: var(--primary-color); margin: 15px 0 5px 0;">${patientName}</h4>
            <p style="color: #666; margin: 0;">Paciente registrado</p>
        </div>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
            <h5 style="color: var(--primary-color); margin-bottom: 15px;">Información de Contacto</h5>
            <p><strong>Teléfono:</strong> 555-123-4567</p>
            <p><strong>Email:</strong> paciente@ejemplo.com</p>
            <p><strong>Dirección:</strong> Calle Ejemplo #123, Ciudad</p>
        </div>
        
        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
            <button onclick="scheduleAppointmentForPatient('${patientName}')" class="section-btn">
                <i class="fas fa-calendar-plus"></i> Agendar Cita
            </button>
            <button onclick="this.parentElement.parentElement.remove()" class="section-btn btn-cancel">
                Cerrar
            </button>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Cerrar modal al hacer clic fuera
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

function editPatient(patientName) {
    console.log('Editando paciente:', patientName);
    showToast(`Editando paciente: ${patientName}`, 'success');
}

function searchPatients(e) {
    const searchTerm = e.target.value.toLowerCase();
    const patientCards = document.querySelectorAll('.recent-patient-card');
    
    patientCards.forEach(card => {
        const patientName = card.querySelector('h4').textContent.toLowerCase();
        const patientPhone = card.querySelector('p:nth-child(2)').textContent.toLowerCase();
        const patientEmail = card.querySelector('p:nth-child(3)').textContent.toLowerCase();
        
        if (patientName.includes(searchTerm) || patientPhone.includes(searchTerm) || patientEmail.includes(searchTerm)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function exportPatientsData() {
    console.log('Exportando datos de pacientes...');
    showToast('Generando archivo de exportación...', 'success');
    
    setTimeout(() => {
        showToast('Datos de pacientes exportados exitosamente', 'success');
    }, 2000);
}

function refreshRecentPatients() {
    const refreshBtn = document.getElementById('refresh-patients');
    const originalText = refreshBtn.innerHTML;
    
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        loadRecentPatients();
        refreshBtn.innerHTML = originalText;
        refreshBtn.disabled = false;
        showToast('Lista de pacientes actualizada', 'success');
    }, 1500);
}

function loadRecentPatients() {
    // En una implementación real, esto cargaría datos del servidor
    console.log('Cargando pacientes recientes...');
}

function updatePatientStats() {
    // En una implementación real, esto actualizaría las estadísticas
    console.log('Actualizando estadísticas de pacientes...');
}

function initializeSampleData() {
    // Datos de ejemplo para demostración
    console.log('Inicializando datos de ejemplo para registro de pacientes');
}

// ===== FUNCIONES GLOBALES =====

window.scheduleAppointmentForPatient = function(patientName) {
    showToast(`Redirigiendo para agendar cita para: ${patientName}`, 'success');
    console.log(`Agendando cita para: ${patientName}`);
};

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
console.log('Script de registro de pacientes completamente cargado');