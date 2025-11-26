// script-gestion-citas.js - Funcionalidades específicas para Gestión de Citas
console.log('Script de gestión de citas cargado correctamente');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM completamente cargado - Módulo Gestión de Citas');

    try {
        // Inicializar componentes
        initializeAppointmentManagement();
        setupEventListeners();
        loadAppointmentData();

        console.log('Gestión de citas inicializada correctamente');

    } catch (error) {
        console.error('Error al inicializar gestión de citas:', error);
    }
});

function initializeAppointmentManagement() {
    // Configurar fecha actual en el filtro
    const today = new Date().toISOString().split('T')[0];
    const dateFilter = document.getElementById('date-filter');
    if (dateFilter) {
        dateFilter.value = today;
    }

    // Inicializar datos de ejemplo
    initializeSampleData();
}

function setupEventListeners() {
    // Botón nueva cita
    const newAppointmentBtn = document.getElementById('new-appointment-btn');
    if (newAppointmentBtn) {
        newAppointmentBtn.addEventListener('click', showNewAppointmentModal);
    }

    // Filtros
    const applyFiltersBtn = document.getElementById('apply-filters');
    const resetFiltersBtn = document.getElementById('reset-filters');

    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyAppointmentFilters);
    }

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', resetAppointmentFilters);
    }

    // Botones de acción en tabla
    setupTableActionButtons();

    // Botones de exportar y actualizar
    const exportCitasBtn = document.getElementById('export-citas');
    const refreshCitasBtn = document.getElementById('refresh-citas');

    if (exportCitasBtn) {
        exportCitasBtn.addEventListener('click', exportAppointments);
    }

    if (refreshCitasBtn) {
        refreshCitasBtn.addEventListener('click', refreshAppointments);
    }
}

function setupTableActionButtons() {
    // Botones de detalles
    const detailButtons = document.querySelectorAll('.appointments-table .btn-view');
    detailButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            showAppointmentDetails(patientName, row);
        });
    });

    // Botones de cancelar
    const cancelButtons = document.querySelectorAll('.appointments-table .btn-cancel');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            const action = this.textContent.toLowerCase();

            if (action === 'cancelar') {
                cancelAppointment(patientName, row);
            } else if (action === 'finalizar') {
                completeAppointment(patientName, row);
            }
        });
    });
}

