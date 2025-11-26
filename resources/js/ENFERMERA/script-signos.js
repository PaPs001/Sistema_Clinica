// script-signos.js - FUNCIONALIDAD COMPLETA MEJORADA
document.addEventListener('DOMContentLoaded', function () {
    console.log('Página Signos Vitales cargada');
    cargarSignosVitales();
    cargarPacientes();

    const nuevoRegistroBtn = document.getElementById('nuevo-registro');
    if (nuevoRegistroBtn) {
        nuevoRegistroBtn.addEventListener('click', showNewVitalSignsForm);
    }

    const filterPatient = document.getElementById('filter-patient');
    const filterDate = document.getElementById('filter-date');

    if (filterPatient) {
        filterPatient.addEventListener('change', cargarSignosVitales);
    }

    if (filterDate) {
        filterDate.addEventListener('change', cargarSignosVitales);
    }
});

async function cargarPacientes() {
    try {
        const response = await fetch('/api/pacientes');
        if (response.ok) {
            const pacientes = await response.json();
            window.pacientesData = pacientes;

            const filterSelect = document.getElementById('filter-patient');
            if (filterSelect && pacientes.length > 0) {
                filterSelect.innerHTML = '<option value="">Todos los pacientes</option>';
                pacientes.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = p.name;
                    filterSelect.appendChild(option);
                });
            }
        }
    } catch (error) {
        console.error('Error al cargar pacientes:', error);
    }
}

async function cargarSignosVitales() {
    const tbody = document.querySelector('.vitals-table tbody');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Cargando...</td></tr>';

    try {
        const filterPatient = document.getElementById('filter-patient')?.value || '';
        const filterDate = document.getElementById('filter-date')?.value || '';

        const params = new URLSearchParams();
        if (filterPatient) params.append('patient_id', filterPatient);
        if (filterDate) params.append('date_filter', filterDate);

        const response = await fetch(`/api/signos-vitales?${params}`);

        if (response.ok) {
            const signos = await response.json();
            renderSignosVitales(signos);
        } else {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error al cargar datos</td></tr>';
        }
    } catch (error) {
        console.error('Error:', error);
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error de conexión</td></tr>';
    }
}

