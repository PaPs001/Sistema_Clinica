// script-reportes.js - funcionalidad conectada a API mock y UI
console.log('Script reportes cargado');

let historial = [];
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const defaultHeaders = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
};
let alertas = [];

document.addEventListener('DOMContentLoaded', () => {
    configurarEventos();
    cargarEstadisticas();
    renderHistorial();
    inicializarCampanita();
});

function configurarEventos() {
    const generarBtn = document.getElementById('generar-reporte-btn');
    generarBtn?.addEventListener('click', () => {
        const tipo = document.getElementById('filter-tipo')?.value || 'resumen';
        generarReporte(tipo);
    });

    document.getElementById('aplicar-filtros')?.addEventListener('click', aplicarFiltros);
    document.getElementById('actualizar-reportes')?.addEventListener('click', cargarEstadisticas);
    document.getElementById('exportar-todos')?.addEventListener('click', exportarTodos);
    document.getElementById('guardar-plantilla')?.addEventListener('click', guardarPlantilla);
    document.getElementById('limpiar-formulario')?.addEventListener('click', limpiarFormulario);
    document.getElementById('generar-personalizado')?.addEventListener('click', generarReportePersonalizado);
    document.getElementById('limpiar-historial')?.addEventListener('click', limpiarHistorial);
    document.getElementById('generar-personalizado-btn')?.addEventListener('click', generarReportePersonalizado);

    const searchInput = document.getElementById('search-input');
    searchInput?.addEventListener('input', filtrarHistorialPorBusqueda);
}

async function inicializarCampanita() {
    const bell = document.querySelector('.notifications');
    if (!bell) return;

    // Cargar alertas desde API (si existe) o usar mock
    try {
        const res = await fetch('/api/alertas', { headers: { Accept: 'application/json' } });
        alertas = res.ok ? await res.json() : [];
    } catch (e) {
        alertas = [];
    }
    if (!alertas.length) {
        alertas = [
            { id: 1, titulo: 'Reporte listo', detalle: 'El reporte de pacientes se generó correctamente', hora: '10:15' },
            { id: 2, titulo: 'Alerta de stock', detalle: 'Medicamentos con stock crítico', hora: '09:50' },
        ];
    }
    actualizarBadge(alertas.length);

    bell.addEventListener('click', (e) => {
        e.stopPropagation();
        togglePanelNotificaciones();
    });

    document.addEventListener('click', (e) => {
        const panel = document.getElementById('panel-notificaciones');
        if (panel && !panel.contains(e.target)) {
            panel.remove();
        }
    });
}

function actualizarBadge(count) {
    const badge = document.querySelector('.notifications .notification-badge');
    if (!badge) return;
    badge.textContent = count;
    badge.style.display = count > 0 ? 'inline-flex' : 'none';
}

function togglePanelNotificaciones() {
    const existing = document.getElementById('panel-notificaciones');
    if (existing) {
        existing.remove();
        return;
    }

    const panel = document.createElement('div');
    panel.id = 'panel-notificaciones';
    panel.className = 'notif-panel';
    panel.innerHTML = `
        <div class="notif-header">
            <span>Notificaciones</span>
            <button class="notif-mark" type="button">Marcar leídas</button>
        </div>
        <div class="notif-list">
            ${alertas.length
            ? alertas
                .map(
                    (a) => `
                <div class="notif-item">
                    <div class="notif-title">${a.titulo || 'Notificación'}</div>
                    <div class="notif-detail">${a.detalle || ''}</div>
                    <div class="notif-time">${a.hora || ''}</div>
                </div>`
                )
                .join('')
            : '<div class="notif-empty">Sin notificaciones</div>'
        }
        </div>
    `;
    document.body.appendChild(panel);

    panel.querySelector('.notif-mark')?.addEventListener('click', () => {
        alertas = [];
        actualizarBadge(0);
        panel.remove();
    });
}