async function showNewAppointmentModal() {
    // 1. Pedir correo del paciente
    const { value: checkResult } = await Swal.fire({
        title: 'Nueva Cita',
        input: 'email',
        inputLabel: 'Correo del Paciente',
        inputPlaceholder: 'Ingrese el correo del paciente',
        showCancelButton: true,
        confirmButtonText: 'Verificar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: async (email) => {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/recepcionista/check-patient', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ email })
                });
                if (!response.ok) throw new Error(response.statusText);
                const data = await response.json();
                return { ...data, email }; // Return data merged with email
            } catch (error) {
                Swal.showValidationMessage(`Request failed: ${error}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    });

    if (!checkResult) return; // Cancelled

    const isNew = !checkResult.exists;
    const patientName = checkResult.exists ? checkResult.name : '';
    const patientPhone = checkResult.exists ? (checkResult.phone || '') : '';

    // 1.5 Obtener lista de médicos
    let doctorOptions = '<option value="" disabled selected>Seleccionar Médico</option>';
    try {
        const response = await fetch('/recepcionista/get-doctors');
        if (response.ok) {
            const data = await response.json();
            if (data.success && data.doctors) {
                data.doctors.forEach(doctor => {
                    doctorOptions += `<option value="${doctor.name}">${doctor.name}</option>`;
                });
            }
        }
    } catch (error) {
        console.error('Error fetching doctors:', error);
    }

    // 2. Mostrar formulario de cita
    const { value: formValues } = await Swal.fire({
        title: isNew ? 'Registrar Nuevo Paciente y Cita' : 'Agendar Cita',
        html: `
            <div style="text-align: left; margin-bottom: 10px;">
                <label>Paciente</label>
                <input id="swal-email" class="swal2-input" value="${checkResult.email}" readonly style="background: #f0f0f0;">
                
                ${isNew ? `
                <label>Nombre Completo</label>
                <input id="swal-name" class="swal2-input" placeholder="Nombre Completo">
                <label>Teléfono</label>
                <input id="swal-phone" class="swal2-input" placeholder="Teléfono">
                ` : `
                <label>Nombre</label>
                <input class="swal2-input" value="${patientName}" readonly style="background: #f0f0f0;">
                `}
                
                <label>Médico</label>
                <select id="swal-doctor" class="swal2-select" style="width: 100%; margin: 10px 0;">
                    ${doctorOptions}
                </select>
                
                <label>Fecha</label>
                <input id="swal-date" class="swal2-input" type="date">
                
                <label>Hora</label>
                <input id="swal-time" class="swal2-input" type="time">
                
                <label>Tipo de Cita</label>
                <select id="swal-type" class="swal2-select" style="width: 100%; margin: 10px 0;">
                    <option value="consulta">Consulta</option>
                    <option value="control">Control</option>
                    <option value="emergencia">Urgencia</option>
                    <option value="seguimiento">Seguimiento</option>
                </select>
                
                <label>Notas</label>
                <textarea id="swal-notes" class="swal2-textarea" placeholder="Observaciones adicionales..."></textarea>
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Agendar',
        cancelButtonText: 'Cancelar',
        width: '600px',
        didOpen: () => {
            // Set default date/time
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.getElementById('swal-date');
            dateInput.value = today;
            dateInput.min = today;

            const now = new Date();
            const nextHour = new Date(now.getTime() + 60 * 60 * 1000);
            const hours = nextHour.getHours().toString().padStart(2, '0');
            const minutes = '00';
            document.getElementById('swal-time').value = `${hours}:${minutes}`;
        },
        preConfirm: () => {
            const doctor = document.getElementById('swal-doctor').value;
            const date = document.getElementById('swal-date').value;
            const time = document.getElementById('swal-time').value;
            const type = document.getElementById('swal-type').value;
            const notes = document.getElementById('swal-notes').value;

            const name = isNew ? document.getElementById('swal-name').value : patientName;
            const phone = isNew ? document.getElementById('swal-phone').value : patientPhone;

            if (!doctor || !date || !time || (isNew && (!name || !phone))) {
                Swal.showValidationMessage('Por favor complete todos los campos obligatorios');
                return false;
            }

            return {
                email: checkResult.email,
                is_new: isNew,
                name: name,
                phone: phone,
                doctor_name: doctor,
                date: date,
                time: time,
                type: type,
                notes: notes
            };
        }
    });

    if (formValues) {
        submitAppointment(formValues);
    }
}

async function submitAppointment(data) {
    try {
        Swal.fire({
            title: 'Agendando Cita...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch('/recepcionista/store-appointment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Cita Agendada!',
                text: result.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Agregar a la tabla (simulado o recargar)
            // Para simplificar, recargamos la página o llamamos a loadAppointmentData
            // Pero como loadAppointmentData es simulado, agregamos manualmente
            addAppointmentToTable({
                date: data.date,
                time: data.time,
                doctor: data.doctor_name,
                type: data.type,
                patient_name: data.name // Necesitamos el nombre para mostrarlo
            });

            updateAppointmentStats();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Ocurrió un error al agendar la cita'
        });
    }
}

function validateAppointmentData(data) {
    if (!data.patient || !data.doctor || !data.date || !data.time) {
        showToast('Por favor complete todos los campos obligatorios', 'error');
        return false;
    }

    // Validar que la fecha no sea en el pasado
    const appointmentDateTime = new Date(`${data.date}T${data.time}`);
    const now = new Date();

    if (appointmentDateTime < now) {
        showToast('No puede agendar citas en fechas pasadas', 'error');
        return false;
    }

    return true;
}