function renderSignosVitales(signos) {
    const tbody = document.querySelector('.vitals-table tbody');

    if (signos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay registros</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    signos.forEach(signo => {
        const row = document.createElement('tr');
        const presionClass = esPresionCritica(signo.blood_pressure) ? 'high' : '';
        const tempClass = signo.temperature > 38 ? 'high' : '';

        row.innerHTML = `
            <td>
                <div class="patient-info">
                    <div class="patient-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <strong>${signo.patient_name}</strong>
                        <span>Habitación N/A</span>
                    </div>
                </div>
            </td>
            <td>${formatearHora(signo.created_at)}</td>
            <td><span class="vital-reading ${presionClass}">${signo.blood_pressure || 'N/A'}</span></td>
            <td><span class="vital-reading">${signo.heart_rate} lpm</span></td>
            <td><span class="vital-reading ${tempClass}">${signo.temperature}°C</span></td>
            <td><span class="vital-reading">${signo.respiratory_rate} rpm</span></td>
            <td><span class="vital-reading">${signo.oxygen_saturation}%</span></td>
            <td>
                <button class="btn-view-enfermera" onclick="editarSignos(${signo.id})">Editar</button>
                <button class="btn-cancel" onclick="eliminarSignos(${signo.id})">Eliminar</button>
            </td>
        `;

        tbody.appendChild(row);
    });
}

function showNewVitalSignsForm() {
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
                            <div class="form-group">
                                <label>Peso (kg) *</label>
                                <input type="number" id="weight" step="0.1" placeholder="Ej: 70.5" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Altura (cm) *</label>
                            <input type="number" id="height" step="0.1" placeholder="Ej: 175" required>
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
    if (window.pacientesData) {
        window.pacientesData.forEach(p => {
            const option = document.createElement('option');
            option.value = p.id;
            option.textContent = p.name;
            select.appendChild(option);
        });
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
            oxygen_saturation: document.getElementById('oxygen-saturation').value,
            weight: document.getElementById('weight').value,
            height: document.getElementById('height').value
        };

        try {
            const response = await fetch('/api/signos-vitales', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                mostrarNotificacion('✅ Signos vitales registrados exitosamente', 'success');
                modal.remove();
                cargarSignosVitales();
            } else {
                const error = await response.json();
                mostrarNotificacion('❌ Error al guardar: ' + (error.message || 'Error desconocido'), 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('❌ Error de conexión al guardar signos vitales', 'error');
        }
    });
}

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

// Exponer funciones al scope global para que funcionen con onclick
window.editarSignos = editarSignos;
window.eliminarSignos = eliminarSignos;

async function editarSignos(id) {
    try {
        // Obtener los datos actuales del signo vital
        const response = await fetch(`/api/signos-vitales`);
        if (!response.ok) {
            mostrarNotificacion('❌ Error al cargar datos', 'error');
            return;
        }

        const signos = await response.json();
        const signo = signos.find(s => s.id === id);

        if (!signo) {
            mostrarNotificacion('❌ Registro no encontrado', 'error');
            return;
        }

        // Crear formulario de edición
        const formHTML = `
            <div class="modal-overlay active">
                <div class="modal">
                    <div class="modal-header">
                        <h3>Editar Signos Vitales</h3>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-vitals-form">
                            <div class="form-group">
                                <label>Paciente</label>
                                <input type="text" value="${signo.patient_name}" disabled style="background: #f5f5f5;">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div class="form-group">
                                    <label>Presión Arterial (mmHg) *</label>
                                    <input type="text" id="edit-blood-pressure" value="${signo.blood_pressure || ''}" placeholder="Ej: 120/80" required>
                                </div>
                                <div class="form-group">
                                    <label>Frecuencia Cardíaca (lpm) *</label>
                                    <input type="number" id="edit-heart-rate" value="${signo.heart_rate || ''}" placeholder="Ej: 75" required>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div class="form-group">
                                    <label>Temperatura (°C) *</label>
                                    <input type="number" id="edit-temperature" value="${signo.temperature || ''}" step="0.1" placeholder="Ej: 36.8" required>
                                </div>
                                <div class="form-group">
                                    <label>Frecuencia Respiratoria (rpm) *</label>
                                    <input type="number" id="edit-respiratory-rate" value="${signo.respiratory_rate || ''}" placeholder="Ej: 16" required>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div class="form-group">
                                    <label>Sat. Oxígeno (%) *</label>
                                    <input type="number" id="edit-oxygen-saturation" value="${signo.oxygen_saturation || ''}" placeholder="Ej: 98" min="0" max="100" required>
                                </div>
                                <div class="form-group">
                                    <label>Peso (kg)</label>
                                    <input type="number" id="edit-weight" value="${signo.weight || ''}" step="0.1" placeholder="Ej: 70.5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Altura (cm)</label>
                                <input type="number" id="edit-height" value="${signo.height || ''}" step="0.1" placeholder="Ej: 175">
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn-cancel">Cancelar</button>
                                <button type="submit" class="btn-primary">Actualizar Registro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', formHTML);

        const modal = document.querySelector('.modal-overlay');
        const closeBtn = modal.querySelector('.close-modal');
        const cancelBtn = modal.querySelector('.btn-cancel');
        const form = document.getElementById('edit-vitals-form');

        closeBtn.addEventListener('click', () => modal.remove());
        cancelBtn.addEventListener('click', () => modal.remove());
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.remove();
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const payload = {
                blood_pressure: document.getElementById('edit-blood-pressure').value,
                heart_rate: document.getElementById('edit-heart-rate').value,
                temperature: document.getElementById('edit-temperature').value,
                respiratory_rate: document.getElementById('edit-respiratory-rate').value,
                oxygen_saturation: document.getElementById('edit-oxygen-saturation').value,
                weight: document.getElementById('edit-weight').value || null,
                height: document.getElementById('edit-height').value || null
            };

            try {
                const updateResponse = await fetch(`/api/signos-vitales/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                if (updateResponse.ok) {
                    mostrarNotificacion('✅ Signos vitales actualizados exitosamente', 'success');
                    modal.remove();
                    cargarSignosVitales();
                } else {
                    const error = await updateResponse.json();
                    mostrarNotificacion('❌ Error al actualizar: ' + (error.message || 'Error desconocido'), 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarNotificacion('❌ Error de conexión al actualizar', 'error');
            }
        });

    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('❌ Error al cargar datos para edición', 'error');
    }
}

async function eliminarSignos(id) {
    // Crear modal de confirmación personalizado
    const confirmHTML = `
        <div class="modal-overlay active">
            <div class="modal" style="max-width: 400px;">
                <div class="modal-header">
                    <h3>Confirmar Eliminación</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 20px;">¿Estás seguro de que deseas eliminar este registro de signos vitales?</p>
                    <p style="color: #dc3545; font-size: 0.9rem;"><strong>⚠️ Esta acción no se puede deshacer.</strong></p>
                    <div class="form-actions" style="margin-top: 25px;">
                        <button type="button" class="btn-cancel" id="cancel-delete">Cancelar</button>
                        <button type="button" class="btn-primary" id="confirm-delete" style="background: #dc3545;">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', confirmHTML);

    const modal = document.querySelector('.modal-overlay');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-delete');
    const confirmBtn = document.getElementById('confirm-delete');

    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });

    confirmBtn.addEventListener('click', async () => {
        try {
            const response = await fetch(`/api/signos-vitales/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            if (response.ok) {
                mostrarNotificacion('✅ Registro eliminado exitosamente', 'success');
                modal.remove();
                cargarSignosVitales();
            } else {
                mostrarNotificacion('❌ Error al eliminar', 'error');
                modal.remove();
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('❌ Error de conexión', 'error');
            modal.remove();
        }
    });
}

function formatearHora(datetime) {
    if (!datetime) return 'N/A';
    const date = new Date(datetime);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
}

function esPresionCritica(presion) {
    if (!presion) return false;
    const partes = presion.split('/');
    if (partes.length !== 2) return false;
    const sistolica = parseInt(partes[0]);
    return sistolica > 140;
}