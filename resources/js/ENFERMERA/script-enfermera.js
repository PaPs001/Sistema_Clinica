// script-enfermera.js - DASHBOARD FUNCIONALIDAD COMPLETA
console.log('Script dashboard enfermera cargado');

document.addEventListener('DOMContentLoaded', function () {
    inicializarDashboard();
});

function inicializarDashboard() {
    cargarAlertas();
    cargarTareas();
    configurarEventos();
}

function configurarEventos() {
    // Botón filtrar alertas
    const filterAlertsBtn = document.getElementById('filter-alerts');
    if (filterAlertsBtn) {
        filterAlertsBtn.addEventListener('click', () => {
            alert('Filtro de alertas en desarrollo');
        });
    }

    // Botón marcar todo como leído
    const markAllBtn = document.getElementById('mark-all-read');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', marcarTodasLeidas);
    }

    // Botón filtrar pacientes
    const filterPatientsBtn = document.getElementById('filter-patients');
    if (filterPatientsBtn) {
        filterPatientsBtn.addEventListener('click', () => {
            alert('Filtro de pacientes en desarrollo');
        });
    }

    // Botón exportar pacientes
    const exportBtn = document.getElementById('export-patients');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportarPacientes);
    }

    // Botones de alertas
    setupAlertButtons();

    // Botones de pacientes
    setupPatientButtons();

    // Botones de tareas
    setupTaskButtons();
}

async function cargarAlertas() {
    try {
        const response = await fetch('/api/alertas');
        if (response.ok) {
            const alertas = await response.json();
            renderAlertas(alertas);
        }
    } catch (error) {
        console.error('Error al cargar alertas:', error);
    }
}

function renderAlertas(alertas) {
    const container = document.querySelector('.alerts-grid');
    if (!container || alertas.length === 0) return;

    // Las alertas ya están en el HTML, aquí podríamos actualizarlas dinámicamente
    console.log('Alertas cargadas:', alertas);
}

async function cargarTareas() {
    try {
        const response = await fetch('/api/tareas');
        if (response.ok) {
            const tareas = await response.json();
            renderTareas(tareas);
        }
    } catch (error) {
        console.error('Error al cargar tareas:', error);
    }
}

function renderTareas(tareas) {
    const container = document.querySelector('.tasks-list');
    if (!container || tareas.length === 0) return;

    // Las tareas ya están en el HTML
    console.log('Tareas cargadas:', tareas);
}

function setupAlertButtons() {
    const atenderBtns = document.querySelectorAll('.alert-card .btn-view');
    atenderBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const alertCard = this.closest('.alert-card');
            const paciente = alertCard.querySelector('strong').textContent.split(': ')[1];
            atenderAlerta(paciente);
        });
    });

    const posponerBtns = document.querySelectorAll('.alert-card .btn-cancel');
    posponerBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const alertCard = this.closest('.alert-card');
            posponerAlerta(alertCard);
        });
    });
}

function setupPatientButtons() {
    const signosBtns = document.querySelectorAll('.patients-table .btn-view');
    signosBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            window.location.href = '/signos-vitales';
        });
    });

    const medicarBtns = document.querySelectorAll('.patients-table .btn-cancel');
    medicarBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            window.location.href = '/tratamientos';
        });
    });
}

function setupTaskButtons() {
    const taskBtns = document.querySelectorAll('.task-item .btn-view');
    taskBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const task = this.closest('.task-item');
            const titulo = task.querySelector('h4').textContent;
            realizarTarea(titulo);
        });
    });
}

function atenderAlerta(paciente) {
    if (confirm(`¿Atender alerta de ${paciente}?`)) {
        alert('Redirigiendo a registro de signos vitales...');
        window.location.href = '/signos-vitales';
    }
}

function posponerAlerta(alertCard) {
    if (confirm('¿Posponer esta alerta?')) {
        alertCard.style.opacity = '0.5';
        setTimeout(() => {
            alertCard.remove();
            alert('Alerta pospuesta');
        }, 300);
    }
}

function marcarTodasLeidas() {
    if (confirm('¿Marcar todas las alertas como leídas?')) {
        const alertCards = document.querySelectorAll('.alert-card');
        alertCards.forEach(card => {
            card.style.opacity = '0.5';
        });
        alert('Todas las alertas marcadas como leídas');
    }
}

function realizarTarea(titulo) {
    alert(`Realizando tarea: ${titulo}\n\nEsta acción abrirá el módulo correspondiente.`);
}

function exportarPacientes() {
    fetch('/api/exportar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ tipo: 'pacientes' })
    })
        .then(res => res.json())
        .then(data => {
            alert('Datos exportados exitosamente');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al exportar');
        });
}