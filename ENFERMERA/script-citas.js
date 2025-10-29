// script-citas.js - Versión para gestión de citas del día
console.log('Script citas cargado correctamente');

// Datos de ejemplo para inicializar la aplicación
let citas = [
    {
        id: 1,
        paciente: "Carlos Ruiz",
        medico: "Dr. Carlos Ruiz",
        especialidad: "cardiologia",
        consultorio: "Consulta 301",
        fecha: "2024-03-20",
        hora: "09:00",
        motivo: "Control de presión arterial",
        estado: "confirmada"
    },
    {
        id: 2,
        paciente: "Ana López",
        medico: "Dra. Ana Martínez",
        especialidad: "medicina-general",
        consultorio: "Consulta 101",
        fecha: "2024-03-20",
        hora: "10:30",
        motivo: "Seguimiento neumonía",
        estado: "pendiente"
    },
    {
        id: 3,
        paciente: "Miguel Torres",
        medico: "Dr. Roberto Silva",
        especialidad: "cirugia",
        consultorio: "Consulta 201",
        fecha: "2024-03-20",
        hora: "11:15",
        motivo: "Control post-operatorio",
        estado: "completada"
    },
    {
        id: 4,
        paciente: "Elena Morales",
        medico: "Dra. Elena Morales",
        especialidad: "ginecologia",
        consultorio: "Consulta 302",
        fecha: "2024-03-20",
        hora: "14:00",
        motivo: "Consulta de rutina",
        estado: "confirmada"
    },
    {
        id: 5,
        paciente: "Juan Pérez",
        medico: "Dr. Carlos Ruiz",
        especialidad: "cardiologia",
        consultorio: "Consulta 301",
        fecha: "2024-03-20",
        hora: "15:30",
        motivo: "Dolor torácico",
        estado: "urgencia"
    }
];

// Inicializar la aplicación cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Citas');
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

        // Establecer fecha actual por defecto
        const fechaInput = document.getElementById('fecha-citas');
        if (fechaInput) {
            const hoy = new Date().toISOString().split('T')[0];
            fechaInput.value = hoy;
        }

        // Cargar datos iniciales
        actualizarEstadisticas();
        cargarCitas();
        cargarCalendario();
        
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

        console.log('Aplicación de citas inicializada correctamente');
        
    } catch (error) {
        console.error('Error al inicializar la aplicación de citas:', error);
    }
}

function configurarEventos() {
    // Modal de cita
    const modal = document.getElementById('modal-cita');
    const nuevoBtn = document.getElementById('nueva-cita-btn');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-cita');
    
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
            guardarCita();
        });
    }
    
    // Filtros
    const filterEstado = document.getElementById('filter-estado');
    const filterMedico = document.getElementById('filter-medico');
    const filterEspecialidad = document.getElementById('filter-especialidad');
    const resetFilters = document.getElementById('reset-filters');
    const fechaCitas = document.getElementById('fecha-citas');
    
    if (filterEstado) {
        filterEstado.addEventListener('change', filtrarCitas);
    }
    
    if (filterMedico) {
        filterMedico.addEventListener('change', filtrarCitas);
    }
    
    if (filterEspecialidad) {
        filterEspecialidad.addEventListener('change', filtrarCitas);
    }
    
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            filterEstado.value = 'todos';
            filterMedico.value = 'todos';
            filterEspecialidad.value = 'todos';
            filtrarCitas();
        });
    }
    
    if (fechaCitas) {
        fechaCitas.addEventListener('change', function() {
            cargarCitas();
            cargarCalendario();
            actualizarEstadisticas();
        });
    }
    
    // Búsqueda
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', buscarCitas);
    }
    
    // Navegación del calendario
    const prevHour = document.getElementById('prev-hour');
    const nextHour = document.getElementById('next-hour');
    
    if (prevHour) {
        prevHour.addEventListener('click', navegarCalendario);
    }
    
    if (nextHour) {
        nextHour.addEventListener('click', navegarCalendario);
    }
    
    // Botones de acción rápida
    const btnUrgencias = document.getElementById('btn-urgencias');
    
    if (btnUrgencias) {
        btnUrgencias.addEventListener('click', function(e) {
            e.preventDefault();
            registrarUrgencia();
        });
    }
    
    // Botones de exportar y actualizar
    const exportBtn = document.getElementById('export-citas');
    const refreshBtn = document.getElementById('refresh-list');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', exportCitas);
    }
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshCitas);
    }
}

