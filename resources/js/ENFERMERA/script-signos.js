// script-signos.js - Registro de signos vitales basado en citas del día

document.addEventListener('DOMContentLoaded', function () {
    console.log('Página Signos Vitales cargada');

    const nuevoRegistroBtn = document.getElementById('nuevo-registro');
    if (nuevoRegistroBtn) {
        nuevoRegistroBtn.addEventListener('click', function () {
            showNewVitalSignsForm();
        });
    }

    const filterPatientName = document.getElementById('filter-patient-name');
    const filterDoctorName = document.getElementById('filter-doctor-name');
    const filterDate = document.getElementById('filter-date');

    if (filterPatientName) {
        filterPatientName.addEventListener('input', function () {
            cargarCitasParaSignos(false);
        });
    }

    if (filterDoctorName) {
        filterDoctorName.addEventListener('input', function () {
            cargarCitasParaSignos(false);
        });
    }

    if (filterDate) {
        filterDate.addEventListener('change', function () {
            cargarCitasParaSignos(false);
        });
    }

    // Cargar citas del día al iniciar
    cargarCitasParaSignos(true);
});

// ==================== LISTADO PRINCIPAL ====================

async function cargarCitasParaSignos(updatePatientList = false) {
    const tbody = document.querySelector('.vitals-table tbody');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">Cargando...</td></tr>';

    try {
        const filterPatientName = document.getElementById('filter-patient-name')?.value || '';
        const filterDoctorName = document.getElementById('filter-doctor-name')?.value || '';
        const filterDate = document.getElementById('filter-date')?.value || '';

        const params = new URLSearchParams();
        if (filterPatientName) {
            params.append('patient_name', filterPatientName);
        }
        if (filterDoctorName) {
            params.append('doctor_name', filterDoctorName);
        }
        if (filterDate) {
            params.append('date_filter', filterDate);
        }

        const response = await fetch(`/api/citas-signos?${params.toString()}`);

        if (!response.ok) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: red;">Error al cargar datos</td></tr>';
            return;
        }

        const citas = await response.json();
        renderCitasParaSignos(citas);

        if (updatePatientList) {
            actualizarPacientesDesdeCitas(citas);
        }
    } catch (error) {
        console.error('Error al cargar citas para signos:', error);
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: red;">Error de conexión</td></tr>';
    }
}

function renderCitasParaSignos(citas) {
    const tbody = document.querySelector('.vitals-table tbody');
    if (!tbody) return;

    if (!citas || citas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay citas para el período seleccionado</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    citas.forEach(cita => {
        const row = document.createElement('tr');
        const hora = (cita.appointment_time || '').substring(0, 5);

        row.innerHTML = `
            <td>
                <div class="patient-info">
                    <div class="patient-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <strong>${cita.paciente}</strong>
                    </div>
                </div>
            </td>
            <td>${hora || 'N/A'}</td>
            <td>${cita.medico || 'N/A'}</td>
            <td>
                <button class="btn-view-enfermera btn-registrar-signos" data-patient-id="${cita.patient_id}">
                    Registrar
                </button>
            </td>
        `;

        tbody.appendChild(row);

        const registrarBtn = row.querySelector('.btn-registrar-signos');
        if (registrarBtn) {
            registrarBtn.addEventListener('click', function () {
                const patientId = registrarBtn.getAttribute('data-patient-id');
                if (patientId) {
                    abrirRegistroSignos(patientId);
                }
            });
        }
    });
}

function actualizarPacientesDesdeCitas(citas) {
    const pacientesData = [];
    const vistos = new Set();

    citas.forEach(cita => {
        if (cita.patient_id && cita.paciente && !vistos.has(cita.patient_id)) {
            vistos.add(cita.patient_id);
            pacientesData.push({
                id: cita.patient_id,
                name: cita.paciente,
            });
        }
    });

    window.pacientesData = pacientesData;
}

// ==================== NUEVO REGISTRO ====================

function abrirRegistroSignos(patientId) {
    showNewVitalSignsForm(patientId);
}

function showNewVitalSignsForm(patientId = null) {
    const formHTML = `
        <div class="modal-overlay active">
            <div class="modal">
                <div class="modal-header">
                    <h3>Nuevo Registro de Signos Vitales</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="new-vitals-form">
                        <div class="form-group">
                            <label>Paciente *</label>
                            <select id="patient-select" required>
                                <option value="">Seleccionar paciente</option>
                            </select>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>Presión Arterial (mmHg) *</label>
                                <input type="text" id="blood-pressure" placeholder="Ej: 120/80" required>
                            </div>
                            <div class="form-group">
                                <label>Frecuencia Cardíaca (lpm) *</label>
                                <input type="number" id="heart-rate" placeholder="Ej: 75" required>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>Temperatura (°C) *</label>
                                <input type="number" id="temperature" step="0.1" placeholder="Ej: 36.8" required>
                            </div>
                            <div class="form-group">
                                <label>Frecuencia Respiratoria (rpm) *</label>
                                <input type="number" id="respiratory-rate" placeholder="Ej: 16" required>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>Sat. Oxígeno (%) *</label>
                                <input type="number" id="oxygen-saturation" placeholder="Ej: 98" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel">Cancelar</button>
                            <button type="submit" class="btn-primary">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', formHTML);

    const select = document.getElementById('patient-select');
    if (window.pacientesData && Array.isArray(window.pacientesData)) {
        window.pacientesData.forEach(p => {
            const option = document.createElement('option');
            option.value = p.id;
            option.textContent = p.name;
            select.appendChild(option);
        });
    }

    if (patientId && select) {
        select.value = String(patientId);
    }

    setupVitalsModal();
}

function setupVitalsModal() {
    const modal = document.querySelector('.modal-overlay');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = modal.querySelector('.btn-cancel');
    const form = document.getElementById('new-vitals-form');

    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            patient_id: document.getElementById('patient-select').value,
            blood_pressure: document.getElementById('blood-pressure').value,
            heart_rate: document.getElementById('heart-rate').value,
            temperature: document.getElementById('temperature').value,
            respiratory_rate: document.getElementById('respiratory-rate').value,
            oxygen_saturation: document.getElementById('oxygen-saturation').value
        };

        try {
            const response = await fetch('/api/signos-vitales', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                mostrarNotificacion('✅ Signos vitales registrados exitosamente', 'success');
                modal.remove();
                cargarCitasParaSignos(false);
            } else {
                const error = await response.json().catch(() => ({}));
                mostrarNotificacion('❌ Error al guardar: ' + (error.message || 'Error desconocido'), 'error');
            }
        } catch (error) {
            console.error('Error al guardar signos vitales:', error);
            mostrarNotificacion('❌ Error de conexión al guardar signos vitales', 'error');
        }
    });
}

// ==================== NOTIFICACIONES ====================

function mostrarNotificacion(mensaje, tipo = 'success') {
    const notifAnterior = document.querySelector('.custom-notification');
    if (notifAnterior) notifAnterior.remove();

    const notificacion = document.createElement('div');
    notificacion.className = `custom-notification ${tipo}`;
    notificacion.innerHTML = `
        <div class="notification-content">
            <span>${mensaje}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;

    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${tipo === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        max-width: 400px;
    `;

    document.body.appendChild(notificacion);

    notificacion.querySelector('.notification-close').addEventListener('click', () => {
        notificacion.remove();
    });

    setTimeout(() => {
        if (notificacion.parentElement) {
            notificacion.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notificacion.remove(), 300);
        }
    }, 3000);
}

// Animaciones CSS para las notificaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
    .notification-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }
    .notification-close {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }
`;
document.head.appendChild(style);

