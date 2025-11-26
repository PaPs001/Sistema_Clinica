// script-pacientes.js - Funcionalidades para Gestión de Pacientes
console.log('Script de pacientes cargado correctamente');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM completamente cargado - Módulo Pacientes');

    try {
        // Inicializar componentes
        initializePatientsManagement();
        setupEventListeners();
        loadPatientsData();

        console.log('Gestión de pacientes inicializada correctamente');

    } catch (error) {
        console.error('Error al inicializar gestión de pacientes:', error);
    }
});

function initializePatientsManagement() {
    // Configurar fecha actual en filtros
    const today = new Date();
    updateDateFilters(today);

    // Inicializar datos de ejemplo
    initializeSamplePatients();

    // Configurar selección múltiple
    setupBulkSelection();
}

function setupEventListeners() {
    // Botón nuevo paciente
    const addPatientBtn = document.getElementById('add-patient-btn');
    if (addPatientBtn) {
        addPatientBtn.addEventListener('click', function () {
            window.location.href = 'registro-pacientes.html';
        });
    }

    // Filtros
    const applyFiltersBtn = document.getElementById('apply-filters');
    const resetFiltersBtn = document.getElementById('reset-filters');

    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyPatientFilters);
    }

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', resetPatientFilters);
    }

    // Búsqueda
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', searchPatients);
    }

    // Ordenamiento
    const sortSelect = document.getElementById('sort-by');
    if (sortSelect) {
        sortSelect.addEventListener('change', sortPatients);
    }

    // Botones de acción
    setupActionButtons();

    // Botones de exportar y actualizar
    const exportPatientsBtn = document.getElementById('export-patients');
    const refreshPatientsBtn = document.getElementById('refresh-patients');
    const bulkActionsBtn = document.getElementById('bulk-actions');

    if (exportPatientsBtn) {
        exportPatientsBtn.addEventListener('click', exportPatientsData);
    }

    if (refreshPatientsBtn) {
        refreshPatientsBtn.addEventListener('click', refreshPatientsList);
    }

    if (bulkActionsBtn) {
        bulkActionsBtn.addEventListener('click', showBulkActionsMenu);
    }

    // Paginación
    setupPagination();

    // Modal de perfil
    const profileModal = document.getElementById('patient-profile-modal');
    const closeModalBtn = profileModal?.querySelector('.close-modal');

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function () {
            profileModal.classList.remove('active');
        });
    }

    if (profileModal) {
        profileModal.addEventListener('click', function (e) {
            if (e.target === profileModal) {
                profileModal.classList.remove('active');
            }
        });
    }
}

function setupBulkSelection() {
    const selectAllCheckbox = document.getElementById('select-all');
    const patientCheckboxes = document.querySelectorAll('.patient-select');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            const isChecked = this.checked;
            patientCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                const row = checkbox.closest('.patient-row');
                if (isChecked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            });

            updateBulkActionsState();
        });
    }

    patientCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const row = this.closest('.patient-row');
            if (this.checked) {
                row.classList.add('selected');
            } else {
                row.classList.remove('selected');
            }

            updateSelectAllState();
            updateBulkActionsState();
        });
    });
}

function updateSelectAllState() {
    const selectAllCheckbox = document.getElementById('select-all');
    const patientCheckboxes = document.querySelectorAll('.patient-select');
    const checkedCount = document.querySelectorAll('.patient-select:checked').length;
    const totalCount = patientCheckboxes.length;

    if (selectAllCheckbox) {
        selectAllCheckbox.checked = checkedCount === totalCount;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
    }
}

function updateBulkActionsState() {
    const checkedCount = document.querySelectorAll('.patient-select:checked').length;
    const bulkActionsBtn = document.getElementById('bulk-actions');

    if (bulkActionsBtn) {
        if (checkedCount > 0) {
            bulkActionsBtn.innerHTML = `<i class="fas fa-cog"></i> Acciones (${checkedCount})`;
            bulkActionsBtn.disabled = false;
        } else {
            bulkActionsBtn.innerHTML = `<i class="fas fa-cog"></i> Acciones`;
            bulkActionsBtn.disabled = false;
        }
    }
}