async function cargarEstadisticas() {
    try {
        const [pacientesRes, tratamientosRes, medsRes, citasRes] = await Promise.all([
            fetch('/api/pacientes', { headers: { Accept: 'application/json' } }),
            fetch('/api/tratamientos', { headers: { Accept: 'application/json' } }),
            fetch('/api/medicamentos', { headers: { Accept: 'application/json' } }),
            fetch('/api/citas', { headers: { Accept: 'application/json' } }),
        ]);

        const pacientes = pacientesRes.ok ? await pacientesRes.json() : [];
        const tratamientos = tratamientosRes.ok ? await tratamientosRes.json() : [];
        const medicamentos = medsRes.ok ? await medsRes.json() : [];
        const citas = citasRes.ok ? await citasRes.json() : [];

        setText('total-pacientes', pacientes.length);
        setText('total-tratamientos', tratamientos.length);
        setText('total-medicamentos', medicamentos.length);
        setText('total-citas', citas.length);

        mostrarNotificacion('Estadísticas cargadas', 'success');
    } catch (error) {
        console.error(error);
        mostrarNotificacion('No se pudieron cargar las estadísticas', 'error');
    }
}

function aplicarFiltros() {
    const tipo = document.getElementById('filter-tipo')?.value || 'todos';
    const periodo = document.getElementById('filter-periodo')?.value || 'hoy';
    const formato = document.getElementById('filter-formato')?.value || 'todos';

    const filtrados = historial.filter((item) => {
        const pasaTipo = tipo === 'todos' || item.tipo === tipo;
        const pasaFormato = formato === 'todos' || item.formato === formato;
        const pasaPeriodo = filtraPorPeriodo(item.fecha, periodo);
        return pasaTipo && pasaFormato && pasaPeriodo;
    });

    renderHistorial(filtrados);
    mostrarNotificacion('Filtros aplicados', 'success');
}

async function generarReporte(tipo) {
    try {
        const response = await fetch('/api/reportes/generar', {
            method: 'POST',
            headers: defaultHeaders,
            body: JSON.stringify({ tipo }),
        });

        if (!response.ok) {
            const body = await response.text();
            throw new Error(`Error ${response.status}: ${body || 'no se pudo generar el reporte'}`);
        }

        const data = await safeJson(response);

        const entrada = crearEntradaHistorial({
            nombre: `Reporte de ${tipo}`,
            tipo,
            formato: 'pdf',
            url: data.url || '#',
        });
        historial.unshift(entrada);
        renderHistorial();

        mostrarVistaPrevia(entrada);
        mostrarNotificacion('Reporte generado', 'success');
    } catch (error) {
        console.error(error);
        mostrarNotificacion('No se pudo generar el reporte', 'error');
    }
}

async function descargarReporte(tipo, url = null) {
    try {
        const response = await fetch('/api/exportar', {
            method: 'POST',
            headers: defaultHeaders,
            credentials: 'same-origin',
            body: JSON.stringify({ tipo }),
        });

        if (!response.ok) {
            const body = await response.text();
            throw new Error(`Error ${response.status}: ${body || 'no se pudo exportar'}`);
        }
        const data = await safeJson(response);
        const link = url || data.url || '';

        if (!link) {
            throw new Error(`No se recibio URL de descarga. Respuesta: ${JSON.stringify(data)}`);
        }

        const a = document.createElement('a');
        a.href = link;
        a.download = '';
        a.target = '_blank';
        a.rel = 'noopener';
        document.body.appendChild(a);
        a.click();
        a.remove();

        mostrarNotificacion('Descarga iniciada', 'success');
    } catch (error) {
        console.error(error);
        mostrarNotificacion('No se pudo descargar: ' + error.message, 'error');
    }
}

