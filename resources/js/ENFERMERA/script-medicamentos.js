// script-medicamentos.js - FUNCIONALIDAD COMPLETA
console.log('Script medicamentos cargado');

let medicamentos = [];
let currentEditId = null;
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const defaultHeaders = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
};

document.addEventListener('DOMContentLoaded', function () {
    inicializarApp();
});

function inicializarApp() {
    cargarMedicamentos();
    configurarEventos();
}

function configurarEventos() {
    // Botón nuevo medicamento
    const nuevoBtn = document.getElementById('nuevo-medicamento-btn');
    if (nuevoBtn) {
        nuevoBtn.addEventListener('click', () => abrirModalMedicamento());
    }

    // Botón actualizar
    const refreshBtn = document.getElementById('refresh-list');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', cargarMedicamentos);
    }

    // Botón limpiar filtros
    const resetBtn = document.getElementById('reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', limpiarFiltros);
    }

    // Botón exportar
    const exportBtn = document.getElementById('export-medicamentos');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportarMedicamentos);
    }

    // Filtros
    const filterCategoria = document.getElementById('filter-categoria');
    if (filterCategoria) {
        filterCategoria.addEventListener('change', aplicarFiltros);
    }

    const filterStock = document.getElementById('filter-stock');
    if (filterStock) {
        filterStock.addEventListener('change', aplicarFiltros);
    }

    const filterEstado = document.getElementById('filter-estado');
    if (filterEstado) {
        filterEstado.addEventListener('change', aplicarFiltros);
    }

    // Búsqueda
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', buscarMedicamentos);
    }

    // Alertas de Stock (Clickable)
    const stockBajoAlert = document.getElementById('alertas-stock').parentElement.parentElement;
    if (stockBajoAlert) {
        stockBajoAlert.style.cursor = 'pointer';
        stockBajoAlert.addEventListener('click', () => {
            document.getElementById('filter-stock').value = 'bajo';
            aplicarFiltros();
        });
    }

    const porVencerAlert = document.getElementById('proximos-vencer').parentElement.parentElement;
    if (porVencerAlert) {
        porVencerAlert.style.cursor = 'pointer';
        porVencerAlert.addEventListener('click', () => {
            // Logic to filter by expiration date (custom filter needed or just show all for now)
            // Since we don't have a specific filter dropdown for expiration, we can filter manually
            const porVencer = medicamentos.filter(m => {
                const dias = Math.floor((new Date(m.expiration_date) - new Date()) / (1000 * 60 * 60 * 24));
                return dias < 90 && dias > 0;
            });
            renderMedicamentos(porVencer);
        });
    }

    // Inventory Summary Clickable
    const summaryStockBajo = document.getElementById('stock-bajo').parentElement;
    if (summaryStockBajo) {
        summaryStockBajo.style.cursor = 'pointer';
        summaryStockBajo.addEventListener('click', () => {
            document.getElementById('filter-stock').value = 'bajo';
            aplicarFiltros();
        });
    }

    const summaryPorVencer = document.getElementById('por-vencer').parentElement;
    if (summaryPorVencer) {
        summaryPorVencer.style.cursor = 'pointer';
        summaryPorVencer.addEventListener('click', () => {
            const porVencer = medicamentos.filter(m => {
                const dias = Math.floor((new Date(m.expiration_date) - new Date()) / (1000 * 60 * 60 * 24));
                return dias < 90 && dias > 0;
            });
            renderMedicamentos(porVencer);
        });
    }

    const summaryActivos = document.getElementById('medicamentos-activos').parentElement;
    if (summaryActivos) {
        summaryActivos.style.cursor = 'pointer';
        summaryActivos.addEventListener('click', () => {
            document.getElementById('filter-estado').value = 'active'; // Note: value in select is 'active' now
            aplicarFiltros();
        });
    }
}

async function cargarMedicamentos() {
    try {
        const response = await fetch('/api/medicamentos', { headers: { Accept: 'application/json' } });
        if (!response.ok) throw new Error('Error al cargar medicamentos');
        medicamentos = await response.json();
        renderMedicamentos();
        actualizarEstadisticas();
    } catch (error) {
        console.error('Error:', error);
        // alert('Error al cargar la lista de medicamentos'); // Suppress alert on load to avoid annoyance if empty
    }
}