function setupActionButtons() {
    // Botones de ver perfil
    const viewButtons = document.querySelectorAll('.btn-view');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('.patient-row');
            const patientName = row.querySelector('.patient-details strong').textContent;
            const patientId = row.querySelector('.patient-details span').textContent.replace('ID: ', '');
            showPatientProfile(patientName, patientId, row);
        });
    });

    // Botones de editar
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const patientId = this.dataset.id;
            const name = this.dataset.name;
            const phone = this.dataset.phone;
            const email = this.dataset.email;
            const status = this.dataset.status;

            openEditModal(patientId, name, phone, email, status);
        });
    });

    // Formulario de edición
    const editForm = document.getElementById('edit-patient-form');
    if (editForm) {
        editForm.addEventListener('submit', handleEditFormSubmit);
    }

    // Cerrar modal de edición
    const editModal = document.getElementById('edit-patient-modal');
    if (editModal) {
        const closeBtns = editModal.querySelectorAll('.close-modal');
        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                editModal.classList.remove('active');
            });
        });
    }

    // Botones de agendar cita
    const calendarButtons = document.querySelectorAll('.btn-calendar');
    calendarButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('.patient-row');
            const patientName = row.querySelector('.patient-details strong').textContent;
            scheduleAppointment(patientName);
        });
    });

    // Botones de enviar mensaje
    const messageButtons = document.querySelectorAll('.btn-message');
    messageButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('.patient-row');
            const patientName = row.querySelector('.patient-details strong').textContent;
            sendMessageToPatient(patientName);
        });
    });
}

