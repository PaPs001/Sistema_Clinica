// script-tratamientos.js - Versión mejorada para gestión de tratamientos
console.log('Script tratamientos mejorado cargado correctamente');

// Datos de ejemplo para inicializar la aplicación
let tratamientos = [
    {
        id: 1,
        paciente: "Carlos Ruiz",
        diagnostico: "Hipertensión arterial severa",
        medicamento: "Losartán",
        dosis: "50mg",
        frecuencia: "una vez al día",
        duracion: 30,
        fechaInicio: "2024-01-15",
        estado: "activo",
        medico: "Dr. Carlos Ruiz"
    },
    {
        id: 2,
        paciente: "Ana López",
        diagnostico: "Neumonía bacteriana",
        medicamento: "Amoxicilina",
        dosis: "500mg",
        frecuencia: "cada 8 horas",
        duracion: 7,
        fechaInicio: "2024-02-01",
        estado: "activo",
        medico: "Dra. Ana Martínez"
    },
    {
        id: 3,
        paciente: "Miguel Torres",
        diagnostico: "Diabetes mellitus tipo 2",
        medicamento: "Metformina",
        dosis: "850mg",
        frecuencia: "dos veces al día",
        duracion: 90,
        fechaInicio: "2024-01-20",
        estado: "activo",
        medico: "Dr. Roberto Silva"
    },
    {
        id: 4,
        paciente: "Elena Morales",
        diagnostico: "Artritis reumatoide",
        medicamento: "Ibuprofeno",
        dosis: "400mg",
        frecuencia: "cada 12 horas",
        duracion: 14,
        fechaInicio: "2024-02-10",
        estado: "suspendido",
        medico: "Dra. Elena Morales"
    }
];

// Inicializar la aplicación cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Tratamientos');
    inicializarApp();
});

function inicializarApp() {
    try {
        // Navegación activa
        const navItems = document.querySelectorAll('.nav-item');
        if (navItems.length === 0) {
            console.error('No se encontraron elementos .nav-item');
            return;
        }
        
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                
                // Redirigir a la página correspondiente
                const href = this.getAttribute('href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });
        });

        // Cargar datos iniciales
        actualizarEstadisticas();
        cargarTratamientos();
        actualizarFiltros();
        
        // Configurar eventos
        configurarEventos();

        // Logout
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                    logout();
                }
            });
        }

        console.log('Aplicación de tratamientos inicializada correctamente');
        
    } catch (error) {
        console.error('Error al inicializar la aplicación de tratamientos:', error);
    }
}

function configurarEventos() {
    // Modal de tratamiento
    const modal = document.getElementById('modal-tratamiento');
    const nuevoBtn = document.getElementById('nuevo-tratamiento-btn');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-tratamiento');
    
    if (nuevoBtn) {
        nuevoBtn.addEventListener('click', () => abrirModal());
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', () => cerrarModal());
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => cerrarModal());
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            guardarTratamiento();
        });
    }
    
    // Filtros
    const filterStatus = document.getElementById('filter-status');
    const filterPaciente = document.getElementById('filter-paciente');
    const filterMedico = document.getElementById('filter-medico');
    const resetFilters = document.getElementById('reset-filters');
    
    if (filterStatus) {
        filterStatus.addEventListener('change', filtrarTratamientos);
    }
    
    if (filterPaciente) {
        filterPaciente.addEventListener('change', filtrarTratamientos);
    }
    
    if (filterMedico) {
        filterMedico.addEventListener('change', filtrarTratamientos);
    }
    
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            filterStatus.value = 'todos';
            filterPaciente.value = 'todos';
            filterMedico.value = 'todos';
            filtrarTratamientos();
        });
    }
    
    // Búsqueda
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', buscarTratamientos);
    }
    
    // Botones de exportar y actualizar
    const exportBtn = document.getElementById('export-tratamientos');
    const refreshBtn = document.getElementById('refresh-list');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', exportTratamientos);
    }
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshTratamientos);
    }
}

function actualizarEstadisticas() {
    const total = tratamientos.length;
    const activos = tratamientos.filter(t => t.estado === 'activo').length;
    const completados = tratamientos.filter(t => t.estado === 'completado').length;
    const suspendidos = tratamientos.filter(t => t.estado === 'suspendido').length;
    
    // Contar pacientes únicos
    const pacientesUnicos = new Set(tratamientos.map(t => t.paciente)).size;
    
    // Contar medicamentos únicos
    const medicamentosUnicos = new Set(tratamientos.map(t => t.medicamento)).size;
    
    document.getElementById('total-tratamientos').textContent = total;
    document.getElementById('tratamientos-activos').textContent = activos;
    document.getElementById('tratamientos-completados').textContent = completados;
    document.getElementById('pacientes-activos').textContent = pacientesUnicos;
    document.getElementById('alertas-pendientes').textContent = suspendidos;
    document.getElementById('medicamentos-totales').textContent = medicamentosUnicos;
}

