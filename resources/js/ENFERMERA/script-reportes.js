// script-reportes.js - Versión para gestión de reportes
console.log('Script reportes cargado correctamente');

// Datos de ejemplo para inicializar la aplicación
let reportes = [
    {
        id: 1,
        nombre: "Reporte Mensual de Pacientes",
        tipo: "pacientes",
        fecha: "2024-03-20",
        tamaño: "2.5 MB",
        formato: "PDF",
        url: "#"
    },
    {
        id: 2,
        nombre: "Análisis de Tratamientos Q1",
        tipo: "tratamientos",
        fecha: "2024-03-15",
        tamaño: "1.8 MB",
        formato: "Excel",
        url: "#"
    },
    {
        id: 3,
        nombre: "Inventario Marzo 2024",
        tipo: "inventario",
        fecha: "2024-03-10",
        tamaño: "3.2 MB",
        formato: "PDF",
        url: "#"
    },
    {
        id: 4,
        nombre: "Estadísticas de Citas",
        tipo: "citas",
        fecha: "2024-03-05",
        tamaño: "1.1 MB",
        formato: "Gráfico",
        url: "#"
    }
];

// Inicializar la aplicación cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Reportes');
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

        // Establecer fechas por defecto
        const fechaInicio = document.getElementById('fecha-inicio');
        const fechaFin = document.getElementById('fecha-fin');
        
        if (fechaInicio && fechaFin) {
            const hoy = new Date();
            const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            
            fechaInicio.value = primerDiaMes.toISOString().split('T')[0];
            fechaFin.value = hoy.toISOString().split('T')[0];
        }

        // Cargar datos iniciales
        actualizarEstadisticas();
        cargarHistorial();
        inicializarGraficos();
        
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

        console.log('Aplicación de reportes inicializada correctamente');
        
    } catch (error) {
        console.error('Error al inicializar la aplicación de reportes:', error);
    }
}

function configurarEventos() {
    // Botón generar reporte
    const generarBtn = document.getElementById('generar-reporte-btn');
    if (generarBtn) {
        generarBtn.addEventListener('click', generarReporteGeneral);
    }
    
    // Filtros
    const aplicarFiltros = document.getElementById('aplicar-filtros');
    const filterPeriodo = document.getElementById('filter-periodo');
    
    if (aplicarFiltros) {
        aplicarFiltros.addEventListener('click', aplicarFiltrosReportes);
    }
    
    if (filterPeriodo) {
        filterPeriodo.addEventListener('change', manejarCambioPeriodo);
    }
    
    // Botones de acción
    const actualizarReportes = document.getElementById('actualizar-reportes');
    const exportarTodos = document.getElementById('exportar-todos');
    const limpiarHistorial = document.getElementById('limpiar-historial');
    const guardarPlantilla = document.getElementById('guardar-plantilla');
    const limpiarFormulario = document.getElementById('limpiar-formulario');
    const generarPersonalizado = document.getElementById('generar-personalizado');
    
    if (actualizarReportes) {
        actualizarReportes.addEventListener('click', actualizarReportesLista);
    }
    
    if (exportarTodos) {
        exportarTodos.addEventListener('click', exportarTodosReportes);
    }
    
    if (limpiarHistorial) {
        limpiarHistorial.addEventListener('click', limpiarHistorialReportes);
    }
    
    if (guardarPlantilla) {
        guardarPlantilla.addEventListener('click', guardarPlantillaReporte);
    }
    
    if (limpiarFormulario) {
        limpiarFormulario.addEventListener('click', limpiarFormularioReporte);
    }
    
    if (generarPersonalizado) {
        generarPersonalizado.addEventListener('click', generarReportePersonalizado);
    }
    
    // Modal de vista previa
    const cerrarPreview = document.getElementById('cerrar-preview');
    const descargarPreview = document.getElementById('descargar-preview');
    const closeModal = document.querySelector('.close-modal');
    
    if (cerrarPreview) {
        cerrarPreview.addEventListener('click', cerrarVistaPrevia);
    }
    
    if (descargarPreview) {
        descargarPreview.addEventListener('click', descargarVistaPrevia);
    }
    
    if (closeModal) {
        closeModal.addEventListener('click', cerrarVistaPrevia);
    }
    
    // Búsqueda
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', buscarReportes);
    }
}

function actualizarEstadisticas() {
    // Datos de ejemplo para las estadísticas
    document.getElementById('total-pacientes').textContent = '1,247';
    document.getElementById('total-tratamientos').textContent = '3,845';
    document.getElementById('total-medicamentos').textContent = '156';
    document.getElementById('total-citas').textContent = '892';
}