function renderMedicamentos(lista = medicamentos) {
    const tbody = document.getElementById('tbody-medicamentos');
    if (!tbody) return;

    if (lista.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay medicamentos registrados</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    lista.forEach(med => {
        const fila = document.createElement('tr');

        // Determinar estado del stock
        let stockBadge = 'normal';
        let stockText = 'Normal';
        if (med.stock < med.min_stock) {
            stockBadge = 'bajo';
            stockText = 'Bajo';
        } else if (med.stock > med.min_stock * 2) {
            stockBadge = 'optimo';
            stockText = 'Óptimo';
        }

        fila.innerHTML = `
            <td>${med.id}</td>
            <td><strong>${med.name}</strong></td>
            <td>${traducirCategoria(med.category)}</td>
            <td>${med.stock}</td>
            <td>${med.min_stock}</td>
            <td><span class="status-badge ${stockBadge}">${stockText}</span></td>
            <td>${formatearFecha(med.expiration_date)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarMedicamento(${med.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-view" data-id="${med.id}" title="Ver" onclick="verDetalles(${med.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-delete" data-id="${med.id}" title="Eliminar" onclick="eliminarMedicamento(${med.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(fila);
    });
}

function abrirModalMedicamento(med = null) {
    currentEditId = med ? med.id : null;
    const titulo = med ? 'Editar Medicamento' : 'Nuevo Medicamento';
    const btnText = med ? 'Actualizar' : 'Guardar';

    const modalHTML = `
        <div class="modal-overlay active" id="modal-medicamento">
            <div class="modal">
                <div class="modal-header">
                    <h3>${titulo}</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-medicamento">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre *</label>
                                <input type="text" id="nombre" required value="${med ? med.name : ''}">
                            </div>
                            <div class="form-group">
                                <label>Categoria *</label>
                                <select id="categoria" required>
                                    <option value="">Seleccionar</option>
                                    <option value="antibiotico" ${med && med.category === 'antibiotico' ? 'selected' : ''}>Antibiotico</option>
                                    <option value="analgesico" ${med && med.category === 'analgesico' ? 'selected' : ''}>Analgesico</option>
                                    <option value="cardiovascular" ${med && med.category === 'cardiovascular' ? 'selected' : ''}>Cardiovascular</option>
                                    <option value="diabetes" ${med && med.category === 'diabetes' ? 'selected' : ''}>Diabetes</option>
                                    <option value="respiratorio" ${med && med.category === 'respiratorio' ? 'selected' : ''}>Respiratorio</option>
                                    <option value="gastrointestinal" ${med && med.category === 'gastrointestinal' ? 'selected' : ''}>Gastrointestinal</option>
                                    <option value="neurologico" ${med && med.category === 'neurologico' ? 'selected' : ''}>Neurologico</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Presentación *</label>
                                <select id="presentacion" required>
                                    <option value="">Seleccionar</option>
                                    <option value="tabletas" ${med && med.presentation === 'tabletas' ? 'selected' : ''}>Tabletas</option>
                                    <option value="capsulas" ${med && med.presentation === 'capsulas' ? 'selected' : ''}>Cápsulas</option>
                                    <option value="jarabe" ${med && med.presentation === 'jarabe' ? 'selected' : ''}>Jarabe</option>
                                    <option value="inyectable" ${med && med.presentation === 'inyectable' ? 'selected' : ''}>Inyectable</option>
                                    <option value="crema" ${med && med.presentation === 'crema' ? 'selected' : ''}>Crema</option>
                                    <option value="unguento" ${med && med.presentation === 'unguento' ? 'selected' : ''}>Ungüento</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Concentración *</label>
                                <input type="text" id="concentracion" placeholder="Ej: 500mg" required value="${med ? med.concentration : ''}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Stock Actual *</label>
                                <input type="number" id="stock-actual" min="0" required value="${med ? med.stock : ''}">
                            </div>
                            <div class="form-group">
                                <label>Stock Mínimo *</label>
                                <input type="number" id="stock-minimo" min="0" required value="${med ? med.min_stock : ''}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Fecha de Vencimiento *</label>
                                <input type="date" id="fecha-vencimiento" required value="${med ? med.expiration_date : ''}">
                            </div>
                            <div class="form-group">
                                <label>Número de Lote</label>
                                <input type="text" id="lote" value="${med && med.batch_number ? med.batch_number : ''}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Proveedor</label>
                            <input type="text" id="proveedor" value="${med && med.provider ? med.provider : ''}">
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select id="estado">
                                <option value="active" ${med && med.status === 'active' ? 'selected' : ''}>Activo</option>
                                <option value="inactive" ${med && med.status === 'inactive' ? 'selected' : ''}>Inactivo</option>
                            </select>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="cancel-form">Cancelar</button>
                            <button type="submit" class="btn-primary">${btnText}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    setupModalEvents();
}

function setupModalEvents() {
    const modal = document.getElementById('modal-medicamento');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-medicamento');

    const closeModal = () => modal.remove();

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    form.addEventListener('submit', guardarMedicamento);
}

async function guardarMedicamento(e) {
    e.preventDefault();

    const data = {
        name: document.getElementById('nombre').value,
        category: document.getElementById('categoria').value,
        presentation: document.getElementById('presentacion').value,
        concentration: document.getElementById('concentracion').value,
        stock: parseInt(document.getElementById('stock-actual').value),
        min_stock: parseInt(document.getElementById('stock-minimo').value),
        expiration_date: document.getElementById('fecha-vencimiento').value,
        batch_number: document.getElementById('lote').value,
        provider: document.getElementById('proveedor').value,
        status: document.getElementById('estado').value
    };

    const url = currentEditId ? `/api/medicamentos/${currentEditId}` : '/api/medicamentos';
    const method = currentEditId ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method,
            headers: defaultHeaders,
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            let message = `Error ${response.status}`;
            try {
                const errorJson = await response.json();
                const firstError = Object.values(errorJson.errors || {})[0]?.[0];
                message = firstError || errorJson.message || message;
            } catch {
                message = await response.text();
            }
            throw new Error(message);
        }

        mostrarNotificacion('Medicamento guardado correctamente', 'success');
        document.getElementById('modal-medicamento').remove();
        cargarMedicamentos();
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error al guardar el medicamento: ' + error.message, 'error');
    }
}

function editarMedicamento(id) {
    const med = medicamentos.find(m => m.id === id);
    if (med) {
        abrirModalMedicamento(med);
    }
}

function verDetalles(id) {
    const med = medicamentos.find(m => m.id === id);
    if (!med) return;

    const modalHTML = `
        <div class="modal-overlay active" id="modal-detalle-medicamento">
            <div class="modal">
                <div class="modal-header">
                    <h3>Detalles del Medicamento</h3>
                    <button class="close-modal" id="close-detalle">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div><strong>Nombre:</strong> ${med.name}</div>
                        <div><strong>Categoría:</strong> ${traducirCategoria(med.category)}</div>
                        <div><strong>Presentación:</strong> ${med.presentation}</div>
                        <div><strong>Concentración:</strong> ${med.concentration}</div>
                        <div><strong>Stock:</strong> ${med.stock}</div>
                        <div><strong>Stock Mínimo:</strong> ${med.min_stock}</div>
                        <div><strong>Estado:</strong> ${med.status === 'active' ? 'Activo' : 'Inactivo'}</div>
                        <div><strong>Vencimiento:</strong> ${formatearFecha(med.expiration_date)}</div>
                        <div><strong>Lote:</strong> ${med.batch_number || 'N/A'}</div>
                        <div><strong>Proveedor:</strong> ${med.provider || 'N/A'}</div>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary" id="cerrar-detalle">Cerrar</button>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    const modal = document.getElementById('modal-detalle-medicamento');
    const closeButtons = modal.querySelectorAll('#close-detalle, #cerrar-detalle');
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });
    closeButtons.forEach(btn => btn.addEventListener('click', () => modal.remove()));
}

async function eliminarMedicamento(id) {
    console.log('Eliminar medicamento', id);
    if (!confirm('Eliminar este medicamento?')) return;

    try {
        const response = await fetch(`/api/medicamentos/${id}`, {
            method: 'DELETE',
            headers: { ...defaultHeaders, Accept: 'application/json' }
        });

        if (!response.ok) {
            let message = 'Error al eliminar';
            try {
                const errorJson = await response.json();
                message = errorJson.message || message;
            } catch {
                message = await response.text();
            }
            throw new Error(message);
        }

        mostrarNotificacion('Medicamento eliminado', 'success');
        cargarMedicamentos();
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error al eliminar el medicamento: ' + error.message, 'error');
    }
}

function aplicarFiltros() {
    const categoria = document.getElementById('filter-categoria')?.value;
    const stock = document.getElementById('filter-stock')?.value;
    const estado = document.getElementById('filter-estado')?.value;

    let filtrados = medicamentos;

    if (categoria && categoria !== 'todos') {
        filtrados = filtrados.filter(m => m.category === categoria);
    }

    if (stock && stock !== 'todos') {
        filtrados = filtrados.filter(m => {
            if (stock === 'bajo') return m.stock < m.min_stock;
            if (stock === 'normal') return m.stock >= m.min_stock && m.stock <= m.min_stock * 2;
            if (stock === 'optimo') return m.stock > m.min_stock * 2;
            return true;
        });
    }

    if (estado && estado !== 'todos') {
        // Map 'activo'/'inactivo' from select to 'active'/'inactive' from DB if needed
        // Assuming select values are 'active'/'inactive' now
        filtrados = filtrados.filter(m => m.status === estado);
    }

    renderMedicamentos(filtrados);
}

function buscarMedicamentos(e) {
    const termino = e.target.value.toLowerCase();
    const filtrados = medicamentos.filter(med =>
        med.name.toLowerCase().includes(termino) ||
        med.category.toLowerCase().includes(termino)
    );
    renderMedicamentos(filtrados);
}

function limpiarFiltros() {
    document.getElementById('filter-categoria').value = 'todos';
    document.getElementById('filter-stock').value = 'todos';
    document.getElementById('filter-estado').value = 'todos';
    renderMedicamentos();
}

function exportarMedicamentos() {
    mostrarNotificacion('Exportando medicamentos... (placeholder)', 'success');
}

function actualizarEstadisticas() {
    const total = medicamentos.length;
    const stockBajo = medicamentos.filter(m => m.stock < m.min_stock).length;
    const porVencer = medicamentos.filter(m => {
        const dias = Math.floor((new Date(m.expiration_date) - new Date()) / (1000 * 60 * 60 * 24));
        return dias < 90 && dias > 0;
    }).length;
    const activos = medicamentos.filter(m => m.status === 'active').length;

    document.getElementById('total-medicamentos').textContent = total;
    document.getElementById('stock-bajo').textContent = stockBajo;
    document.getElementById('por-vencer').textContent = porVencer;
    document.getElementById('medicamentos-activos').textContent = activos;
    document.getElementById('alertas-stock').textContent = stockBajo;
    document.getElementById('proximos-vencer').textContent = porVencer;
}

function traducirCategoria(cat) {
        const traducciones = {
        'antibiotico': 'Antibiotico',
        'analgesico': 'Analgesico',
        'cardiovascular': 'Cardiovascular',
        'diabetes': 'Diabetes',
        'respiratorio': 'Respiratorio',
        'gastrointestinal': 'Gastrointestinal',
        'neurologico': 'Neurologico'
    };
    return traducciones[cat] || cat;
}

function formatearFecha(fecha) {
    if (!fecha) return 'N/A';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES');
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

// Hacer funciones globales
const notifyStyle = document.createElement('style');
notifyStyle.textContent = `
    @keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }
    .notification-content { display: flex; align-items: center; justify-content: space-between; gap: 15px; }
    .notification-close { background: none; border: none; color: white; font-size: 20px; cursor: pointer; padding: 0; line-height: 1; }
`;
document.head.appendChild(notifyStyle);

window.editarMedicamento = editarMedicamento;
window.verDetalles = verDetalles;
window.eliminarMedicamento = eliminarMedicamento;












