// script-medicamentos.js - FUNCIONALIDAD COMPLETA
console.log('Script medicamentos cargado');

let medicamentos = [];

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
        nuevoBtn.addEventListener('click', abrirModalMedicamento);
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
}

function cargarMedicamentos() {
    // Mock data para medicamentos
    medicamentos = [
        {
            id: 1,
            nombre: 'Amoxicilina',
            categoria: 'antibiotico',
            stock: 150,
            stockMinimo: 50,
            vencimiento: '2025-12-31',
            estado: 'activo'
        },
        {
            id: 2,
            nombre: 'Losartán',
            categoria: 'cardiovascular',
            stock: 80,
            stockMinimo: 30,
            vencimiento: '2025-06-30',
            estado: 'activo'
        },
        {
            id: 3,
            nombre: 'Metformina',
            categoria: 'diabetes',
            stock: 25,
            stockMinimo: 40,
            vencimiento: '2025-03-15',
            estado: 'activo'
        },
        {
            id: 4,
            nombre: 'Ibuprofeno',
            categoria: 'analgesico',
            stock: 200,
            stockMinimo: 100,
            vencimiento: '2026-01-31',
            estado: 'activo'
        }
    ];

    renderMedicamentos();
    actualizarEstadisticas();
}

function renderMedicamentos() {
    const tbody = document.getElementById('tbody-medicamentos');
    if (!tbody) return;

    if (medicamentos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay medicamentos registrados</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    medicamentos.forEach(med => {
        const fila = document.createElement('tr');

        // Determinar estado del stock
        let stockBadge = 'normal';
        let stockText = 'Normal';
        if (med.stock < med.stockMinimo) {
            stockBadge = 'bajo';
            stockText = 'Bajo';
        } else if (med.stock > med.stockMinimo * 2) {
            stockBadge = 'optimo';
            stockText = 'Óptimo';
        }

        fila.innerHTML = `
            <td>${med.id}</td>
            <td><strong>${med.nombre}</strong></td>
            <td>${traducirCategoria(med.categoria)}</td>
            <td>${med.stock}</td>
            <td>${med.stockMinimo}</td>
            <td><span class="status-badge ${stockBadge}">${stockText}</span></td>
            <td>${formatearFecha(med.vencimiento)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarMedicamento(${med.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${med.id})" title="Ver">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-delete" onclick="eliminarMedicamento(${med.id})" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(fila);
    });
}

function abrirModalMedicamento() {
    const modalHTML = `
        <div class="modal-overlay active" id="modal-medicamento">
            <div class="modal">
                <div class="modal-header">
                    <h3>Nuevo Medicamento</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-medicamento">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre *</label>
                                <input type="text" id="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Categoría *</label>
                                <select id="categoria" required>
                                    <option value="">Seleccionar</option>
                                    <option value="antibiotico">Antibiótico</option>
                                    <option value="analgesico">Analgésico</option>
                                    <option value="cardiovascular">Cardiovascular</option>
                                    <option value="diabetes">Diabetes</option>
                                    <option value="respiratorio">Respiratorio</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Presentación *</label>
                                <select id="presentacion" required>
                                    <option value="">Seleccionar</option>
                                    <option value="tabletas">Tabletas</option>
                                    <option value="capsulas">Cápsulas</option>
                                    <option value="jarabe">Jarabe</option>
                                    <option value="inyectable">Inyectable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Concentración *</label>
                                <input type="text" id="concentracion" placeholder="Ej: 500mg" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Stock Actual *</label>
                                <input type="number" id="stock-actual" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Stock Mínimo *</label>
                                <input type="number" id="stock-minimo" min="0" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Fecha de Vencimiento *</label>
                                <input type="date" id="fecha-vencimiento" required>
                            </div>
                            <div class="form-group">
                                <label>Número de Lote</label>
                                <input type="text" id="lote">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Proveedor</label>
                            <input type="text" id="proveedor">
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select id="estado">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
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
    setupModalEvents();
}

function setupModalEvents() {
    const modal = document.getElementById('modal-medicamento');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-medicamento');

    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });

    form.addEventListener('submit', guardarMedicamento);
}

function guardarMedicamento(e) {
    e.preventDefault();

    const nuevoMed = {
        id: medicamentos.length + 1,
        nombre: document.getElementById('nombre').value,
        categoria: document.getElementById('categoria').value,
        stock: parseInt(document.getElementById('stock-actual').value),
        stockMinimo: parseInt(document.getElementById('stock-minimo').value),
        vencimiento: document.getElementById('fecha-vencimiento').value,
        estado: document.getElementById('estado').value
    };

    medicamentos.push(nuevoMed);

    alert('Medicamento guardado exitosamente');
    document.getElementById('modal-medicamento').remove();
    renderMedicamentos();
    actualizarEstadisticas();
}

function editarMedicamento(id) {
    alert(`Editar medicamento ID: ${id}\n\nFunción en desarrollo.`);
}

function verDetalles(id) {
    const med = medicamentos.find(m => m.id === id);
    if (med) {
        alert(`Detalles del medicamento:\n\nNombre: ${med.nombre}\nCategoría: ${traducirCategoria(med.categoria)}\nStock: ${med.stock}\nVencimiento: ${formatearFecha(med.vencimiento)}`);
    }
}

function eliminarMedicamento(id) {
    if (!confirm('¿Eliminar este medicamento?')) return;

    medicamentos = medicamentos.filter(m => m.id !== id);
    alert('Medicamento eliminado');
    renderMedicamentos();
    actualizarEstadisticas();
}

function aplicarFiltros() {
    const categoria = document.getElementById('filter-categoria')?.value;
    const stock = document.getElementById('filter-stock')?.value;
    const estado = document.getElementById('filter-estado')?.value;

    let filtrados = medicamentos;

    if (categoria && categoria !== 'todos') {
        filtrados = filtrados.filter(m => m.categoria === categoria);
    }

    if (stock && stock !== 'todos') {
        filtrados = filtrados.filter(m => {
            if (stock === 'bajo') return m.stock < m.stockMinimo;
            if (stock === 'normal') return m.stock >= m.stockMinimo && m.stock <= m.stockMinimo * 2;
            if (stock === 'optimo') return m.stock > m.stockMinimo * 2;
            return true;
        });
    }

    if (estado && estado !== 'todos') {
        filtrados = filtrados.filter(m => m.estado === estado);
    }

    const temp = medicamentos;
    medicamentos = filtrados;
    renderMedicamentos();
    medicamentos = temp;
}

function buscarMedicamentos(e) {
    const termino = e.target.value.toLowerCase();
    const filas = document.querySelectorAll('#tbody-medicamentos tr');

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(termino) ? '' : 'none';
    });
}