function addAppointmentToTable(appointmentData) {
    const tableBody = document.querySelector('.appointments-table tbody');
    if (!tableBody) return;

    // Obtener nombre del paciente
    const patientName = appointmentData.patient_name || 'Paciente';

    // Formatear fecha
    const appointmentDate = new Date(`${appointmentData.date}T${appointmentData.time}`);
    const formattedDate = formatAppointmentDate(appointmentDate);

    // Crear nueva fila
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <div class="time-slot">
                <strong>${formattedDate}</strong>
                <span>${getDateContext(appointmentDate)}</span>
            </div>
        </td>
        <td>
            <div class="patient-info">
                <div class="patient-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <strong>${patientName}</strong>
                    <span>Nuevo paciente</span>
                </div>
            </div>
        </td>
        <td>${appointmentData.doctor}</td>
        <td>Por asignar</td>
        <td><span class="type-badge ${appointmentData.type}">${getAppointmentTypeText(appointmentData.type)}</span></td>
        <td><span class="status-badge pending">Pendiente</span></td>
        <td>
            <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
            <button class="btn-cancel" aria-label="Cancelar cita">Cancelar</button>
        </td>
    `;

    // Agregar event listeners a los nuevos botones
    newRow.querySelector('.btn-view').addEventListener('click', function () {
        showAppointmentDetails(patientName, newRow);
    });

    newRow.querySelector('.btn-cancel').addEventListener('click', function () {
        cancelAppointment(patientName, newRow);
    });

    // Insertar al principio de la tabla
    tableBody.insertBefore(newRow, tableBody.firstChild);
}

function applyAppointmentFilters() {
    const dateFilter = document.getElementById('date-filter').value;
    const doctorFilter = document.getElementById('doctor-filter').value;
    const statusFilter = document.getElementById('status-filter').value;

    const tableRows = document.querySelectorAll('.appointments-table tbody tr');
    let visibleRows = 0;

    tableRows.forEach(row => {
        let showRow = true;

        // Filtrar por fecha
        if (dateFilter) {
            const dateText = row.querySelector('.time-slot strong').textContent;
            if (!dateText.includes(dateFilter.replace(/-/g, '/'))) {
                showRow = false;
            }
        }

        // Filtrar por médico
        if (doctorFilter && showRow) {
            const doctorName = row.cells[2].textContent;
            if (doctorName !== doctorFilter) {
                showRow = false;
            }
        }

        // Filtrar por estado
        if (statusFilter && showRow) {
            const statusBadge = row.querySelector('.status-badge');
            const status = statusBadge.textContent.toLowerCase();
            const statusMap = {
                'confirmada': 'confirmada',
                'pendiente': 'pending',
                'en consulta': 'en-consulta',
                'completada': 'completada',
                'cancelada': 'cancelada'
            };

            if (status !== statusMap[statusFilter]) {
                showRow = false;
            }
        }

        row.style.display = showRow ? '' : 'none';
        if (showRow) visibleRows++;
    });

    console.log(`Mostrando ${visibleRows} citas con los filtros aplicados`);

    if (visibleRows === 0) {
        showToast('No se encontraron citas con los criterios seleccionados', 'warning');
    }
}

function resetAppointmentFilters() {
    document.getElementById('date-filter').value = '';
    document.getElementById('doctor-filter').value = '';
    document.getElementById('status-filter').value = '';

    const tableRows = document.querySelectorAll('.appointments-table tbody tr');
    tableRows.forEach(row => {
        row.style.display = '';
    });

    showToast('Filtros restablecidos', 'success');
}

function showAppointmentDetails(patientName, row) {
    const dateTime = row.cells[0].querySelector('strong').textContent;
    const doctor = row.cells[2].textContent;
    const room = row.cells[3].textContent;
    const type = row.cells[4].querySelector('.type-badge').textContent;
    const status = row.cells[5].querySelector('.status-badge').textContent;

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
            <h3 style="color: var(--primary-color); margin: 0;">Detalles de Cita</h3>
            <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #666;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
            <div>
                <strong>Paciente:</strong>
                <p>${patientName}</p>
            </div>
            <div>
                <strong>Fecha y Hora:</strong>
                <p>${dateTime}</p>
            </div>
            <div>
                <strong>Médico:</strong>
                <p>${doctor}</p>
            </div>
            <div>
                <strong>Consultorio:</strong>
                <p>${room}</p>
            </div>
            <div>
                <strong>Tipo:</strong>
                <p><span class="type-badge ${type.toLowerCase()}">${type}</span></p>
            </div>
            <div>
                <strong>Estado:</strong>
                <p><span class="status-badge ${status.toLowerCase().replace(' ', '-')}">${status}</span></p>
            </div>
        </div>
        
        <div style="margin-bottom: 20px;">
            <strong>Historial de la Cita:</strong>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 10px;">
                <p>📅 Cita creada: ${new Date().toLocaleDateString()}</p>
                <p>⏰ Hora programada: ${dateTime.split(', ')[1]}</p>
                <p>👨‍⚕️ Médico asignado: ${doctor}</p>
            </div>
        </div>
        
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button onclick="sendAppointmentReminder('${patientName}')" class="section-btn" style="background: var(--accent-color);">
                <i class="fas fa-bell"></i> Recordatorio
            </button>
            <button onclick="rescheduleAppointmentFromDetails('${patientName}')" class="section-btn">
                <i class="fas fa-calendar-alt"></i> Reagendar
            </button>
            <button onclick="this.parentElement.parentElement.remove()" class="section-btn btn-cancel">
                Cerrar
            </button>
        </div>
    `;

    document.body.appendChild(modal);

    // Cerrar modal al hacer clic fuera
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

function cancelAppointment(patientName, row) {
    if (confirm(`¿Está seguro de que desea cancelar la cita de ${patientName}?`)) {
        // Cambiar estado a cancelado
        const statusBadge = row.querySelector('.status-badge');
        statusBadge.textContent = 'Cancelada';
        statusBadge.className = 'status-badge canceled';

        // Deshabilitar botones
        const buttons = row.querySelectorAll('button');
        buttons.forEach(btn => {
            if (btn.textContent === 'Cancelar') {
                btn.textContent = 'Cancelada';
            }
            btn.disabled = true;
        });

        // Mostrar notificación
        showToast(`Cita de ${patientName} cancelada`, 'success');

        // Actualizar estadísticas
        updateAppointmentStats();

        // En una implementación real, aquí se enviaría la cancelación al servidor
        console.log(`Cita cancelada para: ${patientName}`);
    }
}

function completeAppointment(patientName, row) {
    // Cambiar estado a completado
    const statusBadge = row.querySelector('.status-badge');
    statusBadge.textContent = 'Completada';
    statusBadge.className = 'status-badge completed';

    // Cambiar texto del botón
    const completeBtn = row.querySelector('.btn-cancel');
    if (completeBtn) {
        completeBtn.textContent = 'Completada';
        completeBtn.disabled = true;
    }

    showToast(`Cita de ${patientName} marcada como completada`, 'success');
    updateAppointmentStats();
}

function exportAppointments() {
    console.log('Exportando lista de citas...');

    // Simular proceso de exportación
    showToast('Generando archivo de exportación...', 'success');

    setTimeout(() => {
        showToast('Lista de citas exportada exitosamente', 'success');

        // En una implementación real, aquí se descargaría el archivo
        const exportData = {
            fecha: new Date().toLocaleDateString(),
            citas: getAppointmentsForExport()
        };

        console.log('Datos para exportar:', exportData);
    }, 2000);
}

function refreshAppointments() {
    const refreshBtn = document.getElementById('refresh-citas');
    const originalText = refreshBtn.innerHTML;

    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
    refreshBtn.disabled = true;

    // Simular actualización de datos
    setTimeout(() => {
        loadAppointmentData();
        refreshBtn.innerHTML = originalText;
        refreshBtn.disabled = false;
        showToast('Lista de citas actualizada', 'success');
    }, 1500);
}

// ===== FUNCIONES AUXILIARES =====

function formatAppointmentDate(date) {
    const options = { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' };
    return date.toLocaleDateString('es-ES', options);
}

function getDateContext(date) {
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    if (date.toDateString() === today.toDateString()) {
        return 'Hoy';
    } else if (date.toDateString() === tomorrow.toDateString()) {
        return 'Mañana';
    } else {
        return 'Próxima';
    }
}

function getAppointmentTypeText(type) {
    const typeMap = {
        'consulta': 'Consulta',
        'control': 'Control',
        'emergencia': 'Urgencia',
        'seguimiento': 'Seguimiento'
    };
    return typeMap[type] || type;
}

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

function updateAppointmentStats() {
    // En una implementación real, esto calcularía las estadísticas actuales
    console.log('Actualizando estadísticas de citas...');
}

function getAppointmentsForExport() {
    // En una implementación real, esto obtendría los datos actuales de las citas
    const appointments = [];
    document.querySelectorAll('.appointments-table tbody tr').forEach(row => {
        if (row.style.display !== 'none') {
            appointments.push({
                paciente: row.querySelector('.patient-info strong').textContent,
                medico: row.cells[2].textContent,
                fecha: row.cells[0].querySelector('strong').textContent,
                estado: row.querySelector('.status-badge').textContent
            });
        }
    });
    return appointments;
}

function initializeSampleData() {
    // Datos de ejemplo para demostración
    console.log('Inicializando datos de ejemplo para gestión de citas');
}

function loadAppointmentData() {
    // En una implementación real, esto cargaría datos del servidor
    console.log('Cargando datos de citas...');
}

// ===== FUNCIONES GLOBALES =====

window.sendAppointmentReminder = function (patientName) {
    showToast(`Recordatorio enviado a ${patientName}`, 'success');
    console.log(`Enviando recordatorio a: ${patientName}`);
};

window.rescheduleAppointmentFromDetails = function (patientName) {
    showNewAppointmentModal();
    console.log(`Reagendando cita para: ${patientName}`);
};

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
console.log('Script de gestión de citas completamente cargado');