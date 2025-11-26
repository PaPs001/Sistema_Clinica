// script-signos.js - FUNCIONALIDAD COMPLETA
document.addEventListener('DOMContentLoaded', function () {
    console.log('Página Signos Vitales cargada');

    // Cargar signos vitales al iniciar
    cargarSignosVitales();

    // Cargar lista de pacientes
    cargarPacientes();

    // Botón nuevo registro
    const nuevoRegistroBtn = document.getElementById('nuevo-registro');
    if (nuevoRegistroBtn) {
        nuevoRegistroBtn.addEventListener('click', showNewVitalSignsForm);
    }

    // Filtros
    const filterPatient = document.getElementById('filter-patient');
    const filterDate = document.getElementById('filter-date');

    if (filterPatient) {
        filterPatient.addEventListener('change', cargarSignosVitales);
    }

    if (filterDate) {
        filterDate.addEventListener('change', cargarSignosVitales);
    }
});

// Cargar lista de pacientes para el select
async function cargarPacientes() {
    try {
        const response = await fetch('/api/pacientes');
        if (response.ok) {
            const pacientes = await response.json();
            window.pacientesData = pacientes; // Guardar para uso global
        }
    } catch (error) {
        console.error('Error al cargar pacientes:', error);
    }
}

// Cargar signos vitales desde la API
async function cargarSignosVitales() {
    const tbody = document.querySelector('.vitals-table tbody');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Cargando...</td></tr>';

    try {
        const filterPatient = document.getElementById('filter-patient')?.value || '';
        const filterDate = document.getElementById('filter-date')?.value || 'today';

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

// Renderizar signos vitales en la tabla
function renderSignosVitales(signos) {
    const tbody = document.querySelector('.vitals-table tbody');

    if (signos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay registros</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    signos.forEach(signo => {
        const row = document.createElement('tr');

        // Determinar si los valores son críticos
        const presionClass = esPresionCritica(signo.blood_pressure) ? 'high' : '';
        const tempClass = signo.temperature > 38 ? 'high' : '';

        row.innerHTML = `
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">
                        <i class="fas fa-user"></i>
                    </div>
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

// Mostrar formulario de nuevo registro
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
                        <div class="form-group">
                            <label>Presión Arterial (mmHg) *</label>
                            <input type="text" id="blood-pressure" placeholder="Ej: 120/80" required>
                        </div>
                        <div class="form-group">
                            <label>Frecuencia Cardíaca (lpm) *</label>
                            <input type="number" id="heart-rate" placeholder="Ej: 75" required>
                        </div>
                        <div class="form-group">
                            <label>Temperatura (°C) *</label>
                            <input type="number" id="temperature" step="0.1" placeholder="Ej: 36.8" required>
                        </div>
                        <div class="form-group">
                            <label>Frecuencia Respiratoria (rpm) *</label>
                            <input type="number" id="respiratory-rate" placeholder="Ej: 16" required>
                        </div>
                        <div class="form-group">
                            <label>Sat. Oxígeno (%) *</label>
                            <input type="number" id="oxygen-saturation" placeholder="Ej: 98" required>
                        </div>
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea id="notes" rows="3" placeholder="Notas adicionales..."></textarea>
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

    // Cargar pacientes en el select
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

// Configurar modal
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
            notes: document.getElementById('notes').value
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
                alert('Signos vitales registrados exitosamente');
                modal.remove();
                cargarSignosVitales(); // Recargar tabla
            } else {
                const error = await response.json();
                alert('Error al guardar: ' + (error.message || 'Error desconocido'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión al guardar signos vitales');
        }
    });
}

// Editar signos vitales
async function editarSignos(id) {
    alert('Función de edición en desarrollo. ID: ' + id);
    // TODO: Implementar edición completa
}

// Eliminar signos vitales
async function eliminarSignos(id) {
    if (!confirm('¿Estás seguro de eliminar este registro?')) return;

    try {
        const response = await fetch(`/api/signos-vitales/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            alert('Registro eliminado exitosamente');
            cargarSignosVitales(); // Recargar tabla
        } else {
            alert('Error al eliminar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

// Utilidades
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