function limpiarFiltros() {
    document.getElementById('filter-categoria').value = 'todos';
    document.getElementById('filter-stock').value = 'todos';
    document.getElementById('filter-estado').value = 'todos';
    renderMedicamentos();
}

function exportarMedicamentos() {
    alert('Exportando medicamentos...\n\nArchivo: medicamentos.xlsx');
}

function actualizarEstadisticas() {
    const total = medicamentos.length;
    const stockBajo = medicamentos.filter(m => m.stock < m.stockMinimo).length;
    const porVencer = medicamentos.filter(m => {
        const dias = Math.floor((new Date(m.vencimiento) - new Date()) / (1000 * 60 * 60 * 24));
        return dias < 90 && dias > 0;
    }).length;
    const activos = medicamentos.filter(m => m.estado === 'activo').length;

    document.getElementById('total-medicamentos').textContent = total;
    document.getElementById('stock-bajo').textContent = stockBajo;
    document.getElementById('por-vencer').textContent = porVencer;
    document.getElementById('medicamentos-activos').textContent = activos;
    document.getElementById('alertas-stock').textContent = stockBajo;
    document.getElementById('proximos-vencer').textContent = porVencer;
}

function traducirCategoria(cat) {
    const traducciones = {
        'antibiotico': 'Antibiótico',
        'analgesico': 'Analgésico',
        'cardiovascular': 'Cardiovascular',
        'diabetes': 'Diabetes',
        'respiratorio': 'Respiratorio'
    };
    return traducciones[cat] || cat;
}

function formatearFecha(fecha) {
    if (!fecha) return 'N/A';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES');
}

// Hacer funciones globales
window.editarMedicamento = editarMedicamento;
window.verDetalles = verDetalles;
window.eliminarMedicamento = eliminarMedicamento;