function inicializarGraficos() {
    // Gráfico de tendencia de pacientes
    const pacientesCtx = document.getElementById('pacientes-chart');
    if (pacientesCtx) {
        new Chart(pacientesCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Pacientes Atendidos',
                    data: [120, 150, 180, 200, 240, 280, 320, 300, 280, 320, 350, 380],
                    borderColor: '#061175',
                    backgroundColor: 'rgba(6, 17, 117, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Número de Pacientes'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    }
                }
            }
        });
    }
    
    // Gráfico de distribución por especialidad
    const especialidadesCtx = document.getElementById('especialidades-chart');
    if (especialidadesCtx) {
        new Chart(especialidadesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cardiología', 'Pediatría', 'Cirugía', 'Medicina General', 'Ginecología', 'Dermatología'],
                datasets: [{
                    data: [25, 20, 15, 18, 12, 10],
                    backgroundColor: [
                        '#061175',
                        '#0a1fa0',
                        '#667eea',
                        '#764ba2',
                        '#f093fb',
                        '#f5576c'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}

function cargarHistorial() {
    const tbody = document.getElementById('historial-body');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (reportes.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: #666;">No hay reportes generados</td></tr>';
        return;
    }
    
    reportes.forEach(reporte => {
        const fila = document.createElement('tr');
        
        const tipoText = {
            'pacientes': 'Pacientes',
            'tratamientos': 'Tratamientos',
            'inventario': 'Inventario',
            'citas': 'Citas',
            'signos': 'Signos Vitales',
            'general': 'General'
        }[reporte.tipo] || reporte.tipo;

        fila.innerHTML = `
            <td>
                <strong>${reporte.nombre}</strong>
            </td>
            <td>${tipoText}</td>
            <td>${formatearFecha(reporte.fecha)}</td>
            <td>${reporte.tamaño}</td>
            <td>${reporte.formato}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-view" onclick="verReporte(${reporte.id})" title="Ver reporte" aria-label="Ver reporte ${reporte.nombre}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-action" onclick="descargarReporteExistente(${reporte.id})" title="Descargar reporte" aria-label="Descargar reporte ${reporte.nombre}">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="btn-edit" onclick="eliminarReporte(${reporte.id})" title="Eliminar reporte" aria-label="Eliminar reporte ${reporte.nombre}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function formatearFecha(fechaString) {
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(fechaString).toLocaleDateString('es-ES', opciones);
}

function aplicarFiltrosReportes() {
    const tipoFiltro = document.getElementById('filter-tipo').value;
    const periodoFiltro = document.getElementById('filter-periodo').value;
    const formatoFiltro = document.getElementById('filter-formato').value;
    
    console.log('Aplicando filtros:', { tipoFiltro, periodoFiltro, formatoFiltro });
    
    // En una implementación real, aquí se filtrarían los reportes
    mostrarNotificacion('Filtros aplicados correctamente', 'success');
}

function manejarCambioPeriodo() {
    const periodo = document.getElementById('filter-periodo').value;
    const fechaInicio = document.getElementById('fecha-inicio');
    const fechaFin = document.getElementById('fecha-fin');
    
    if (!fechaInicio || !fechaFin) return;
    
    const hoy = new Date();
    let fechaInicioValue, fechaFinValue;
    
    switch (periodo) {
        case 'hoy':
            fechaInicioValue = hoy.toISOString().split('T')[0];
            fechaFinValue = hoy.toISOString().split('T')[0];
            break;
        case 'semana':
            const primerDiaSemana = new Date(hoy);
            primerDiaSemana.setDate(hoy.getDate() - hoy.getDay());
            fechaInicioValue = primerDiaSemana.toISOString().split('T')[0];
            fechaFinValue = hoy.toISOString().split('T')[0];
            break;
        case 'mes':
            const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            fechaInicioValue = primerDiaMes.toISOString().split('T')[0];
            fechaFinValue = hoy.toISOString().split('T')[0];
            break;
        case 'trimestre':
            const trimestreActual = Math.floor(hoy.getMonth() / 3);
            const primerDiaTrimestre = new Date(hoy.getFullYear(), trimestreActual * 3, 1);
            fechaInicioValue = primerDiaTrimestre.toISOString().split('T')[0];
            fechaFinValue = hoy.toISOString().split('T')[0];
            break;
        case 'personalizado':
            // No hacer nada, el usuario seleccionará las fechas manualmente
            return;
    }
    
    fechaInicio.value = fechaInicioValue;
    fechaFin.value = fechaFinValue;
}

function generarReporteGeneral() {
    console.log('Generando reporte general...');
    
    // Simular proceso de generación
    mostrarNotificacion('Generando reporte, por favor espere...', 'info');
    
    setTimeout(() => {
        // Agregar nuevo reporte al historial
        const nuevoReporte = {
            id: reportes.length + 1,
            nombre: "Reporte General " + new Date().toLocaleDateString(),
            tipo: "general",
            fecha: new Date().toISOString().split('T')[0],
            tamaño: "2.8 MB",
            formato: "PDF",
            url: "#"
        };
        
        reportes.unshift(nuevoReporte);
        cargarHistorial();
        mostrarNotificacion('Reporte generado exitosamente', 'success');
    }, 2000);
}

function generarReportePersonalizado() {
    const nombre = document.getElementById('reporte-nombre').value;
    const tipo = document.getElementById('reporte-tipo').value;
    const formato = document.getElementById('formato-salida').value;
    const ordenamiento = document.getElementById('ordenamiento').value;
    
    if (!nombre) {
        mostrarNotificacion('Por favor, ingrese un nombre para el reporte', 'error');
        return;
    }
    
    // Obtener datos seleccionados
    const datosSeleccionados = Array.from(document.querySelectorAll('input[name="datos"]:checked'))
        .map(checkbox => checkbox.value);
    
    if (datosSeleccionados.length === 0) {
        mostrarNotificacion('Por favor, seleccione al menos un tipo de dato', 'error');
        return;
    }
    
    console.log('Generando reporte personalizado:', {
        nombre,
        tipo,
        formato,
        ordenamiento,
        datos: datosSeleccionados
    });
    
    mostrarNotificacion('Generando reporte personalizado...', 'info');
    
    setTimeout(() => {
        const nuevoReporte = {
            id: reportes.length + 1,
            nombre: nombre,
            tipo: "personalizado",
            fecha: new Date().toISOString().split('T')[0],
            tamaño: "3.1 MB",
            formato: formato.toUpperCase(),
            url: "#"
        };
        
        reportes.unshift(nuevoReporte);
        cargarHistorial();
        mostrarNotificacion('Reporte personalizado generado exitosamente', 'success');
        
        // Mostrar vista previa
        mostrarVistaPrevia(nuevoReporte);
    }, 3000);
}

function mostrarVistaPrevia(reporte) {
    const modal = document.getElementById('modal-preview');
    const titulo = document.getElementById('preview-titulo');
    const preview = document.getElementById('report-preview');
    
    if (!modal || !titulo || !preview) return;
    
    titulo.textContent = `Vista Previa - ${reporte.nombre}`;
    
    // Generar contenido de vista previa
    preview.innerHTML = `
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #061175; margin-bottom: 10px;">${reporte.nombre}</h2>
            <p style="color: #666;">Generado el ${formatearFecha(reporte.fecha)}</p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <h4 style="color: #061175; margin-bottom: 10px;">Resumen Ejecutivo</h4>
                <p>Este reporte contiene un análisis completo de las actividades del hospital durante el período seleccionado.</p>
            </div>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <h4 style="color: #061175; margin-bottom: 10px;">Datos Incluidos</h4>
                <ul style="list-style: none; padding: 0;">
                    <li>✓ Estadísticas de pacientes</li>
                    <li>✓ Tratamientos aplicados</li>
                    <li>✓ Control de medicamentos</li>
                    <li>✓ Gestión de citas</li>
                </ul>
            </div>
        </div>
        
        <div style="background: white; border: 1px solid #e1e5e9; border-radius: 8px; padding: 20px;">
            <h4 style="color: #061175; margin-bottom: 15px;">Tabla de Datos de Ejemplo</h4>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e1e5e9;">Categoría</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e1e5e9;">Total</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e1e5e9;">Variación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9;">Pacientes Atendidos</td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9;">1,247</td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9; color: #28a745;">+12%</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9;">Tratamientos</td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9;">3,845</td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9; color: #28a745;">+8%</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9;">Citas Realizadas</td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9;">892</td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e5e9; color: #28a745;">+15%</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <h4 style="color: #061175; margin-bottom: 10px;">Conclusiones</h4>
            <p>El hospital muestra un crecimiento positivo en todas las métricas principales, con un aumento significativo en la cantidad de pacientes atendidos y tratamientos aplicados.</p>
        </div>
    `;
    
    modal.classList.add('active');
}

function cerrarVistaPrevia() {
    const modal = document.getElementById('modal-preview');
    if (modal) {
        modal.classList.remove('active');
    }
}

function descargarVistaPrevia() {
    mostrarNotificacion('Descargando reporte...', 'info');
    // En una implementación real, aquí se generaría y descargaría el archivo
    setTimeout(() => {
        mostrarNotificacion('Reporte descargado exitosamente', 'success');
    }, 1500);
}

// Funciones para los botones de reportes predefinidos
function generarReporte(tipo) {
    console.log(`Generando reporte de ${tipo}`);
    mostrarNotificacion(`Generando reporte de ${tipo}...`, 'info');
    
    setTimeout(() => {
        const nuevoReporte = {
            id: reportes.length + 1,
            nombre: `Reporte de ${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`,
            tipo: tipo,
            fecha: new Date().toISOString().split('T')[0],
            tamaño: "2.1 MB",
            formato: "PDF",
            url: "#"
        };
        
        reportes.unshift(nuevoReporte);
        cargarHistorial();
        mostrarNotificacion(`Reporte de ${tipo} generado exitosamente`, 'success');
    }, 2000);
}

function descargarReporte(tipo) {
    console.log(`Descargando reporte de ${tipo}`);
    mostrarNotificacion(`Descargando reporte de ${tipo}...`, 'info');
    
    setTimeout(() => {
        mostrarNotificacion(`Reporte de ${tipo} descargado exitosamente`, 'success');
    }, 1500);
}

function verReporte(id) {
    const reporte = reportes.find(r => r.id === id);
    if (reporte) {
        mostrarVistaPrevia(reporte);
    }
}

function descargarReporteExistente(id) {
    const reporte = reportes.find(r => r.id === id);
    if (reporte) {
        mostrarNotificacion(`Descargando ${reporte.nombre}...`, 'info');
        setTimeout(() => {
            mostrarNotificacion(`${reporte.nombre} descargado exitosamente`, 'success');
        }, 1500);
    }
}

function eliminarReporte(id) {
    if (confirm('¿Está seguro de que desea eliminar este reporte?')) {
        reportes = reportes.filter(r => r.id !== id);
        cargarHistorial();
        mostrarNotificacion('Reporte eliminado exitosamente', 'success');
    }
}

function actualizarReportesLista() {
    console.log('Actualizando lista de reportes...');
    mostrarNotificacion('Lista de reportes actualizada', 'info');
}

function exportarTodosReportes() {
    console.log('Exportando todos los reportes...');
    mostrarNotificacion('Preparando exportación de todos los reportes...', 'info');
    
    setTimeout(() => {
        mostrarNotificacion('Todos los reportes han sido exportados exitosamente', 'success');
    }, 3000);
}

function limpiarHistorialReportes() {
    if (confirm('¿Está seguro de que desea limpiar todo el historial de reportes?')) {
        reportes = [];
        cargarHistorial();
        mostrarNotificacion('Historial de reportes limpiado exitosamente', 'success');
    }
}

function guardarPlantillaReporte() {
    const nombre = document.getElementById('reporte-nombre').value;
    if (!nombre) {
        mostrarNotificacion('Por favor, ingrese un nombre para la plantilla', 'error');
        return;
    }
    
    mostrarNotificacion(`Plantilla "${nombre}" guardada exitosamente`, 'success');
}

function limpiarFormularioReporte() {
    document.getElementById('reporte-nombre').value = '';
    document.getElementById('reporte-tipo').value = 'resumen';
    document.getElementById('formato-salida').value = 'pdf';
    document.getElementById('ordenamiento').value = 'fecha';
    
    // Desmarcar todos los checkboxes
    document.querySelectorAll('input[name="datos"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    mostrarNotificacion('Formulario limpiado', 'info');
}

function buscarReportes() {
    const termino = document.getElementById('search-input').value.toLowerCase();
    
    if (!termino) {
        cargarHistorial();
        return;
    }
    
    const resultados = reportes.filter(reporte => 
        reporte.nombre.toLowerCase().includes(termino) ||
        reporte.tipo.toLowerCase().includes(termino) ||
        reporte.formato.toLowerCase().includes(termino)
    );
    
    const tbody = document.getElementById('historial-body');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (resultados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: #666;">No se encontraron resultados</td></tr>';
        return;
    }
    
    resultados.forEach(reporte => {
        const fila = document.createElement('tr');
        
        const tipoText = {
            'pacientes': 'Pacientes',
            'tratamientos': 'Tratamientos',
            'inventario': 'Inventario',
            'citas': 'Citas',
            'signos': 'Signos Vitales',
            'general': 'General',
            'personalizado': 'Personalizado'
        }[reporte.tipo] || reporte.tipo;

        fila.innerHTML = `
            <td>
                <strong>${reporte.nombre}</strong>
            </td>
            <td>${tipoText}</td>
            <td>${formatearFecha(reporte.fecha)}</td>
            <td>${reporte.tamaño}</td>
            <td>${reporte.formato}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-view" onclick="verReporte(${reporte.id})" title="Ver reporte" aria-label="Ver reporte ${reporte.nombre}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-action" onclick="descargarReporteExistente(${reporte.id})" title="Descargar reporte" aria-label="Descargar reporte ${reporte.nombre}">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="btn-edit" onclick="eliminarReporte(${reporte.id})" title="Eliminar reporte" aria-label="Eliminar reporte ${reporte.nombre}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
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
console.log('Script reportes inicializado');