function actualizarEstadisticas() {
    const fechaSeleccionada = document.getElementById('fecha-citas').value;
    const citasDelDia = citas.filter(c => c.fecha === fechaSeleccionada);
    
    const total = citasDelDia.length;
    const pendientes = citasDelDia.filter(c => c.estado === 'pendiente').length;
    const enCurso = citasDelDia.filter(c => c.estado === 'confirmada').length;
    const completadas = citasDelDia.filter(c => c.estado === 'completada').length;
    
    // Contar citas en los próximos 30 minutos
    const ahora = new Date();
    const proximas = citasDelDia.filter(c => {
        if (c.estado !== 'confirmada') return false;
        
        const horaCita = new Date(`${fechaSeleccionada}T${c.hora}`);
        const diffMs = horaCita - ahora;
        const diffMins = Math.floor(diffMs / (1000 * 60));
        
        return diffMins <= 30 && diffMins >= 0;
    }).length;
    
    // Contar médicos únicos con citas confirmadas
    const medicosActivos = new Set(citasDelDia
        .filter(c => c.estado === 'confirmada')
        .map(c => c.medico)
    ).size;

    document.getElementById('total-citas').textContent = total;
    document.getElementById('citas-pendientes').textContent = pendientes;
    document.getElementById('citas-curso').textContent = enCurso;
    document.getElementById('citas-completadas').textContent = completadas;
    document.getElementById('proximas-citas').textContent = proximas;
    document.getElementById('medicos-activos').textContent = medicosActivos;
}

function cargarCitas() {
    const tbody = document.getElementById('tbody-citas');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    const fechaSeleccionada = document.getElementById('fecha-citas').value;
    const citasDelDia = citas.filter(c => c.fecha === fechaSeleccionada);
    
    if (citasDelDia.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px; color: #666;">No hay citas programadas para esta fecha</td></tr>';
        return;
    }
    
    // Ordenar citas por hora
    citasDelDia.sort((a, b) => a.hora.localeCompare(b.hora));
    
    citasDelDia.forEach(cita => {
        const fila = document.createElement('tr');
        
        // Determinar texto del estado
        let estadoText = cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1);
        
        const especialidadText = {
            'cardiologia': 'Cardiología',
            'pediatria': 'Pediatría',
            'cirugia': 'Cirugía',
            'medicina-general': 'Medicina General',
            'dermatologia': 'Dermatología',
            'ginecologia': 'Ginecología'
        }[cita.especialidad] || cita.especialidad;

        fila.innerHTML = `
            <td>
                <strong>${cita.hora}</strong>
            </td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${cita.paciente.charAt(0)}</div>
                    <div>
                        <strong>${cita.paciente}</strong>
                        <span>${cita.motivo}</span>
                    </div>
                </div>
            </td>
            <td>${cita.medico}</td>
            <td>${especialidadText}</td>
            <td>${cita.consultorio}</td>
            <td><span class="status-badge ${cita.estado}">${estadoText}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarCita(${cita.id})" title="Editar cita" aria-label="Editar cita de ${cita.paciente}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstadoCita(${cita.id})" title="Cambiar Estado" aria-label="Cambiar estado de cita de ${cita.paciente}">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetallesCita(${cita.id})" title="Ver Detalles" aria-label="Ver detalles de cita de ${cita.paciente}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function cargarCalendario() {
    const timeSlots = document.getElementById('time-slots');
    if (!timeSlots) return;
    
    timeSlots.innerHTML = '';
    
    const fechaSeleccionada = document.getElementById('fecha-citas').value;
    const citasDelDia = citas.filter(c => c.fecha === fechaSeleccionada);
    
    // Generar franjas horarias de 8:00 a 17:00
    for (let hora = 8; hora <= 17; hora++) {
        for (let minuto = 0; minuto < 60; minuto += 30) {
            const tiempo = `${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
            const citaEnEsteHorario = citasDelDia.find(c => c.hora === tiempo);
            
            const slot = document.createElement('div');
            slot.className = `time-slot ${citaEnEsteHorario ? 
                (citaEnEsteHorario.estado === 'urgencia' ? 'slot-urgencia' : 'slot-ocupado') : 
                'slot-libre'}`;
            
            if (citaEnEsteHorario) {
                slot.innerHTML = `
                    <div class="time-label">${tiempo}</div>
                    <div class="slot-content">
                        <div class="patient-info">
                            <div class="patient-avatar">${citaEnEsteHorario.paciente.charAt(0)}</div>
                            <div>
                                <strong>${citaEnEsteHorario.paciente}</strong>
                                <span>${citaEnEsteHorario.medico} - ${citaEnEsteHorario.consultorio}</span>
                            </div>
                        </div>
                        <span class="status-badge ${citaEnEsteHorario.estado}">
                            ${citaEnEsteHorario.estado.charAt(0).toUpperCase() + citaEnEsteHorario.estado.slice(1)}
                        </span>
                    </div>
                `;
            } else {
                slot.innerHTML = `
                    <div class="time-label">${tiempo}</div>
                    <div class="slot-content">
                        <span style="color: #666; font-style: italic;">Horario disponible</span>
                    </div>
                `;
            }
            
            timeSlots.appendChild(slot);
        }
    }
}

