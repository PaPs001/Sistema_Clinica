// script-pacientes.js - FUNCIONALIDAD COMPLETA
console.log('Script pacientes cargado');

let pacientes = [];

document.addEventListener('DOMContentLoaded', function () {
    inicializarApp();
});

function inicializarApp() {
    cargarPacientes();
    configurarEventos();
}

function configurarEventos() {
    // Botón actualizar
    const refreshBtn = document.getElementById('refresh-list');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', cargarPacientes);
    }

    // Botón limpiar filtros
    const resetBtn = document.getElementById('reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', limpiarFiltros);
    }

    // Filtros
    const filterStatus = document.getElementById('filter-status');
    if (filterStatus) {
        filterStatus.addEventListener('change', aplicarFiltros);
    }

    // Configurar clicks en filas de pacientes
    setupRowClicks();
}

async function cargarPacientes() {
    try {
        const response = await fetch('/api/pacientes');
        if (response.ok) {
            pacientes = await response.json();
            renderPacientes();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function renderPacientes() {
    // Los pacientes ya están en el HTML estático
    // Aquí podríamos actualizar dinámicamente si fuera necesario
    setupRowClicks();
}

function setupRowClicks() {
    const rows = document.querySelectorAll('.patient-row');
    rows.forEach(row => {
        row.addEventListener('click', function () {
            const patientId = this.dataset.patient;
            mostrarDetallesPaciente(patientId);
        });
    });

    // Botones de acción
    const viewBtns = document.querySelectorAll('.btn-view');
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const row = this.closest('tr');
            const patientId = row.dataset.patient;
            verHistorial(patientId);
        });
    });

    const actionBtns = document.querySelectorAll('.btn-action');
    actionBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const row = this.closest('tr');
            const patientId = row.dataset.patient;
            registrarSignos(patientId);
        });
    });

    const editBtns = document.querySelectorAll('.btn-edit');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const row = this.closest('tr');
            const patientId = row.dataset.patient;
            editarPaciente(patientId);
        });
    });
}

function mostrarDetallesPaciente(patientId) {
    const detailsDiv = document.getElementById('patient-details');
    if (!detailsDiv) return;

    detailsDiv.innerHTML = `
        <div class="detail-group">
            <h4>Información del Paciente: ${patientId}</h4>
            <p>Cargando detalles...</p>
        </div>
    `;

    // Cargar detalles desde API
    fetch(`/api/pacientes/${patientId}/historial`)
        .then(res => res.json())
        .then(data => {
            detailsDiv.innerHTML = `
                <div class="detail-group">
                    <h4>Últimos Signos Vitales</h4>
                    <div class="vitals-list">
                        ${data.signos?.slice(0, 3).map(s => `
                            <div class="vital-item">
                                <strong>${new Date(s.created_at).toLocaleDateString()}</strong>
                                <span>PA: ${s.blood_pressure || 'N/A'}</span>
                                <span>FC: ${s.heart_rate} lpm</span>
                                <span>Temp: ${s.temperature}°C</span>
                            </div>
                        `).join('') || '<p>No hay registros</p>'}
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            detailsDiv.innerHTML = '<p>Error al cargar detalles</p>';
        });
}

async function verHistorial(patientId) {
    alert(`Ver historial completo del paciente: ${patientId}\n\nEsta función abrirá una vista detallada.`);
}

function registrarSignos(patientId) {
    // Redirigir a la página de signos vitales
    window.location.href = '/signos-vitales';
}

function editarPaciente(patientId) {
    alert(`Editar paciente: ${patientId}\n\nFunción en desarrollo.`);
}

function aplicarFiltros() {
    const filterStatus = document.getElementById('filter-status')?.value;
    const rows = document.querySelectorAll('.patient-row');

    rows.forEach(row => {
        if (!filterStatus || filterStatus === '') {
            row.style.display = '';
        } else {
            const rowStatus = row.classList.contains(filterStatus);
            row.style.display = rowStatus ? '' : 'none';
        }
    });
}

function limpiarFiltros() {
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-ward').value = '';
    document.getElementById('filter-doctor').value = '';
    aplicarFiltros();
}