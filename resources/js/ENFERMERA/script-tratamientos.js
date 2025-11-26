// script-tratamientos.js - FUNCIONALIDAD COMPLETA MEJORADA
console.log('Script tratamientos cargado');

let tratamientos = [];
let pacientesData = [];
let medicosData = [];

document.addEventListener('DOMContentLoaded', function () {
    inicializarApp();
});

function inicializarApp() {
    cargarPacientes();
    cargarMedicos();
    cargarTratamientos();
    configurarEventos();
}

function configurarEventos() {
    // Botón nuevo tratamiento
    const nuevoBtn = document.getElementById('nuevo-tratamiento-btn');
    if (nuevoBtn) {
        nuevoBtn.addEventListener('click', abrirModalNuevoTratamiento);
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

    // Filtros - IDs correctos del HTML
    const filterStatus = document.getElementById('filter-status');
    const filterPatient = document.getElementById('filter-paciente');
    const filterDoctor = document.getElementById('filter-medico');

    if (filterStatus) {
        filterStatus.addEventListener('change', aplicarFiltros);
    }
    if (filterPatient) {
        filterPatient.addEventListener('change', aplicarFiltros);
    }
    if (filterDoctor) {
        filterDoctor.addEventListener('change', aplicarFiltros);
    }
}

async function cargarPacientes() {
    try {
        const response = await fetch('/api/pacientes');
        if (response.ok) {
            pacientesData = await response.json();

            // Llenar filtro de pacientes - ID correcto del HTML
            const filterSelect = document.getElementById('filter-paciente');
            if (filterSelect && pacientesData.length > 0) {
                filterSelect.innerHTML = '<option value="">Todos los pacientes</option>';
                pacientesData.forEach(p => {
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

async function cargarMedicos() {
    try {
        const response = await fetch('/api/medicos');
        if (response.ok) {
            medicosData = await response.json();

            // Llenar filtro de médicos - ID correcto del HTML
            const filterSelect = document.getElementById('filter-medico');
            if (filterSelect && medicosData.length > 0) {
                filterSelect.innerHTML = '<option value="">Todos los médicos</option>';
                medicosData.forEach(m => {
                    const option = document.createElement('option');
                    option.value = m.id;
                    option.textContent = m.name;
                    filterSelect.appendChild(option);
                });
            }
        }
    } catch (error) {
        console.error('Error al cargar médicos:', error);
    }
}

async function cargarTratamientos() {
    const tbody = document.getElementById('tbody-tratamientos');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Cargando...</td></tr>';

    try {
        const response = await fetch('/api/tratamientos');
        if (response.ok) {
            tratamientos = await response.json();
            aplicarFiltros();
            actualizarEstadisticas();
        } else {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error al cargar</td></tr>';
        }
    } catch (error) {
        console.error('Error:', error);
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error de conexión</td></tr>';
    }
}

function aplicarFiltros() {
    const filterStatus = document.getElementById('filter-status')?.value || '';
    const filterPatient = document.getElementById('filter-paciente')?.value || '';
    const filterDoctor = document.getElementById('filter-medico')?.value || '';

    let tratamientosFiltrados = tratamientos;

    if (filterStatus && filterStatus !== 'todos') {
        tratamientosFiltrados = tratamientosFiltrados.filter(t =>
            t.status?.toLowerCase() === filterStatus.toLowerCase()
        );
    }

    if (filterPatient) {
        tratamientosFiltrados = tratamientosFiltrados.filter(t =>
            t.patient_id == filterPatient
        );
    }

    if (filterDoctor) {
        tratamientosFiltrados = tratamientosFiltrados.filter(t =>
            t.prescribed_by == filterDoctor
        );
    }

    renderTratamientos(tratamientosFiltrados);
}

function renderTratamientos(tratamientosParaMostrar = tratamientos) {
    const tbody = document.getElementById('tbody-tratamientos');

    if (tratamientosParaMostrar.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay tratamientos registrados</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    tratamientosParaMostrar.forEach(tratamiento => {
        const fila = document.createElement('tr');

        let badgeClass = 'activo';
        let badgeText = 'En Seguimiento';

        if (tratamiento.status === 'Completado') {
            badgeClass = 'completado';
            badgeText = 'Completado';
        } else if (tratamiento.status === 'suspendido') {
            badgeClass = 'suspendido';
            badgeText = 'Suspendido';
        } else if (tratamiento.status === 'En seguimiento') {
            badgeClass = 'activo';
            badgeText = 'En Seguimiento';
        }

        // Columnas: ID, Paciente, Diagnóstico, Medicamento, Dosis, Estado, Fecha Inicio, Acciones
        fila.innerHTML = `
            <td>${tratamiento.id}</td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${tratamiento.paciente?.charAt(0) || 'P'}</div>
                    <div>
                        <strong>${tratamiento.paciente || 'N/A'}</strong>
                        <span>ID: ${tratamiento.patient_id || 'N/A'}</span>
                    </div>
                </div>
            </td>
            <td>${tratamiento.diagnostico || 'N/A'}</td>
            <td>${tratamiento.medicamento || tratamiento.tratamiento || 'N/A'}</td>
            <td>${tratamiento.dosis || 'N/A'}</td>
            <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            <td>${formatearFecha(tratamiento.start_date)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-view" onclick="verDetalles(${tratamiento.id})" title="Ver">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-edit" onclick="editarTratamiento(${tratamiento.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstado(${tratamiento.id})" title="Cambiar Estado">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(fila);
    });
}

function abrirModalNuevoTratamiento() {
    const modalHTML = `
        <div class="modal-overlay active" id="modal-nuevo-tratamiento">
            <div class="modal large">
                <div class="modal-header">
                    <h3>Nuevo Tratamiento</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-nuevo-tratamiento">
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>Paciente *</label>
                                <select id="paciente-select" required>
                                    <option value="">Seleccionar paciente</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Médico Responsable *</label>
                                <select id="medico-select" required>
                                    <option value="">Seleccionar médico</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nombre del Tratamiento *</label>
                            <input type="text" id="nombre-tratamiento" placeholder="Ej: Antibiótico - Amoxicilina" required>
                        </div>
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>Fecha de Inicio *</label>
                                <input type="date" id="fecha-inicio" required>
                            </div>
                            <div class="form-group">
                                <label>Fecha de Fin *</label>
                                <input type="date" id="fecha-fin" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Notas/Observaciones</label>
                            <textarea id="notas" rows="3" placeholder="Detalles adicionales del tratamiento..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Estado Inicial</label>
                            <select id="estado-inicial">
                                <option value="En seguimiento">En Seguimiento</option>
                                <option value="Completado">Completado</option>
                                <option value="suspendido">Suspendido</option>
                            </select>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="btn-cancelar-tratamiento">Cancelar</button>
                            <button type="submit" class="btn-primary">Guardar Tratamiento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Llenar selectores
    const pacienteSelect = document.getElementById('paciente-select');
    pacientesData.forEach(p => {
        const option = document.createElement('option');
        option.value = p.id;
        option.textContent = p.name;
        pacienteSelect.appendChild(option);
    });

    const medicoSelect = document.getElementById('medico-select');
    medicosData.forEach(m => {
        const option = document.createElement('option');
        option.value = m.id;
        option.textContent = m.name;
        medicoSelect.appendChild(option);
    });

    setupModalNuevoTratamiento();
}

function setupModalNuevoTratamiento() {
    const modal = document.getElementById('modal-nuevo-tratamiento');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('btn-cancelar-tratamiento');
    const form = document.getElementById('form-nuevo-tratamiento');

    const cerrarModal = () => {
        if (modal && modal.parentElement) {
            modal.remove();
        }
    };

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cerrarModal();
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cerrarModal();
        });
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            cerrarModal();
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            patient_id: document.getElementById('paciente-select').value,
            prescribed_by: document.getElementById('medico-select').value,
            treatment_name: document.getElementById('nombre-tratamiento').value,
            start_date: document.getElementById('fecha-inicio').value,
            end_date: document.getElementById('fecha-fin').value,
            notes: document.getElementById('notas').value,
            status: document.getElementById('estado-inicial').value
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
                mostrarNotificacion('✅ Tratamiento registrado exitosamente', 'success');
                cerrarModal();
                cargarTratamientos();
            } else {
                const error = await response.json();
                mostrarNotificacion('❌ Error al guardar: ' + (error.message || 'Error desconocido'), 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('❌ Error de conexión', 'error');
        }
    });
}

function limpiarFiltros() {
    document.getElementById('filter-status').value = 'todos';
    document.getElementById('filter-paciente').value = '';
    document.getElementById('filter-medico').value = '';
    aplicarFiltros();
    mostrarNotificacion('✅ Filtros limpiados', 'success');
}

function actualizarEstadisticas() {
    const activos = tratamientos.filter(t => t.status === 'En seguimiento').length;
    const completados = tratamientos.filter(t => t.status === 'Completado').length;
    const suspendidos = tratamientos.filter(t => t.status === 'suspendido').length;

    // IDs correctos del HTML
    const totalElem = document.getElementById('total-tratamientos');
    const activosElem = document.getElementById('tratamientos-activos');
    const completadosElem = document.getElementById('tratamientos-completados');
    const pacientesActivosElem = document.getElementById('pacientes-activos');

    if (totalElem) totalElem.textContent = tratamientos.length;
    if (activosElem) activosElem.textContent = activos;
    if (completadosElem) completadosElem.textContent = completados;

    // Calcular pacientes únicos con tratamientos activos
    if (pacientesActivosElem) {
        const pacientesUnicos = new Set(
            tratamientos
                .filter(t => t.status === 'En seguimiento')
                .map(t => t.patient_id)
        );
        pacientesActivosElem.textContent = pacientesUnicos.size;
    }
}

async function cambiarEstado(id) {
    const tratamiento = tratamientos.find(t => t.id === id);
    if (!tratamiento) return;

    const modalHTML = `
        <div class="modal-overlay active" id="modal-cambiar-estado">
            <div class="modal" style="max-width: 400px;">
                <div class="modal-header">
                    <h3>Cambiar Estado</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 15px;">Estado actual: <strong>${tratamiento.status}</strong></p>
                    <div class="form-group">
                        <label>Nuevo Estado *</label>
                        <select id="nuevo-estado">
                            <option value="En seguimiento">En Seguimiento</option>
                            <option value="Completado">Completado</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="cancel-estado">Cancelar</button>
                        <button type="button" class="btn-primary" id="confirm-estado">Cambiar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = document.getElementById('modal-cambiar-estado');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-estado');
    const confirmBtn = document.getElementById('confirm-estado');

    const cerrarModal = () => {
        if (modal && modal.parentElement) {
            modal.remove();
        }
    };

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cerrarModal();
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cerrarModal();
        });
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            cerrarModal();
        }
    });

    confirmBtn.addEventListener('click', async () => {
        const nuevoEstado = document.getElementById('nuevo-estado').value;

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
                mostrarNotificacion('✅ Estado actualizado exitosamente', 'success');
                cerrarModal();
                cargarTratamientos();
            } else {
                mostrarNotificacion('❌ Error al actualizar estado', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('❌ Error de conexión', 'error');
        }
    });
}

function verDetalles(id) {
    const tratamiento = tratamientos.find(t => t.id === id);
    if (!tratamiento) return;

    const modalHTML = `
        <div class="modal-overlay active" id="modal-ver-detalles">
            <div class="modal">
                <div class="modal-header">
                    <h3>Detalles del Tratamiento</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div style="display: grid; gap: 15px;">
                        <div><strong>ID:</strong> ${tratamiento.id}</div>
                        <div><strong>Paciente:</strong> ${tratamiento.paciente}</div>
                        <div><strong>Tratamiento:</strong> ${tratamiento.tratamiento}</div>
                        <div><strong>Médico:</strong> ${tratamiento.medico}</div>
                        <div><strong>Fecha Inicio:</strong> ${formatearFecha(tratamiento.start_date)}</div>
                        <div><strong>Fecha Fin:</strong> ${formatearFecha(tratamiento.end_date)}</div>
                        <div><strong>Estado:</strong> ${tratamiento.status}</div>
                        <div><strong>Notas:</strong> ${tratamiento.notes || 'Sin notas'}</div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-primary" id="close-details">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = document.getElementById('modal-ver-detalles');
    const closeBtn = modal.querySelector('.close-modal');
    const closeDetailsBtn = document.getElementById('close-details');

    const cerrarModal = () => {
        if (modal && modal.parentElement) {
            modal.remove();
        }
    };

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cerrarModal();
        });
    }

    if (closeDetailsBtn) {
        closeDetailsBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cerrarModal();
        });
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            cerrarModal();
        }
    });
}

function editarTratamiento(id) {
    mostrarNotificacion('Función de edición en desarrollo. ID: ' + id, 'success');
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

// Exponer funciones al scope global
window.verDetalles = verDetalles;
window.editarTratamiento = editarTratamiento;
window.cambiarEstado = cambiarEstado;

function formatearFecha(fecha) {
    if (!fecha) return 'N/A';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES');
}