function abrirModal(cita = null) {
    const modal = document.getElementById('modal-cita');
    const titulo = document.getElementById('modal-titulo');
    const form = document.getElementById('form-cita');
    
    if (!modal || !titulo || !form) return;
    
    if (cita) {
        titulo.textContent = 'Editar Cita';
        llenarFormulario(cita);
    } else {
        titulo.textContent = 'Nueva Cita';
        form.reset();
        
        // Establecer valores por defecto
        const fechaInput = document.getElementById('fecha-citas');
        if (fechaInput) {
            document.getElementById('fecha').value = fechaInput.value;
        }
        
        document.getElementById('estado').value = 'pendiente';
        
        // Establecer hora por defecto (próxima media hora)
        const ahora = new Date();
        const minutos = Math.ceil(ahora.getMinutes() / 30) * 30;
        ahora.setMinutes(minutos);
        ahora.setSeconds(0);
        document.getElementById('hora').value = ahora.toTimeString().slice(0, 5);
    }
    
    modal.classList.add('active');
}

function cerrarModal() {
    const modal = document.getElementById('modal-cita');
    if (modal) {
        modal.classList.remove('active');
    }
}

function llenarFormulario(cita) {
    document.getElementById('paciente').value = cita.paciente;
    document.getElementById('medico').value = cita.medico;
    document.getElementById('fecha').value = cita.fecha;
    document.getElementById('hora').value = cita.hora;
    document.getElementById('especialidad').value = cita.especialidad;
    document.getElementById('consultorio').value = cita.consultorio;
    document.getElementById('motivo').value = cita.motivo || '';
    document.getElementById('estado').value = cita.estado;
}

function guardarCita() {
    // Obtener datos del formulario
    const paciente = document.getElementById('paciente').value;
    const medico = document.getElementById('medico').value;
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    const especialidad = document.getElementById('especialidad').value;
    const consultorio = document.getElementById('consultorio').value;
    const motivo = document.getElementById('motivo').value;
    const estado = document.getElementById('estado').value;
    
    // Validar campos requeridos
    if (!paciente || !medico || !fecha || !hora || !especialidad || !consultorio) {
        mostrarNotificacion('Por favor, complete todos los campos requeridos', 'error');
        return;
    }
    
    // Verificar si es edición o nuevo
    const citaId = document.getElementById('modal-titulo').textContent === 'Editar Cita' 
        ? parseInt(document.querySelector('.editing')?.dataset.id) 
        : null;
    
    if (citaId) {
        // Editar cita existente
        const index = citas.findIndex(c => c.id === citaId);
        if (index !== -1) {
            citas[index] = {
                ...citas[index],
                paciente,
                medico,
                fecha,
                hora,
                especialidad,
                consultorio,
                motivo,
                estado
            };
        }
    } else {
        // Crear nueva cita
        const nuevaCita = {
            id: generarNuevoId(),
            paciente,
            medico,
            fecha,
            hora,
            especialidad,
            consultorio,
            motivo,
            estado
        };
        
        citas.push(nuevaCita);
    }
    
    // Actualizar la interfaz
    actualizarEstadisticas();
    cargarCitas();
    cargarCalendario();
    
    // Cerrar modal y mostrar mensaje
    cerrarModal();
    mostrarNotificacion('Cita guardada exitosamente', 'success');
}