function setupPagination() {
    const paginationBtns = document.querySelectorAll('.pagination-btn:not(:disabled)');
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function () {
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

function updateDateFilters(date) {
    // En una implementación real, esto actualizaría los filtros basados en la fecha
    console.log('Actualizando filtros de fecha:', date);
}

function applyPatientFilters() {
    const statusFilter = document.getElementById('status-filter').value;
    const dateFilter = document.getElementById('date-filter').value;

    console.log('Aplicando filtros - Estado:', statusFilter, 'Fecha:', dateFilter);

    const patientRows = document.querySelectorAll('.patient-row');
    let visibleRows = 0;

    patientRows.forEach(row => {
        const patientStatus = row.getAttribute('data-status');
        let showRow = true;

        // Filtrar por estado
        if (statusFilter && patientStatus !== statusFilter) {
            showRow = false;
        }

        // Filtrar por fecha (simulado)
        if (dateFilter && !matchesDateFilter(row, dateFilter)) {
            showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
        if (showRow) visibleRows++;
    });

    console.log(`Mostrando ${visibleRows} pacientes con los filtros aplicados`);

    if (visibleRows === 0) {
        showToast('No se encontraron pacientes con los criterios seleccionados', 'warning');
    } else {
        showToast(`Filtros aplicados: ${visibleRows} pacientes mostrados`, 'success');
    }
}

function matchesDateFilter(row, dateFilter) {
    // En una implementación real, esto verificaría la fecha de registro del paciente
    // Por ahora, es una implementación simulada
    const randomMatch = Math.random() > 0.3; // 70% de probabilidad de coincidir
    return randomMatch;
}

function resetPatientFilters() {
    document.getElementById('status-filter').value = '';
    document.getElementById('date-filter').value = '';
    document.getElementById('sort-by').value = 'nombre';

    const patientRows = document.querySelectorAll('.patient-row');
    patientRows.forEach(row => {
        row.style.display = '';
    });

    showToast('Filtros restablecidos', 'success');
}

function searchPatients(e) {
    const searchTerm = e.target.value.toLowerCase();
    const patientRows = document.querySelectorAll('.patient-row');

    patientRows.forEach(row => {
        const patientName = row.querySelector('.patient-details strong').textContent.toLowerCase();
        const patientId = row.querySelector('.patient-details span').textContent.toLowerCase();
        const patientPhone = row.querySelector('.contact-info p:first-child').textContent.toLowerCase();

        if (patientName.includes(searchTerm) || patientId.includes(searchTerm) || patientPhone.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function sortPatients(e) {
    const sortBy = e.target.value;
    console.log('Ordenando pacientes por:', sortBy);

    // Simular ordenamiento
    showToast(`Pacientes ordenados por ${getSortCriteriaName(sortBy)}`, 'success');

    // En una implementación real, aquí se ordenaría la lista
}

function getSortCriteriaName(criteria) {
    const criteriaNames = {
        'nombre': 'Nombre A-Z',
        'fecha': 'Fecha de Registro',
        'reciente': 'Más Reciente',
        'antiguo': 'Más Antiguo'
    };
    return criteriaNames[criteria] || criteria;
}

function showPatientProfile(patientName, patientId, row) {
    console.log('Mostrando perfil de:', patientName, patientId);

    const modal = document.getElementById('patient-profile-modal');
    const profileContent = modal.querySelector('.patient-profile');

    // Simular carga de datos del paciente
    profileContent.innerHTML = `
        <div class="profile-loading">
            <i class="fas fa-spinner fa-spin"></i> Cargando perfil del paciente...
        </div>
    `;

    // Simular delay de carga
    setTimeout(() => {
        profileContent.innerHTML = getPatientProfileHTML(patientName, patientId, row);
    }, 1000);

    modal.classList.add('active');
}

function getPatientProfileHTML(patientName, patientId, row) {
    const contactInfo = row.querySelector('.contact-info').innerHTML;
    const medicalInfo = row.querySelector('.medical-info').innerHTML;
    const lastVisit = row.querySelector('.last-visit').innerHTML;

    return `
        <div class="profile-header">
            <div class="profile-avatar">
                <div class="patient-avatar large">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h4>${patientName}</h4>
                    <p>${patientId}</p>
                    <span class="status-badge active">Activo</span>
                </div>
            </div>
        </div>
        
        <div class="profile-sections">
            <div class="profile-section">
                <h5><i class="fas fa-address-book"></i> Información de Contacto</h5>
                <div class="section-content">
                    ${contactInfo}
                </div>
            </div>
            
            <div class="profile-section">
                <h5><i class="fas fa-heartbeat"></i> Información Médica</h5>
                <div class="section-content">
                    ${medicalInfo}
                    <div class="additional-info">
                        <p><strong>Fecha de Registro:</strong> 15 Nov 2023</p>
                        <p><strong>Médico Principal:</strong> Dra. Elena Morales</p>
                        <p><strong>Notas:</strong> Paciente colaborador, sigue tratamiento al pie de la letra.</p>
                    </div>
                </div>
            </div>
            
            <div class="profile-section">
                <h5><i class="fas fa-history"></i> Historial Reciente</h5>
                <div class="section-content">
                    ${lastVisit}
                    <div class="visit-history">
                        <div class="visit-item">
                            <span class="visit-date">01 Nov 2023</span>
                            <span class="visit-doctor">Dr. Roberto Silva</span>
                            <span class="visit-type control">Control</span>
                        </div>
                        <div class="visit-item">
                            <span class="visit-date">15 Oct 2023</span>
                            <span class="visit-doctor">Dra. Elena Morales</span>
                            <span class="visit-type consulta">Consulta</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="profile-actions">
            <button class="section-btn" onclick="editPatient('${patientName}')">
                <i class="fas fa-edit"></i> Editar Perfil
            </button>
            <button class="section-btn" onclick="scheduleAppointment('${patientName}')">
                <i class="fas fa-calendar-plus"></i> Agendar Cita
            </button>
            <button class="section-btn btn-cancel" onclick="closePatientProfile()">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>
    `;
}

function editPatient(patientName) {
    console.log('Editando paciente:', patientName);
    showToast(`Editando perfil de ${patientName}`, 'success');

    // Cerrar modal si está abierto
    document.getElementById('patient-profile-modal').classList.remove('active');

    // En una implementación real, redirigiría a la página de edición
}

function openEditModal(id, name, phone, email, status) {
    const modal = document.getElementById('edit-patient-modal');
    if (!modal) return;

    document.getElementById('edit-patient-id').value = id;
    document.getElementById('edit-name-display').value = name;
    // Phone and Email fields are removed from modal, so we don't set them
    document.getElementById('edit-status').value = status;

    modal.classList.add('active');
}

function handleEditFormSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const patientId = formData.get('id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    submitBtn.disabled = true;

    fetch(`/recepcionista/update-paciente/${patientId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                document.getElementById('edit-patient-modal').classList.remove('active');
                // Recargar la página para ver los cambios
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showToast(data.message || 'Error al actualizar paciente', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Ocurrió un error al procesar la solicitud', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
}

function scheduleAppointment(patientName) {
    console.log('Agendando cita para:', patientName);
    showToast(`Redirigiendo para agendar cita para ${patientName}`, 'success');

    // En una implementación real, redirigiría a la página de agendar citas
    setTimeout(() => {
        window.location.href = 'gestion-citas.html';
    }, 1000);
}

function sendMessageToPatient(patientName) {
    console.log('Enviando mensaje a:', patientName);
    showToast(`Enviando mensaje a ${patientName}`, 'success');
}

function exportPatientsData() {
    console.log('Exportando datos de pacientes...');
    showToast('Generando archivo de exportación...', 'success');

    setTimeout(() => {
        showToast('Datos de pacientes exportados exitosamente', 'success');
    }, 2000);
}

function refreshPatientsList() {
    const refreshBtn = document.getElementById('refresh-patients');
    const originalText = refreshBtn.innerHTML;

    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
    refreshBtn.disabled = true;

    setTimeout(() => {
        loadPatientsData();
        refreshBtn.innerHTML = originalText;
        refreshBtn.disabled = false;
        showToast('Lista de pacientes actualizada', 'success');
    }, 1500);
}

function showBulkActionsMenu() {
    const checkedCount = document.querySelectorAll('.patient-select:checked').length;

    if (checkedCount === 0) {
        showToast('Seleccione al menos un paciente para realizar acciones', 'warning');
        return;
    }

    // Crear menú de acciones
    const menu = document.createElement('div');
    menu.style.cssText = `
        position: absolute;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 10px 0;
        z-index: 1000;
        min-width: 200px;
    `;

    menu.innerHTML = `
        <div class="bulk-menu-header">
            <strong>Acciones para ${checkedCount} pacientes</strong>
        </div>
        <div class="bulk-menu-item" onclick="sendBulkMessages()">
            <i class="fas fa-envelope"></i> Enviar Mensajes
        </div>
        <div class="bulk-menu-item" onclick="exportSelectedPatients()">
            <i class="fas fa-download"></i> Exportar Seleccionados
        </div>
        <div class="bulk-menu-item" onclick="changeStatusBulk()">
            <i class="fas fa-user-check"></i> Cambiar Estado
        </div>
        <div class="bulk-menu-item" onclick="deleteSelectedPatients()">
            <i class="fas fa-trash"></i> Eliminar Seleccionados
        </div>
    `;

    const bulkActionsBtn = document.getElementById('bulk-actions');
    const rect = bulkActionsBtn.getBoundingClientRect();

    menu.style.top = `${rect.bottom + 5}px`;
    menu.style.left = `${rect.left}px`;

    document.body.appendChild(menu);

    // Cerrar menú al hacer clic fuera
    const closeMenu = function (e) {
        if (!menu.contains(e.target) && e.target !== bulkActionsBtn) {
            document.body.removeChild(menu);
            document.removeEventListener('click', closeMenu);
        }
    };

    setTimeout(() => {
        document.addEventListener('click', closeMenu);
    }, 100);
}

// Funciones de acciones masivas
window.sendBulkMessages = function () {
    const selectedCount = document.querySelectorAll('.patient-select:checked').length;
    showToast(`Enviando mensajes a ${selectedCount} pacientes`, 'success');
};

window.exportSelectedPatients = function () {
    const selectedCount = document.querySelectorAll('.patient-select:checked').length;
    showToast(`Exportando ${selectedCount} pacientes seleccionados`, 'success');
};

window.changeStatusBulk = function () {
    const selectedCount = document.querySelectorAll('.patient-select:checked').length;
    showToast(`Cambiando estado de ${selectedCount} pacientes`, 'success');
};

window.deleteSelectedPatients = function () {
    const selectedCount = document.querySelectorAll('.patient-select:checked').length;

    if (confirm(`¿Está seguro de que desea eliminar ${selectedCount} pacientes seleccionados?`)) {
        showToast(`${selectedCount} pacientes eliminados`, 'success');
        // En una implementación real, aquí se eliminarían los pacientes
    }
};

window.closePatientProfile = function () {
    document.getElementById('patient-profile-modal').classList.remove('active');
};

function loadPage(pageNumber) {
    console.log('Cargando página:', pageNumber);
    showToast(`Cargando página ${pageNumber}...`, 'success');

    // En una implementación real, cargaría los datos de la página
}

function loadNextPage() {
    console.log('Cargando siguiente página');
    // Implementación para cargar página siguiente
}

function loadPreviousPage() {
    console.log('Cargando página anterior');
    // Implementación para cargar página anterior
}

function loadPatientsData() {
    // En una implementación real, esto cargaría datos del servidor
    console.log('Cargando datos de pacientes...');
}

function initializeSamplePatients() {
    // Datos de ejemplo para demostración
    console.log('Inicializando pacientes de ejemplo');
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
console.log('Script de pacientes completamente cargado');