function cargarTratamientos() {
    const tbody = document.getElementById('tbody-tratamientos');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (tratamientos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 20px; color: #666;">No hay tratamientos registrados</td></tr>';
        return;
    }
    
    tratamientos.forEach(tratamiento => {
        const fila = document.createElement('tr');
        
        // Determinar clase del badge según el estado
        let badgeClass = tratamiento.estado;
        let badgeText = tratamiento.estado.charAt(0).toUpperCase() + tratamiento.estado.slice(1);
        
        fila.innerHTML = `
            <td>${tratamiento.id}</td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${tratamiento.paciente.charAt(0)}</div>
                    <div>
                        <strong>${tratamiento.paciente}</strong>
                        <span>${tratamiento.medico}</span>
                    </div>
                </div>
            </td>
            <td>${tratamiento.diagnostico}</td>
            <td>${tratamiento.medicamento}</td>
            <td>${tratamiento.dosis}</td>
            <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            <td>${formatearFecha(tratamiento.fechaInicio)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarTratamiento(${tratamiento.id})" title="Editar tratamiento" aria-label="Editar tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstado(${tratamiento.id})" title="Cambiar Estado" aria-label="Cambiar estado del tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${tratamiento.id})" title="Ver Detalles" aria-label="Ver detalles del tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function actualizarFiltros() {
    const selectPaciente = document.getElementById('filter-paciente');
    const selectMedico = document.getElementById('filter-medico');
    
    if (!selectPaciente || !selectMedico) return;
    
    // Obtener pacientes únicos
    const pacientes = [...new Set(tratamientos.map(t => t.paciente))];
    const medicos = [...new Set(tratamientos.map(t => t.medico))];
    
    // Limpiar opciones excepto la primera
    while (selectPaciente.children.length > 1) {
        selectPaciente.removeChild(selectPaciente.lastChild);
    }
    
    while (selectMedico.children.length > 1) {
        selectMedico.removeChild(selectMedico.lastChild);
    }
    
    // Agregar opciones de pacientes
    pacientes.forEach(paciente => {
        const option = document.createElement('option');
        option.value = paciente;
        option.textContent = paciente;
        selectPaciente.appendChild(option);
    });
    
    // Agregar opciones de médicos
    medicos.forEach(medico => {
        const option = document.createElement('option');
        option.value = medico;
        option.textContent = medico;
        selectMedico.appendChild(option);
    });
}

function formatearFecha(fechaString) {
    const opciones = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(fechaString).toLocaleDateString('es-ES', opciones);
}

function abrirModal(tratamiento = null) {
    const modal = document.getElementById('modal-tratamiento');
    const titulo = document.getElementById('modal-titulo');
    const form = document.getElementById('form-tratamiento');
    
    if (!modal || !titulo || !form) return;
    
    if (tratamiento) {
        titulo.textContent = 'Editar Tratamiento';
        llenarFormulario(tratamiento);
    } else {
        titulo.textContent = 'Nuevo Tratamiento';
        form.reset();
        document.getElementById('medico').value = 'Dr. Carlos Ruiz';
        document.getElementById('estado').value = 'activo';
        // Establecer fecha actual como fecha de inicio
        document.getElementById('duracion').value = '7';
    }
    
    modal.classList.add('active');
}

function cerrarModal() {
    const modal = document.getElementById('modal-tratamiento');
    if (modal) {
        modal.classList.remove('active');
    }
}

function llenarFormulario(tratamiento) {
    document.getElementById('paciente').value = tratamiento.paciente;
    document.getElementById('diagnostico').value = tratamiento.diagnostico;
    document.getElementById('medicamento').value = tratamiento.medicamento;
    document.getElementById('dosis').value = tratamiento.dosis;
    document.getElementById('frecuencia').value = tratamiento.frecuencia;
    document.getElementById('duracion').value = tratamiento.duracion;
    document.getElementById('medico').value = tratamiento.medico;
    document.getElementById('estado').value = tratamiento.estado;
}

function guardarTratamiento() {
    // Obtener datos del formulario
    const paciente = document.getElementById('paciente').value;
    const diagnostico = document.getElementById('diagnostico').value;
    const medicamento = document.getElementById('medicamento').value;
    const dosis = document.getElementById('dosis').value;
    const frecuencia = document.getElementById('frecuencia').value;
    const duracion = parseInt(document.getElementById('duracion').value);
    const medico = document.getElementById('medico').value;
    const estado = document.getElementById('estado').value;
    
    // Validar campos requeridos
    if (!paciente || !diagnostico || !medicamento || !dosis || !frecuencia || !duracion) {
        mostrarNotificacion('Por favor, complete todos los campos requeridos', 'error');
        return;
    }
    
    // Verificar si es edición o nuevo
    const tratamientoId = document.getElementById('modal-titulo').textContent === 'Editar Tratamiento' 
        ? parseInt(document.querySelector('.editing')?.dataset.id) 
        : null;
    
    if (tratamientoId) {
        // Editar tratamiento existente
        const index = tratamientos.findIndex(t => t.id === tratamientoId);
        if (index !== -1) {
            tratamientos[index] = {
                ...tratamientos[index],
                paciente,
                diagnostico,
                medicamento,
                dosis,
                frecuencia,
                duracion,
                medico,
                estado
            };
        }
    } else {
        // Crear nuevo tratamiento
        const nuevoTratamiento = {
            id: generarNuevoId(),
            paciente,
            diagnostico,
            medicamento,
            dosis,
            frecuencia,
            duracion,
            fechaInicio: new Date().toISOString().split('T')[0],
            estado,
            medico
        };
        
        tratamientos.push(nuevoTratamiento);
    }
    
    // Actualizar la interfaz
    actualizarEstadisticas();
    cargarTratamientos();
    actualizarFiltros();
    
    // Cerrar modal y mostrar mensaje
    cerrarModal();
    mostrarNotificacion('Tratamiento guardado exitosamente', 'success');
}

function generarNuevoId() {
    return tratamientos.length > 0 ? Math.max(...tratamientos.map(t => t.id)) + 1 : 1;
}

function editarTratamiento(id) {
    const tratamiento = tratamientos.find(t => t.id === id);
    if (tratamiento) {
        abrirModal(tratamiento);
    }
}

function cambiarEstado(id) {
    const tratamiento = tratamientos.find(t => t.id === id);
    if (tratamiento) {
        const nuevosEstados = {
            'activo': 'completado',
            'completado': 'suspendido',
            'suspendido': 'activo'
        };
        
        tratamiento.estado = nuevosEstados[tratamiento.estado];
        
        actualizarEstadisticas();
        cargarTratamientos();
        mostrarNotificacion('Estado del tratamiento actualizado', 'info');
    }
}

function verDetalles(id) {
    const tratamiento = tratamientos.find(t => t.id === id);
    if (tratamiento) {
        const detalles = `
Detalles del tratamiento:

Paciente: ${tratamiento.paciente}
Diagnóstico: ${tratamiento.diagnostico}
Medicamento: ${tratamiento.medicamento}
Dosis: ${tratamiento.dosis}
Frecuencia: ${tratamiento.frecuencia}
Duración: ${tratamiento.duracion} días
Estado: ${tratamiento.estado}
Médico: ${tratamiento.medico}
Fecha de inicio: ${formatearFecha(tratamiento.fechaInicio)}
        `;
        
        alert(detalles);
    }
}

function filtrarTratamientos() {
    const estadoFiltro = document.getElementById('filter-status').value;
    const pacienteFiltro = document.getElementById('filter-paciente').value;
    const medicoFiltro = document.getElementById('filter-medico').value;
    
    let tratamientosFiltrados = [...tratamientos];
    
    // Aplicar filtros
    if (estadoFiltro !== 'todos') {
        tratamientosFiltrados = tratamientosFiltrados.filter(t => t.estado === estadoFiltro);
    }
    
    if (pacienteFiltro !== 'todos') {
        tratamientosFiltrados = tratamientosFiltrados.filter(t => t.paciente === pacienteFiltro);
    }
    
    if (medicoFiltro !== 'todos') {
        tratamientosFiltrados = tratamientosFiltrados.filter(t => t.medico === medicoFiltro);
    }
    
    // Actualizar tabla
    const tbody = document.getElementById('tbody-tratamientos');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (tratamientosFiltrados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 20px; color: #666;">No se encontraron tratamientos</td></tr>';
        return;
    }
    
    tratamientosFiltrados.forEach(tratamiento => {
        const fila = document.createElement('tr');
        
        let badgeClass = tratamiento.estado;
        let badgeText = tratamiento.estado.charAt(0).toUpperCase() + tratamiento.estado.slice(1);
        
        fila.innerHTML = `
            <td>${tratamiento.id}</td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${tratamiento.paciente.charAt(0)}</div>
                    <div>
                        <strong>${tratamiento.paciente}</strong>
                        <span>${tratamiento.medico}</span>
                    </div>
                </div>
            </td>
            <td>${tratamiento.diagnostico}</td>
            <td>${tratamiento.medicamento}</td>
            <td>${tratamiento.dosis}</td>
            <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            <td>${formatearFecha(tratamiento.fechaInicio)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarTratamiento(${tratamiento.id})" title="Editar tratamiento" aria-label="Editar tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstado(${tratamiento.id})" title="Cambiar Estado" aria-label="Cambiar estado del tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${tratamiento.id})" title="Ver Detalles" aria-label="Ver detalles del tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function buscarTratamientos() {
    const termino = document.getElementById('search-input').value.toLowerCase();
    
    if (!termino) {
        filtrarTratamientos();
        return;
    }
    
    const resultados = tratamientos.filter(tratamiento => 
        tratamiento.paciente.toLowerCase().includes(termino) ||
        tratamiento.medicamento.toLowerCase().includes(termino) ||
        tratamiento.diagnostico.toLowerCase().includes(termino) ||
        tratamiento.medico.toLowerCase().includes(termino)
    );
    
    // Actualizar tabla con resultados
    const tbody = document.getElementById('tbody-tratamientos');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (resultados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 20px; color: #666;">No se encontraron resultados</td></tr>';
        return;
    }
    
    resultados.forEach(tratamiento => {
        const fila = document.createElement('tr');
        
        let badgeClass = tratamiento.estado;
        let badgeText = tratamiento.estado.charAt(0).toUpperCase() + tratamiento.estado.slice(1);
        
        fila.innerHTML = `
            <td>${tratamiento.id}</td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${tratamiento.paciente.charAt(0)}</div>
                    <div>
                        <strong>${tratamiento.paciente}</strong>
                        <span>${tratamiento.medico}</span>
                    </div>
                </div>
            </td>
            <td>${tratamiento.diagnostico}</td>
            <td>${tratamiento.medicamento}</td>
            <td>${tratamiento.dosis}</td>
            <td><span class="status-badge ${badgeClass}">${badgeText}</span></td>
            <td>${formatearFecha(tratamiento.fechaInicio)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarTratamiento(${tratamiento.id})" title="Editar tratamiento" aria-label="Editar tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstado(${tratamiento.id})" title="Cambiar Estado" aria-label="Cambiar estado del tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${tratamiento.id})" title="Ver Detalles" aria-label="Ver detalles del tratamiento de ${tratamiento.paciente}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function exportTratamientos() {
    console.log('Exportando lista de tratamientos...');
    alert('Generando reporte de tratamientos en formato PDF...\nEl reporte incluirá la lista completa de tratamientos médicos.');
}

function refreshTratamientos() {
    console.log('Actualizando lista de tratamientos...');
    // En una implementación real, aquí se haría una petición al servidor
    mostrarNotificacion('Lista de tratamientos actualizada.', 'info');
}

function mostrarNotificacion(mensaje, tipo) {
    // Crear notificación temporal
    const notificacion = document.createElement('div');
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: 600;
        z-index: 1001;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    `;
    
    if (tipo === 'success') {
        notificacion.style.background = 'var(--success-color)';
    } else if (tipo === 'error') {
        notificacion.style.background = 'var(--danger-color)';
    } else {
        notificacion.style.background = 'var(--accent-color)';
    }
    
    notificacion.textContent = mensaje;
    document.body.appendChild(notificacion);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notificacion.style.opacity = '0';
        notificacion.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notificacion.parentNode) {
                notificacion.parentNode.removeChild(notificacion);
            }
        }, 300);
    }, 3000);
}

function logout() {
    console.log('Cerrando sesión de enfermera...');
    localStorage.removeItem('enfermeraLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const enfermeraLoggedIn = localStorage.getItem('enfermeraLoggedIn');
    if (!enfermeraLoggedIn) {
        console.log('No hay sesión activa de enfermera, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión de enfermera activa');
    }
}

// Inicialización
checkSession();
console.log('Script tratamientos inicializado');