function generarNuevoId() {
    return citas.length > 0 ? Math.max(...citas.map(c => c.id)) + 1 : 1;
}

function editarCita(id) {
    const cita = citas.find(c => c.id === id);
    if (cita) {
        abrirModal(cita);
    }
}

function cambiarEstadoCita(id) {
    const cita = citas.find(c => c.id === id);
    if (cita) {
        const nuevosEstados = {
            'pendiente': 'confirmada',
            'confirmada': 'completada',
            'completada': 'cancelada',
            'cancelada': 'pendiente',
            'urgencia': 'completada'
        };
        
        cita.estado = nuevosEstados[cita.estado] || 'pendiente';
        
        actualizarEstadisticas();
        cargarCitas();
        cargarCalendario();
        mostrarNotificacion('Estado de la cita actualizado', 'info');
    }
}

function verDetallesCita(id) {
    const cita = citas.find(c => c.id === id);
    if (cita) {
        const especialidadText = {
            'cardiologia': 'Cardiología',
            'pediatria': 'Pediatría',
            'cirugia': 'Cirugía',
            'medicina-general': 'Medicina General',
            'dermatologia': 'Dermatología',
            'ginecologia': 'Ginecología'
        }[cita.especialidad] || cita.especialidad;

        const detalles = `
Detalles de la cita:

Paciente: ${cita.paciente}
Médico: ${cita.medico}
Fecha: ${formatearFecha(cita.fecha)}
Hora: ${cita.hora}
Especialidad: ${especialidadText}
Consultorio: ${cita.consultorio}
Motivo: ${cita.motivo || 'No especificado'}
Estado: ${cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1)}
        `;
        
        alert(detalles);
    }
}

function formatearFecha(fechaString) {
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(fechaString).toLocaleDateString('es-ES', opciones);
}