function mostrarVistaPrevia(entrada) {
    const modalId = 'modal-preview-dynamic';
    const existing = document.getElementById(modalId);
    existing?.remove();

    const modalHTML = `
        <div class="modal-overlay active" id="${modalId}">
            <div class="modal large">
                <div class="modal-header">
                    <h3>Vista Previa - ${entrada.nombre}</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="report-preview">
                        <h4>${entrada.nombre}</h4>
                        <p>Fecha: ${formatearFecha(entrada.fecha)}</p>
                        <p>Formato: ${entrada.formato.toUpperCase()}</p>
                        <div class="preview-chart">[Gráfico de ejemplo]</div>
                        <div style="margin-top: 15px;">
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
                        <button class="btn-cancel" id="cerrar-preview" type="button">Cerrar</button>
                        <button class="btn-primary" id="descargar-preview" type="button">
                            <i class="fas fa-download"></i> Descargar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.querySelector('.close-modal')?.addEventListener('click', () => modal.remove());
    modal.querySelector('#cerrar-preview')?.addEventListener('click', () => modal.remove());
    modal.querySelector('#descargar-preview')?.addEventListener('click', () => descargarReporte(entrada.tipo, entrada.url));
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });
}

function exportarTodos() {
    if (!confirm('Exportar todos los reportes disponibles?')) return;
    descargarReporte('todos');
}

function guardarPlantilla() {
    const nombre = document.getElementById('reporte-nombre')?.value;
    if (!nombre) {
        mostrarNotificacion('Ingresa un nombre para la plantilla', 'error');
        return;
    }
    mostrarNotificacion(`Plantilla "${nombre}" guardada`, 'success');
}

function limpiarFormulario() {
    const nombre = document.getElementById('reporte-nombre');
    const tipo = document.getElementById('reporte-tipo');
    const formato = document.getElementById('formato-salida');
    nombre && (nombre.value = '');
    tipo && (tipo.value = 'resumen');
    formato && (formato.value = 'pdf');
    document.querySelectorAll('input[name="datos"]').forEach((cb) => (cb.checked = false));
    mostrarNotificacion('Formulario limpiado', 'success');
}

function generarReportePersonalizado() {
    const nombre = document.getElementById('reporte-nombre')?.value;
    const tipo = document.getElementById('reporte-tipo')?.value;
    const formato = document.getElementById('formato-salida')?.value || 'pdf';
    const fechaInicio = document.querySelector('input[type="date"]#fecha-inicio-personalizado')?.value
        || document.querySelector('.content input[type="date"]')?.value
        || '';
    const fechaFin = document.querySelectorAll('input[type="date"]')[1]?.value || '';
    const observaciones = document.getElementById('observaciones')?.value || '';

    if (!nombre) {
        mostrarNotificacion('Ingresa un nombre para el reporte', 'error');
        return;
    }

    const datosSeleccionados = [];
    document.querySelectorAll('input[name="datos"]:checked').forEach((cb) => datosSeleccionados.push(cb.value));

    const entrada = crearEntradaHistorial({
        nombre,
        tipo,
        formato,
        url: '#',
        datos: datosSeleccionados,
        rango: { inicio: fechaInicio, fin: fechaFin },
        observaciones,
    });
    historial.unshift(entrada);
    renderHistorial();
    mostrarVistaPrevia(entrada);
    mostrarNotificacion('Reporte personalizado generado', 'success');
}

function limpiarHistorial() {
    if (!confirm('Eliminar todo el historial de reportes?')) return;
    historial = [];
    renderHistorial();
    mostrarNotificacion('Historial limpiado', 'success');
}

function filtrarHistorialPorBusqueda(e) {
    const termino = e.target.value.toLowerCase();
    const filtrados = historial.filter((item) => item.nombre.toLowerCase().includes(termino));
    renderHistorial(filtrados);
}

function renderHistorial(lista = historial) {
    const tbody = document.getElementById('historial-body');
    if (!tbody) return;

    if (lista.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Sin reportes generados</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    lista.forEach((item) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.nombre}</td>
            <td>${item.tipo}</td>
            <td>${formatearFecha(item.fecha)}</td>
            <td>${item.formato.toUpperCase()}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-view" title="Ver" onclick="mostrarVistaPreviaDesdeHistorial('${item.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-primary" title="Descargar" onclick="descargarReporte('${item.tipo}', '${item.url}')">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function mostrarVistaPreviaDesdeHistorial(id) {
    const entrada = historial.find((item) => item.id === id);
    if (entrada) {
        mostrarVistaPrevia(entrada);
    }
}

function crearEntradaHistorial({ nombre, tipo, formato, url = '#', datos = [] }) {
    return {
        id: `${Date.now()}-${Math.random().toString(16).slice(2)}`,
        nombre,
        tipo,
        formato,
        url,
        fecha: new Date().toISOString(),
        datos,
    };
}

function filtraPorPeriodo(fechaISO, periodo) {
    const fecha = new Date(fechaISO);
    const hoy = new Date();
    const diffDias = (hoy - fecha) / (1000 * 60 * 60 * 24);

    switch (periodo) {
        case 'hoy':
            return fecha.toDateString() === hoy.toDateString();
        case 'semana':
            return diffDias <= 7;
        case 'mes':
            return diffDias <= 30;
        case 'trimestre':
            return diffDias <= 90;
        default:
            return true;
    }
}

function setText(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
}

function formatearFecha(fecha) {
    if (!fecha) return 'N/A';
    const d = new Date(fecha);
    return d.toLocaleDateString('es-ES');
}

async function safeJson(response) {
    try {
        return await response.json();
    } catch {
        return {};
    }
}

function mostrarNotificacion(mensaje, tipo = 'success') {
    const prev = document.querySelector('.custom-notification');
    if (prev) prev.remove();

    const notif = document.createElement('div');
    notif.className = `custom-notification ${tipo}`;
    notif.innerHTML = `
        <div class="notification-content">
            <span>${mensaje}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    notif.style.cssText = `
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
    document.body.appendChild(notif);
    notif.querySelector('.notification-close').addEventListener('click', () => notif.remove());
    setTimeout(() => {
        if (notif.parentElement) {
            notif.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notif.remove(), 300);
        }
    }, 2500);
}

const notifyStyle = document.createElement('style');
notifyStyle.textContent = `
    @keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }
    .notification-content { display: flex; align-items: center; justify-content: space-between; gap: 15px; }
    .notification-close { background: none; border: none; color: white; font-size: 20px; cursor: pointer; padding: 0; line-height: 1; }
    .notif-panel {
        position: absolute;
        top: 60px;
        right: 0;
        width: 320px;
        background: #fff;
        border: 1px solid #e1e5e9;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        z-index: 9999;
        overflow: hidden;
        font-size: 14px;
    }
    .notif-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #061175;
        color: #fff;
        font-weight: 600;
    }
    .notif-mark {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: #fff;
        border-radius: 6px;
        padding: 6px 10px;
        cursor: pointer;
        font-size: 12px;
    }
    .notif-mark:hover { background: rgba(255,255,255,0.25); }
    .notif-list { max-height: 260px; overflow-y: auto; }
    .notif-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f0f2f5;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-title { font-weight: 600; color: #061175; margin-bottom: 4px; }
    .notif-detail { color: #555; font-size: 13px; margin-bottom: 6px; }
    .notif-time { color: #888; font-size: 12px; }
    .notif-empty { padding: 16px; text-align: center; color: #777; }
    .notifications { position: relative; cursor: pointer; }
`;
document.head.appendChild(notifyStyle);

// funciones accesibles globalmente si hiciera falta
window.generarReporte = generarReporte;
window.descargarReporte = descargarReporte;
window.mostrarVistaPrevia = mostrarVistaPrevia;
window.mostrarVistaPreviaDesdeHistorial = mostrarVistaPreviaDesdeHistorial;

// Delegación para cerrar modal si por alguna razón los listeners no se atan
document.addEventListener('click', (e) => {
    const overlay = e.target.closest('.modal-overlay');
    if (!overlay) return;

    if (e.target.matches('.close-modal') || e.target.matches('#cerrar-preview') || e.target === overlay) {
        overlay.remove();
    }

    if (e.target.matches('#descargar-preview')) {
        const tipo = overlay.dataset.tipo || 'todos';
        const url = overlay.dataset.url || '#';
        descargarReporte(tipo, url);
    }
});


