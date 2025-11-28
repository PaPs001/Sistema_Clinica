// script-citas.js - FUNCIONALIDAD COMPLETA
console.log('Script citas cargado');

let citas = [];

document.addEventListener('DOMContentLoaded', function () {
    inicializarApp();
});

function inicializarApp() {
    cargarCitas();
    configurarEventos();
    cargarMedicosYServicios();
}

function configurarEventos() {
    // Botón nueva cita
    const nuevaBtn = document.getElementById('nueva-cita-btn');
    if (nuevaBtn) {
        nuevaBtn.addEventListener('click', abrirModalCita);
    }

    // Botón exportar
    const exportBtn = document.getElementById('export-citas');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportarCitas);
    }

    // Botón actualizar
    const refreshBtn = document.getElementById('refresh-list');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', cargarCitas);
    }

    // Botón limpiar filtros
    const resetBtn = document.getElementById('reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', limpiarFiltros);
    }

    // Selector de fecha
    const fechaInput = document.getElementById('fecha-citas');
    if (fechaInput) {
        fechaInput.addEventListener('change', cargarCitas);
    }

    // Filtros
    const filterEstado = document.getElementById('filter-estado');
    if (filterEstado) {
        filterEstado.addEventListener('change', cargarCitas);
    }
}

async function cargarCitas() {
    const tbody = document.getElementById('tbody-citas');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Cargando...</td></tr>';

    try {
        const fecha = document.getElementById('fecha-citas')?.value || new Date().toISOString().split('T')[0];
        const estado = document.getElementById('filter-estado')?.value || 'todos';

        const params = new URLSearchParams();
        params.append('date', fecha);
        if (estado !== 'todos') params.append('status', estado);

        const response = await fetch(`/api/citas?${params}`);
        if (response.ok) {
            citas = await response.json();
            renderCitas();
            actualizarEstadisticas();
        } else {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; color: red;">Error al cargar</td></tr>';
        }
    } catch (error) {
        console.error('Error:', error);
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; color: red;">Error de conexión</td></tr>';
    }
}

function renderCitas() {
    const tbody = document.getElementById('tbody-citas');

    if (citas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">No hay citas para esta fecha</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    citas.forEach(cita => {
        const fila = document.createElement('tr');

        let badgeClass = cita.status || 'agendada';
        let badgeText = cita.status || 'Agendada';

        fila.innerHTML = `
            <td>${cita.appointment_time}</td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${cita.paciente?.charAt(0) || 'P'}</div>
                    <div>
                        <strong>${cita.paciente || 'N/A'}</strong>
                    </div>
                </div>
            </td>
            <td>${cita.medico || 'N/A'}</td>
            <td>${cita.especialidad || 'N/A'}</td>
            <td>Consultorio ${cita.id % 5 + 1}</td>
            <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarCita(${cita.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstadoCita(${cita.id})" title="Cambiar Estado">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-delete" onclick="eliminarCita(${cita.id})" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(fila);
    });
}

function abrirModalCita() {
    const modalHTML = `
        <div class="modal-overlay active" id="modal-cita">
            <div class="modal">
                <div class="modal-header">
                    <h3>Nueva Cita</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-cita">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Paciente *</label>
                                <select id="paciente" required>
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Médico *</label>
                                <select id="medico" required>
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Fecha *</label>
                                <input type="date" id="fecha" required>
                            </div>
                            <div class="form-group">
                                <label>Hora *</label>
                                <input type="time" id="hora" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Especialidad *</label>
                                <select id="especialidad" required>
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Estado</label>
                                <select id="estado">
                                    <option value="agendada">Agendada</option>
                                    <option value="Confirmada">Confirmada</option>
                                    <option value="En curso">En curso</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Motivo *</label>
                            <textarea id="motivo" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Notas</label>
                            <textarea id="notas"></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="cancel-form">Cancelar</button>
                            <button type="submit" class="btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    cargarDatosModal();
    setupModalCitaEvents();
}

async function cargarDatosModal() {
    try {
        const [pacientesRes, medicosRes, serviciosRes] = await Promise.all([
            fetch('/api/pacientes'),
            fetch('/api/medicos'),
            fetch('/api/servicios')
        ]);

        if (pacientesRes.ok) {
            const pacientes = await pacientesRes.json();
            const select = document.getElementById('paciente');
            pacientes.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.name;
                select.appendChild(option);
            });
        }

        if (medicosRes.ok) {
            const medicos = await medicosRes.json();
            const select = document.getElementById('medico');
            medicos.forEach(m => {
                const option = document.createElement('option');
                option.value = m.id;
                option.textContent = m.name;
                select.appendChild(option);
            });
        }

        if (serviciosRes.ok) {
            const servicios = await serviciosRes.json();
            const select = document.getElementById('especialidad');
            servicios.forEach(s => {
                const option = document.createElement('option');
                option.value = s.id;
                option.textContent = s.name;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function setupModalCitaEvents() {
    const modal = document.getElementById('modal-cita');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-cita');

    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });

    form.addEventListener('submit', guardarCita);
}

async function guardarCita(e) {
    e.preventDefault();

    const payload = {
        patient_id: document.getElementById('paciente').value,
        doctor_id: document.getElementById('medico').value,
        services_id: document.getElementById('especialidad').value,
        appointment_date: document.getElementById('fecha').value,
        appointment_time: document.getElementById('hora').value,
        reason: document.getElementById('motivo').value,
        notes: document.getElementById('notas').value,
        status: document.getElementById('estado').value
    };

    try {
        const response = await fetch('/api/citas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(payload)
        });

        if (response.ok) {
            alert('Cita creada exitosamente');
            document.getElementById('modal-cita').remove();
            cargarCitas();
        } else {
            alert('Error al guardar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

async function editarCita(id) {
    alert('Edición en desarrollo. ID: ' + id);
}

async function cambiarEstadoCita(id) {
    const nuevoEstado = prompt('Nuevo estado (agendada/Confirmada/En curso/completada/cancelada):');
    if (!nuevoEstado) return;

    try {
        const response = await fetch(`/api/citas/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ status: nuevoEstado })
        });

        if (response.ok) {
            alert('Estado actualizado');
            cargarCitas();
        } else {
            alert('Error al actualizar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

async function eliminarCita(id) {
    if (!confirm('¿Eliminar esta cita?')) return;

    try {
        const response = await fetch(`/api/citas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            alert('Cita eliminada');
            cargarCitas();
        } else {
            alert('Error al eliminar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

function exportarCitas() {
    alert('Función de exportación en desarrollo');
}

function limpiarFiltros() {
    document.getElementById('filter-estado').value = 'todos';
    cargarCitas();
}

function actualizarEstadisticas() {
    const total = citas.length;
    const pendientes = citas.filter(c => c.status === 'agendada' || c.status === 'Sin confirmar').length;
    const enCurso = citas.filter(c => c.status === 'En curso').length;
    const completadas = citas.filter(c => c.status === 'completada').length;

    document.getElementById('total-citas').textContent = total;
    document.getElementById('citas-pendientes').textContent = pendientes;
    document.getElementById('citas-curso').textContent = enCurso;
    document.getElementById('citas-completadas').textContent = completadas;
}

async function cargarMedicosYServicios() {
    // Cargar para filtros si es necesario
}
