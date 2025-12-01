// Cargar citas semanales al cargar la p�gina
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('appointmentSearch');
    let searchTimeout = null;

    function recargar() {
        const query = searchInput ? searchInput.value.trim() : "";
        cargarCitasSemanales(query);
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(recargar, 300);
        });
    }

    recargar();
});

/**
 * Carga las citas de la semana actual desde el servidor
 */
function cargarCitasSemanales(search = "") {
    const tbody = document.getElementById('appointments-tbody');

    const params = new URLSearchParams();
    if (search) {
        params.append('q', search);
    }

    const url = '/dashboard/citas-semanales' + (params.toString() ? `?${params.toString()}` : '');

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarCitas(data.appointments);
            } else {
                mostrarError('Error al cargar las citas: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarError('Error al conectar con el servidor');
        });
}

/**
 * Muestra las citas en la tabla
 */
function mostrarCitas(appointments) {
    const tbody = document.getElementById('appointments-tbody');

    if (!appointments || appointments.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #666;">
                    <i class="fas fa-calendar-times"></i> No hay citas programadas para esta semana
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = '';

    appointments.forEach(appointment => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>${escapeHtml(appointment.patient_name)}</strong>
                        ${appointment.is_temporary ? '<span class="badge-temporal">Temporal</span>' : ''}
                    </div>
                </div>
            </td>
            <td>${escapeHtml(appointment.date)}</td>
            <td>${escapeHtml(appointment.time)}</td>
            <td>${escapeHtml(appointment.reason)}</td>
            <td><span class="status-badge status-agendada">${escapeHtml(appointment.status)}</span></td>
            <td>
                <button class="btn-primary btn-iniciar-cita" data-appointment-id="${appointment.id}">
                    <i class="fas fa-play"></i> Iniciar Cita
                </button>
            </td>
        `;

        tbody.appendChild(row);
    });

    // Agregar event listeners a los botones
    document.querySelectorAll('.btn-iniciar-cita').forEach(button => {
        button.addEventListener('click', function () {
            const appointmentId = this.getAttribute('data-appointment-id');
            iniciarCita(appointmentId);
        });
    });
}

/**
 * Redirige al formulario de registro de expediente con el ID de la cita
 */
function iniciarCita(appointmentId) {
    window.location.href = `/registro-expediente?appointment_id=${appointmentId}`;
}

/**
 * Muestra un mensaje de error en la tabla
 */
function mostrarError(mensaje) {
    const tbody = document.getElementById('appointments-tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="6" style="text-align: center; padding: 20px; color: #e74c3c;">
                <i class="fas fa-exclamation-triangle"></i> ${escapeHtml(mensaje)}
            </td>
        </tr>
    `;
}

/**
 * Escapa caracteres HTML para prevenir XSS
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
