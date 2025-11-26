// script-tratamientos.js - FUNCIONALIDAD COMPLETA
console.log('Script tratamientos cargado');

let tratamientos = [];

document.addEventListener('DOMContentLoaded', function () {
    inicializarApp();
});

function inicializarApp() {
    // Cargar tratamientos
    cargarTratamientos();

    // Configurar eventos
    configurarEventos();

    // Actualizar estadísticas
    actualizarEstadisticas();
}

function configurarEventos() {
    // Botón nuevo tratamiento
    const nuevoBtn = document.getElementById('nuevo-tratamiento-btn');
    if (nuevoBtn) {
        nuevoBtn.addEventListener('click', abrirModal);
    }

    // Botón actualizar
    const refreshBtn = document.getElementById('refresh-list');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', cargarTratamientos);
    }

    // Botón limpiar filtros
    const resetBtn = document.getElementById('reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', limpiarFiltros);
    }

    // Filtros
    const filterStatus = document.getElementById('filter-status');
    if (filterStatus) {
        filterStatus.addEventListener('change', cargarTratamientos);
    }
}

async function cargarTratamientos() {
    const tbody = document.getElementById('tbody-tratamientos');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Cargando...</td></tr>';

    try {
        const filterStatus = document.getElementById('filter-status')?.value || 'todos';
        const params = new URLSearchParams();
        if (filterStatus !== 'todos') params.append('status', filterStatus);

        const response = await fetch(`/api/tratamientos?${params}`);
        if (response.ok) {
            tratamientos = await response.json();
            renderTratamientos();
        } else {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error al cargar</td></tr>';
        }
    } catch (error) {
        console.error('Error:', error);
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error de conexión</td></tr>';
    }
}

function renderTratamientos() {
    const tbody = document.getElementById('tbody-tratamientos');

    if (tratamientos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay tratamientos registrados</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    tratamientos.forEach(tratamiento => {
        const fila = document.createElement('tr');

        let badgeClass = 'activo';
        let badgeText = 'Activo';

        if (tratamiento.status === 'Completado') {
            badgeClass = 'completado';
            badgeText = 'Completado';
        } else if (tratamiento.status === 'suspendido') {
            badgeClass = 'suspendido';
            badgeText = 'Suspendido';
        }

        fila.innerHTML = `
            <td>${tratamiento.id}</td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${tratamiento.paciente?.charAt(0) || 'P'}</div>
                    <div>
                        <strong>${tratamiento.paciente || 'N/A'}</strong>
                        <span>${tratamiento.medico || 'N/A'}</span>
                    </div>
                </div>
            </td>
            <td>${tratamiento.diagnostico || 'N/A'}</td>
            <td>${tratamiento.medicamento || 'N/A'}</td>
            <td>${tratamiento.dosis || 'N/A'}</td>
            <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            <td>${formatearFecha(tratamiento.start_date)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarTratamiento(${tratamiento.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstado(${tratamiento.id})" title="Cambiar Estado">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${tratamiento.id})" title="Ver Detalles">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(fila);
    });

    actualizarEstadisticas();
}

function abrirModal() {
    const modalHTML = `
        <div class="modal-overlay" id="modal-tratamiento">
            <div class="modal">
                <div class="modal-header">
                    <h3>Nuevo Tratamiento</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-tratamiento">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Paciente *</label>
                                <select id="paciente" required>
                                    <option value="">Seleccionar paciente</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Médico Responsable</label>
                                <select id="medico">
                                    <option value="">Seleccionar médico</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Diagnóstico *</label>
                            <textarea id="diagnostico" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Medicamento *</label>
                                <input type="text" id="medicamento" required>
                            </div>
                            <div class="form-group">
                                <label>Dosis *</label>
                                <input type="text" id="dosis" placeholder="Ej: 500mg" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Frecuencia *</label>
                                <select id="frecuencia" required>
                                    <option value="">Seleccione</option>
                                    <option value="cada 6 horas">Cada 6 horas</option>
                                    <option value="cada 8 horas">Cada 8 horas</option>
                                    <option value="cada 12 horas">Cada 12 horas</option>
                                    <option value="una vez al día">Una vez al día</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Duración (días) *</label>
                                <input type="number" id="duracion" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select id="estado">
                                <option value="En seguimiento">Activo</option>
                                <option value="Completado">Completado</option>
                                <option value="suspendido">Suspendido</option>
                            </select>
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
    cargarPacientesYMedicos();
    setupModalEvents();
}

async function cargarPacientesYMedicos() {
    try {
        const [pacientesRes, medicosRes] = await Promise.all([
            fetch('/api/pacientes'),
            fetch('/api/medicos')
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
    } catch (error) {
        console.error('Error al cargar datos:', error);
    }
}

function setupModalEvents() {
    const modal = document.getElementById('modal-tratamiento');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-tratamiento');

    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });

    form.addEventListener('submit', guardarTratamiento);
}

async function guardarTratamiento(e) {
    e.preventDefault();

    const payload = {
        patient_id: document.getElementById('paciente').value,
        medico_id: document.getElementById('medico').value,
        diagnostico: document.getElementById('diagnostico').value,
        medicamento: document.getElementById('medicamento').value,
        dosis: document.getElementById('dosis').value,
        frecuencia: document.getElementById('frecuencia').value,
        duracion: document.getElementById('duracion').value,
        status: document.getElementById('estado').value
    };

    try {
        const response = await fetch('/api/tratamientos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(payload)
        });

        if (response.ok) {
            alert('Tratamiento guardado exitosamente');
            document.getElementById('modal-tratamiento').remove();
            cargarTratamientos();
        } else {
            alert('Error al guardar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

async function editarTratamiento(id) {
    alert('Edición en desarrollo. ID: ' + id);
}

async function cambiarEstado(id) {
    const nuevoEstado = prompt('Nuevo estado (En seguimiento/Completado/suspendido):');
    if (!nuevoEstado) return;

    try {
        const response = await fetch(`/api/tratamientos/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ status: nuevoEstado })
        });

        if (response.ok) {
            alert('Estado actualizado');
            cargarTratamientos();
        } else {
            alert('Error al actualizar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

function verDetalles(id) {
    const tratamiento = tratamientos.find(t => t.id === id);
    if (tratamiento) {
        alert(`Detalles del tratamiento:\n\nPaciente: ${tratamiento.paciente}\nMedicamento: ${tratamiento.medicamento}\nDosis: ${tratamiento.dosis}`);
    }
}

function limpiarFiltros() {
    document.getElementById('filter-status').value = 'todos';
    cargarTratamientos();
}

function actualizarEstadisticas() {
    const total = tratamientos.length;
    const activos = tratamientos.filter(t => t.status === 'En seguimiento').length;
    const completados = tratamientos.filter(t => t.status === 'Completado').length;

    document.getElementById('total-tratamientos').textContent = total;
    document.getElementById('tratamientos-activos').textContent = activos;
    document.getElementById('tratamientos-completados').textContent = completados;
}

function formatearFecha(fecha) {
    if (!fecha) return 'N/A';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES');
}