function filtrarCitas() {
    const estadoFiltro = document.getElementById('filter-estado').value;
    const medicoFiltro = document.getElementById('filter-medico').value;
    const especialidadFiltro = document.getElementById('filter-especialidad').value;
    const fechaSeleccionada = document.getElementById('fecha-citas').value;
    
    let citasFiltradas = citas.filter(c => c.fecha === fechaSeleccionada);
    
    // Aplicar filtros
    if (estadoFiltro !== 'todos') {
        citasFiltradas = citasFiltradas.filter(c => c.estado === estadoFiltro);
    }
    
    if (medicoFiltro !== 'todos') {
        citasFiltradas = citasFiltradas.filter(c => c.medico === medicoFiltro);
    }
    
    if (especialidadFiltro !== 'todos') {
        citasFiltradas = citasFiltradas.filter(c => c.especialidad === especialidadFiltro);
    }
    
    // Actualizar tabla
    const tbody = document.getElementById('tbody-citas');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (citasFiltradas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px; color: #666;">No se encontraron citas</td></tr>';
        return;
    }
    
    // Ordenar citas por hora
    citasFiltradas.sort((a, b) => a.hora.localeCompare(b.hora));
    
    citasFiltradas.forEach(cita => {
        const fila = document.createElement('tr');
        
        let estadoText = cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1);
        
        const especialidadText = {
            'cardiologia': 'Cardiología',
            'pediatria': 'Pediatría',
            'cirugia': 'Cirugía',
            'medicina-general': 'Medicina General',
            'dermatologia': 'Dermatología',
            'ginecologia': 'Ginecología'
        }[cita.especialidad] || cita.especialidad;

        fila.innerHTML = `
            <td>
                <strong>${cita.hora}</strong>
            </td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${cita.paciente.charAt(0)}</div>
                    <div>
                        <strong>${cita.paciente}</strong>
                        <span>${cita.motivo}</span>
                    </div>
                </div>
            </td>
            <td>${cita.medico}</td>
            <td>${especialidadText}</td>
            <td>${cita.consultorio}</td>
            <td><span class="status-badge ${cita.estado}">${estadoText}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarCita(${cita.id})" title="Editar cita" aria-label="Editar cita de ${cita.paciente}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstadoCita(${cita.id})" title="Cambiar Estado" aria-label="Cambiar estado de cita de ${cita.paciente}">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetallesCita(${cita.id})" title="Ver Detalles" aria-label="Ver detalles de cita de ${cita.paciente}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function buscarCitas() {
    const termino = document.getElementById('search-input').value.toLowerCase();
    const fechaSeleccionada = document.getElementById('fecha-citas').value;
    
    if (!termino) {
        filtrarCitas();
        return;
    }
    
    const resultados = citas.filter(cita => 
        cita.fecha === fechaSeleccionada && (
            cita.paciente.toLowerCase().includes(termino) ||
            cita.medico.toLowerCase().includes(termino) ||
            cita.especialidad.toLowerCase().includes(termino) ||
            cita.consultorio.toLowerCase().includes(termino) ||
            (cita.motivo && cita.motivo.toLowerCase().includes(termino))
        )
    );
    
    // Actualizar tabla con resultados
    const tbody = document.getElementById('tbody-citas');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (resultados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px; color: #666;">No se encontraron resultados</td></tr>';
        return;
    }
    
    // Ordenar citas por hora
    resultados.sort((a, b) => a.hora.localeCompare(b.hora));
    
    resultados.forEach(cita => {
        const fila = document.createElement('tr');
        
        let estadoText = cita.estado.charAt(0).toUpperCase() + cita.estado.slice(1);
        
        const especialidadText = {
            'cardiologia': 'Cardiología',
            'pediatria': 'Pediatría',
            'cirugia': 'Cirugía',
            'medicina-general': 'Medicina General',
            'dermatologia': 'Dermatología',
            'ginecologia': 'Ginecología'
        }[cita.especialidad] || cita.especialidad;

        fila.innerHTML = `
            <td>
                <strong>${cita.hora}</strong>
            </td>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">${cita.paciente.charAt(0)}</div>
                    <div>
                        <strong>${cita.paciente}</strong>
                        <span>${cita.motivo}</span>
                    </div>
                </div>
            </td>
            <td>${cita.medico}</td>
            <td>${especialidadText}</td>
            <td>${cita.consultorio}</td>
            <td><span class="status-badge ${cita.estado}">${estadoText}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarCita(${cita.id})" title="Editar cita" aria-label="Editar cita de ${cita.paciente}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="cambiarEstadoCita(${cita.id})" title="Cambiar Estado" aria-label="Cambiar estado de cita de ${cita.paciente}">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button class="btn-view" onclick="verDetallesCita(${cita.id})" title="Ver Detalles" aria-label="Ver detalles de cita de ${cita.paciente}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function navegarCalendario(e) {
    const btn = e.currentTarget;
    const currentRange = document.getElementById('current-time-range');
    
    // Esta es una funcionalidad básica para demo
    // En una implementación real, esto controlaría la vista del calendario
    if (btn.id === 'prev-hour') {
        mostrarNotificacion('Navegando a horas anteriores', 'info');
    } else {
        mostrarNotificacion('Navegando a horas siguientes', 'info');
    }
}

function registrarUrgencia() {
    console.log('Registrando caso de urgencia...');
    alert('Funcionalidad de urgencias:\nSe abrirá un formulario para registrar casos de urgencia y asignarlos inmediatamente a un médico disponible.');
}

function exportCitas() {
    console.log('Exportando lista de citas...');
    alert('Generando reporte de citas en formato PDF...\nEl reporte incluirá la agenda completa del día con todos los detalles de las citas programadas.');
}

function refreshCitas() {
    console.log('Actualizando lista de citas...');
    // En una implementación real, aquí se haría una petición al servidor
    mostrarNotificacion('Lista de citas actualizada.', 'info');
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
console.log('Script citas inicializado');