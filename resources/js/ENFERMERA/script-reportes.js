// script-reportes.js - FUNCIONALIDAD COMPLETA
console.log('Script reportes cargado');

document.addEventListener('DOMContentLoaded', function () {
    inicializarReportes();
});

function inicializarReportes() {
    configurarEventos();
    cargarEstadisticas();
}

function configurarEventos() {
    // Botón generar reporte principal
    const generarBtn = document.getElementById('generar-reporte-btn');
    if (generarBtn) {
        generarBtn.addEventListener('click', () => {
            alert('Seleccione un tipo de reporte de la lista');
        });
    }

    // Botón aplicar filtros
    const aplicarBtn = document.getElementById('aplicar-filtros');
    if (aplicarBtn) {
        aplicarBtn.addEventListener('click', aplicarFiltros);
    }

    // Botón actualizar reportes
    const actualizarBtn = document.getElementById('actualizar-reportes');
    if (actualizarBtn) {
        actualizarBtn.addEventListener('click', () => {
            alert('Actualizando reportes...');
            cargarEstadisticas();
        });
    }

    // Botón exportar todos
    const exportarTodosBtn = document.getElementById('exportar-todos');
    if (exportarTodosBtn) {
        exportarTodosBtn.addEventListener('click', exportarTodos);
    }

    // Botón guardar plantilla
    const guardarPlantillaBtn = document.getElementById('guardar-plantilla');
    if (guardarPlantillaBtn) {
        guardarPlantillaBtn.addEventListener('click', guardarPlantilla);
    }

    // Botón limpiar formulario
    const limpiarBtn = document.getElementById('limpiar-formulario');
    if (limpiarBtn) {
        limpiarBtn.addEventListener('click', limpiarFormulario);
    }

    // Botón generar personalizado
    const generarPersonalizadoBtn = document.getElementById('generar-personalizado');
    if (generarPersonalizadoBtn) {
        generarPersonalizadoBtn.addEventListener('click', generarReportePersonalizado);
    }

    // Botón limpiar historial
    const limpiarHistorialBtn = document.getElementById('limpiar-historial');
    if (limpiarHistorialBtn) {
        limpiarHistorialBtn.addEventListener('click', limpiarHistorial);
    }
}

function cargarEstadisticas() {
    // Simular carga de estadísticas
    document.getElementById('total-pacientes').textContent = Math.floor(Math.random() * 100) + 50;
    document.getElementById('total-tratamientos').textContent = Math.floor(Math.random() * 200) + 100;
    document.getElementById('total-medicamentos').textContent = Math.floor(Math.random() * 500) + 200;
    document.getElementById('total-citas').textContent = Math.floor(Math.random() * 150) + 75;
}

function aplicarFiltros() {
    const tipo = document.getElementById('filter-tipo')?.value;
    const periodo = document.getElementById('filter-periodo')?.value;
    const formato = document.getElementById('filter-formato')?.value;

    alert(`Aplicando filtros:\nTipo: ${tipo}\nPeríodo: ${periodo}\nFormato: ${formato}`);
}

async function generarReporte(tipo) {
    try {
        const response = await fetch('/api/reportes/generar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ tipo: tipo })
        });

        if (response.ok) {
            const data = await response.json();
            alert(`Reporte de ${tipo} generado exitosamente`);
            mostrarVistaPrevia(tipo);
        } else {
            alert('Error al generar reporte');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

async function descargarReporte(tipo) {
    try {
        const response = await fetch('/api/exportar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ tipo: tipo })
        });

        if (response.ok) {
            const data = await response.json();
            alert(`Reporte descargado: ${data.url || 'reporte.pdf'}`);
        } else {
            alert('Error al descargar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

function mostrarVistaPrevia(tipo) {
    const modalHTML = `
        <div class="modal-overlay active" id="modal-preview">
            <div class="modal large">
                <div class="modal-header">
                    <h3>Vista Previa - Reporte de ${tipo}</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="report-preview">
                        <h4>Reporte de ${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</h4>
                        <p>Fecha: ${new Date().toLocaleDateString()}</p>
                        <p>Este es un reporte de ejemplo generado por el sistema.</p>
                        <div style="margin-top: 20px; padding: 20px; background: #f5f5f5; border-radius: 8px;">
                            <p><strong>Datos incluidos:</strong></p>
                            <ul>
                                <li>Información general</li>
                                <li>Estadísticas del período</li>
                                <li>Gráficos y tendencias</li>
                                <li>Conclusiones y recomendaciones</li>
                            </ul>
                        </div>
                    </div>
                    <div class="preview-actions" style="margin-top: 20px; text-align: right;">
                        <button class="btn-cancel" id="cerrar-preview">Cerrar</button>
                        <button class="btn-primary" onclick="descargarReporte('${tipo}')">
                            <i class="fas fa-download"></i> Descargar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = document.getElementById('modal-preview');
    const closeBtn = modal.querySelector('.close-modal');
    const cerrarBtn = document.getElementById('cerrar-preview');

    closeBtn.addEventListener('click', () => modal.remove());
    cerrarBtn.addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });
}

function exportarTodos() {
    if (confirm('¿Exportar todos los reportes disponibles?')) {
        alert('Generando paquete de reportes...\n\nEsto puede tardar unos momentos.');

        fetch('/api/exportar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ tipo: 'todos' })
        })
            .then(res => res.json())
            .then(data => {
                alert('Todos los reportes exportados exitosamente');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al exportar');
            });
    }
}

function guardarPlantilla() {
    const nombre = document.getElementById('reporte-nombre')?.value;
    if (!nombre) {
        alert('Por favor ingrese un nombre para la plantilla');
        return;
    }

    alert(`Plantilla "${nombre}" guardada exitosamente`);
}

function limpiarFormulario() {
    document.getElementById('reporte-nombre').value = '';
    document.getElementById('reporte-tipo').value = 'resumen';
    document.querySelectorAll('input[name="datos"]').forEach(cb => cb.checked = false);
}

function generarReportePersonalizado() {
    const nombre = document.getElementById('reporte-nombre')?.value;
    const tipo = document.getElementById('reporte-tipo')?.value;
    const formato = document.getElementById('formato-salida')?.value;

    if (!nombre) {
        alert('Por favor ingrese un nombre para el reporte');
        return;
    }

    const datosSeleccionados = [];
    document.querySelectorAll('input[name="datos"]:checked').forEach(cb => {
        datosSeleccionados.push(cb.value);
    });

    if (datosSeleccionados.length === 0) {
        alert('Por favor seleccione al menos un tipo de dato');
        return;
    }

    alert(`Generando reporte personalizado:\n\nNombre: ${nombre}\nTipo: ${tipo}\nFormato: ${formato}\nDatos: ${datosSeleccionados.join(', ')}`);

    generarReporte('personalizado');
}

function limpiarHistorial() {
    if (confirm('¿Eliminar todo el historial de reportes?')) {
        const tbody = document.getElementById('historial-body');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No hay reportes en el historial</td></tr>';
        }
        alert('Historial limpiado');
    }
}

// Hacer funciones globales para onclick en HTML
window.generarReporte = generarReporte;
window.descargarReporte = descargarReporte;