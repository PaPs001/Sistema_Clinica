// script-medicamentos.js - Versión para gestión de medicamentos
console.log('Script medicamentos cargado correctamente');

// Datos de ejemplo para inicializar la aplicación
let medicamentos = [
    {
        id: 1,
        nombre: "Amoxicilina",
        categoria: "antibiotico",
        presentacion: "capsulas",
        concentracion: "500mg",
        stockActual: 45,
        stockMinimo: 20,
        fechaVencimiento: "2024-12-15",
        lote: "AMX-2024-001",
        proveedor: "Farmacéutica Nacional",
        estado: "activo"
    },
    {
        id: 2,
        nombre: "Losartán",
        categoria: "cardiovascular",
        presentacion: "tabletas",
        concentracion: "50mg",
        stockActual: 12,
        stockMinimo: 15,
        fechaVencimiento: "2024-11-30",
        lote: "LOS-2024-002",
        proveedor: "CardioMed S.A.",
        estado: "activo"
    },
    {
        id: 3,
        nombre: "Metformina",
        categoria: "diabetes",
        presentacion: "tabletas",
        concentracion: "850mg",
        stockActual: 78,
        stockMinimo: 25,
        fechaVencimiento: "2025-03-20",
        lote: "MET-2024-003",
        proveedor: "DiabetoCare",
        estado: "activo"
    },
    {
        id: 4,
        nombre: "Ibuprofeno",
        categoria: "analgesico",
        presentacion: "tabletas",
        concentracion: "400mg",
        stockActual: 5,
        stockMinimo: 10,
        fechaVencimiento: "2024-09-10",
        lote: "IBU-2024-004",
        proveedor: "Analges Pharma",
        estado: "activo"
    }
];

// Inicializar la aplicación cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Medicamentos');
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
        cargarMedicamentos();
        
        // Configurar eventos
        configurarEventos();

        console.log('Aplicación de medicamentos inicializada correctamente');
        
    } catch (error) {
        console.error('Error al inicializar la aplicación de medicamentos:', error);
    }
}

function configurarEventos() {
    // Modal de medicamento
    const modal = document.getElementById('modal-medicamento');
    const nuevoBtn = document.getElementById('nuevo-medicamento-btn');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-form');
    const form = document.getElementById('form-medicamento');
    
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
            guardarMedicamento();
        });
    }
    
    // Filtros
    const filterCategoria = document.getElementById('filter-categoria');
    const filterStock = document.getElementById('filter-stock');
    const filterEstado = document.getElementById('filter-estado');
    const resetFilters = document.getElementById('reset-filters');
    
    if (filterCategoria) {
        filterCategoria.addEventListener('change', filtrarMedicamentos);
    }
    
    if (filterStock) {
        filterStock.addEventListener('change', filtrarMedicamentos);
    }
    
    if (filterEstado) {
        filterEstado.addEventListener('change', filtrarMedicamentos);
    }
    
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            filterCategoria.value = 'todos';
            filterStock.value = 'todos';
            filterEstado.value = 'todos';
            filtrarMedicamentos();
        });
    }
    
    // Búsqueda
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', buscarMedicamentos);
    }
    
    // Botones de acción rápida
    const btnInventario = document.getElementById('btn-inventario');
    const btnPedido = document.getElementById('btn-pedido');
    
    if (btnInventario) {
        btnInventario.addEventListener('click', function(e) {
            e.preventDefault();
            realizarInventario();
        });
    }
    
    if (btnPedido) {
        btnPedido.addEventListener('click', function(e) {
            e.preventDefault();
            nuevoPedido();
        });
    }
    
    // Botones de exportar y actualizar
    const exportBtn = document.getElementById('export-medicamentos');
    const refreshBtn = document.getElementById('refresh-list');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', exportMedicamentos);
    }
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshMedicamentos);
    }
}

function actualizarEstadisticas() {
    const total = medicamentos.length;
    const stockBajo = medicamentos.filter(m => m.stockActual <= m.stockMinimo).length;
    const porVencer = medicamentos.filter(m => {
        const hoy = new Date();
        const vencimiento = new Date(m.fechaVencimiento);
        const diffTime = vencimiento - hoy;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays <= 30 && diffDays > 0;
    }).length;
    const activos = medicamentos.filter(m => m.estado === 'activo').length;
    
    // Contar medicamentos con stock crítico (menos del 50% del mínimo)
    const stockCritico = medicamentos.filter(m => m.stockActual < (m.stockMinimo * 0.5)).length;
    
    document.getElementById('total-medicamentos').textContent = total;
    document.getElementById('stock-bajo').textContent = stockBajo;
    document.getElementById('por-vencer').textContent = porVencer;
    document.getElementById('medicamentos-activos').textContent = activos;
    document.getElementById('alertas-stock').textContent = stockCritico;
    document.getElementById('proximos-vencer').textContent = porVencer;
}

function cargarMedicamentos() {
    const tbody = document.getElementById('tbody-medicamentos');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (medicamentos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 20px; color: #666;">No hay medicamentos registrados</td></tr>';
        return;
    }
    
    medicamentos.forEach(medicamento => {
        const fila = document.createElement('tr');
        
        // Determinar estado del stock
        let estadoStock = 'optimo';
        let estadoText = 'Óptimo';
        
        if (medicamento.stockActual === 0) {
            estadoStock = 'critico';
            estadoText = 'Agotado';
        } else if (medicamento.stockActual < (medicamento.stockMinimo * 0.5)) {
            estadoStock = 'critico';
            estadoText = 'Crítico';
        } else if (medicamento.stockActual <= medicamento.stockMinimo) {
            estadoStock = 'bajo';
            estadoText = 'Bajo';
        }
        
        // Verificar si está vencido
        const hoy = new Date();
        const vencimiento = new Date(medicamento.fechaVencimiento);
        if (vencimiento < hoy) {
            estadoStock = 'vencido';
            estadoText = 'Vencido';
        }
        
        const categoriaText = {
            'antibiotico': 'Antibiótico',
            'analgesico': 'Analgésico',
            'cardiovascular': 'Cardiovascular',
            'diabetes': 'Diabetes',
            'respiratorio': 'Respiratorio',
            'gastrointestinal': 'Gastrointestinal',
            'neurologico': 'Neurológico'
        }[medicamento.categoria] || medicamento.categoria;

        fila.innerHTML = `
            <td>${medicamento.id}</td>
            <td>
                <div class="medicamento-info">
                    <div class="medicamento-avatar">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div>
                        <strong>${medicamento.nombre}</strong>
                        <span>${medicamento.concentracion} - ${medicamento.presentacion}</span>
                    </div>
                </div>
            </td>
            <td>${categoriaText}</td>
            <td>${medicamento.stockActual}</td>
            <td>${medicamento.stockMinimo}</td>
            <td><span class="status-badge ${estadoStock}">${estadoText}</span></td>
            <td>${formatearFecha(medicamento.fechaVencimiento)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarMedicamento(${medicamento.id})" title="Editar medicamento" aria-label="Editar ${medicamento.nombre}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="ajustarStock(${medicamento.id})" title="Ajustar Stock" aria-label="Ajustar stock de ${medicamento.nombre}">
                        <i class="fas fa-boxes"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${medicamento.id})" title="Ver Detalles" aria-label="Ver detalles de ${medicamento.nombre}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function formatearFecha(fechaString) {
    const opciones = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(fechaString).toLocaleDateString('es-ES', opciones);
}

function abrirModal(medicamento = null) {
    const modal = document.getElementById('modal-medicamento');
    const titulo = document.getElementById('modal-titulo');
    const form = document.getElementById('form-medicamento');
    
    if (!modal || !titulo || !form) return;
    
    if (medicamento) {
        titulo.textContent = 'Editar Medicamento';
        llenarFormulario(medicamento);
    } else {
        titulo.textContent = 'Nuevo Medicamento';
        form.reset();
        document.getElementById('estado').value = 'activo';
        // Establecer fecha de vencimiento por defecto (1 año desde hoy)
        const nextYear = new Date();
        nextYear.setFullYear(nextYear.getFullYear() + 1);
        document.getElementById('fecha-vencimiento').value = nextYear.toISOString().split('T')[0];
    }
    
    modal.classList.add('active');
}

function cerrarModal() {
    const modal = document.getElementById('modal-medicamento');
    if (modal) {
        modal.classList.remove('active');
    }
}

function llenarFormulario(medicamento) {
    document.getElementById('nombre').value = medicamento.nombre;
    document.getElementById('categoria').value = medicamento.categoria;
    document.getElementById('presentacion').value = medicamento.presentacion;
    document.getElementById('concentracion').value = medicamento.concentracion;
    document.getElementById('stock-actual').value = medicamento.stockActual;
    document.getElementById('stock-minimo').value = medicamento.stockMinimo;
    document.getElementById('fecha-vencimiento').value = medicamento.fechaVencimiento;
    document.getElementById('lote').value = medicamento.lote;
    document.getElementById('proveedor').value = medicamento.proveedor;
    document.getElementById('estado').value = medicamento.estado;
}

function guardarMedicamento() {
    // Obtener datos del formulario
    const nombre = document.getElementById('nombre').value;
    const categoria = document.getElementById('categoria').value;
    const presentacion = document.getElementById('presentacion').value;
    const concentracion = document.getElementById('concentracion').value;
    const stockActual = parseInt(document.getElementById('stock-actual').value);
    const stockMinimo = parseInt(document.getElementById('stock-minimo').value);
    const fechaVencimiento = document.getElementById('fecha-vencimiento').value;
    const lote = document.getElementById('lote').value;
    const proveedor = document.getElementById('proveedor').value;
    const estado = document.getElementById('estado').value;
    
    // Validar campos requeridos
    if (!nombre || !categoria || !presentacion || !concentracion || isNaN(stockActual) || isNaN(stockMinimo) || !fechaVencimiento) {
        mostrarNotificacion('Por favor, complete todos los campos requeridos', 'error');
        return;
    }
    
    // Verificar si es edición o nuevo
    const medicamentoId = document.getElementById('modal-titulo').textContent === 'Editar Medicamento' 
        ? parseInt(document.querySelector('.editing')?.dataset.id) 
        : null;
    
    if (medicamentoId) {
        // Editar medicamento existente
        const index = medicamentos.findIndex(m => m.id === medicamentoId);
        if (index !== -1) {
            medicamentos[index] = {
                ...medicamentos[index],
                nombre,
                categoria,
                presentacion,
                concentracion,
                stockActual,
                stockMinimo,
                fechaVencimiento,
                lote,
                proveedor,
                estado
            };
        }
    } else {
        // Crear nuevo medicamento
        const nuevoMedicamento = {
            id: generarNuevoId(),
            nombre,
            categoria,
            presentacion,
            concentracion,
            stockActual,
            stockMinimo,
            fechaVencimiento,
            lote,
            proveedor,
            estado
        };
        
        medicamentos.push(nuevoMedicamento);
    }
    
    // Actualizar la interfaz
    actualizarEstadisticas();
    cargarMedicamentos();
    
    // Cerrar modal y mostrar mensaje
    cerrarModal();
    mostrarNotificacion('Medicamento guardado exitosamente', 'success');
}

function generarNuevoId() {
    return medicamentos.length > 0 ? Math.max(...medicamentos.map(m => m.id)) + 1 : 1;
}

function editarMedicamento(id) {
    const medicamento = medicamentos.find(m => m.id === id);
    if (medicamento) {
        abrirModal(medicamento);
    }
}

function ajustarStock(id) {
    const medicamento = medicamentos.find(m => m.id === id);
    if (medicamento) {
        const nuevoStock = prompt(`Ajustar stock para ${medicamento.nombre}\nStock actual: ${medicamento.stockActual}\nIngrese el nuevo valor:`, medicamento.stockActual);
        
        if (nuevoStock !== null && !isNaN(nuevoStock) && nuevoStock >= 0) {
            medicamento.stockActual = parseInt(nuevoStock);
            actualizarEstadisticas();
            cargarMedicamentos();
            mostrarNotificacion('Stock actualizado correctamente', 'success');
        }
    }
}

function verDetalles(id) {
    const medicamento = medicamentos.find(m => m.id === id);
    if (medicamento) {
        const categoriaText = {
            'antibiotico': 'Antibiótico',
            'analgesico': 'Analgésico',
            'cardiovascular': 'Cardiovascular',
            'diabetes': 'Diabetes',
            'respiratorio': 'Respiratorio',
            'gastrointestinal': 'Gastrointestinal',
            'neurologico': 'Neurológico'
        }[medicamento.categoria] || medicamento.categoria;

        const presentacionText = {
            'tabletas': 'Tabletas',
            'capsulas': 'Cápsulas',
            'jarabe': 'Jarabe',
            'inyectable': 'Inyectable',
            'crema': 'Crema',
            'unguento': 'Ungüento'
        }[medicamento.presentacion] || medicamento.presentacion;

        const detalles = `
Detalles del medicamento:

Nombre: ${medicamento.nombre}
Categoría: ${categoriaText}
Presentación: ${presentacionText}
Concentración: ${medicamento.concentracion}
Stock Actual: ${medicamento.stockActual}
Stock Mínimo: ${medicamento.stockMinimo}
Fecha de Vencimiento: ${formatearFecha(medicamento.fechaVencimiento)}
Lote: ${medicamento.lote}
Proveedor: ${medicamento.proveedor}
Estado: ${medicamento.estado === 'activo' ? 'Activo' : 'Inactivo'}
        `;
        
        alert(detalles);
    }
}

function filtrarMedicamentos() {
    const categoriaFiltro = document.getElementById('filter-categoria').value;
    const stockFiltro = document.getElementById('filter-stock').value;
    const estadoFiltro = document.getElementById('filter-estado').value;
    
    let medicamentosFiltrados = [...medicamentos];
    
    // Aplicar filtros
    if (categoriaFiltro !== 'todos') {
        medicamentosFiltrados = medicamentosFiltrados.filter(m => m.categoria === categoriaFiltro);
    }
    
    if (estadoFiltro !== 'todos') {
        medicamentosFiltrados = medicamentosFiltrados.filter(m => m.estado === estadoFiltro);
    }
    
    if (stockFiltro !== 'todos') {
        medicamentosFiltrados = medicamentosFiltrados.filter(m => {
            if (stockFiltro === 'bajo') {
                return m.stockActual <= m.stockMinimo;
            } else if (stockFiltro === 'normal') {
                return m.stockActual > m.stockMinimo && m.stockActual <= (m.stockMinimo * 2);
            } else if (stockFiltro === 'optimo') {
                return m.stockActual > (m.stockMinimo * 2);
            }
            return true;
        });
    }
    
    // Actualizar tabla
    const tbody = document.getElementById('tbody-medicamentos');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (medicamentosFiltrados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 20px; color: #666;">No se encontraron medicamentos</td></tr>';
        return;
    }
    
    medicamentosFiltrados.forEach(medicamento => {
        const fila = document.createElement('tr');
        
        let estadoStock = 'optimo';
        let estadoText = 'Óptimo';
        
        if (medicamento.stockActual === 0) {
            estadoStock = 'critico';
            estadoText = 'Agotado';
        } else if (medicamento.stockActual < (medicamento.stockMinimo * 0.5)) {
            estadoStock = 'critico';
            estadoText = 'Crítico';
        } else if (medicamento.stockActual <= medicamento.stockMinimo) {
            estadoStock = 'bajo';
            estadoText = 'Bajo';
        }
        
        const hoy = new Date();
        const vencimiento = new Date(medicamento.fechaVencimiento);
        if (vencimiento < hoy) {
            estadoStock = 'vencido';
            estadoText = 'Vencido';
        }

        const categoriaText = {
            'antibiotico': 'Antibiótico',
            'analgesico': 'Analgésico',
            'cardiovascular': 'Cardiovascular',
            'diabetes': 'Diabetes',
            'respiratorio': 'Respiratorio',
            'gastrointestinal': 'Gastrointestinal',
            'neurologico': 'Neurológico'
        }[medicamento.categoria] || medicamento.categoria;

        fila.innerHTML = `
            <td>${medicamento.id}</td>
            <td>
                <div class="medicamento-info">
                    <div class="medicamento-avatar">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div>
                        <strong>${medicamento.nombre}</strong>
                        <span>${medicamento.concentracion} - ${medicamento.presentacion}</span>
                    </div>
                </div>
            </td>
            <td>${categoriaText}</td>
            <td>${medicamento.stockActual}</td>
            <td>${medicamento.stockMinimo}</td>
            <td><span class="status-badge ${estadoStock}">${estadoText}</span></td>
            <td>${formatearFecha(medicamento.fechaVencimiento)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarMedicamento(${medicamento.id})" title="Editar medicamento" aria-label="Editar ${medicamento.nombre}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="ajustarStock(${medicamento.id})" title="Ajustar Stock" aria-label="Ajustar stock de ${medicamento.nombre}">
                        <i class="fas fa-boxes"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${medicamento.id})" title="Ver Detalles" aria-label="Ver detalles de ${medicamento.nombre}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function buscarMedicamentos() {
    const termino = document.getElementById('search-input').value.toLowerCase();
    
    if (!termino) {
        filtrarMedicamentos();
        return;
    }
    
    const resultados = medicamentos.filter(medicamento => 
        medicamento.nombre.toLowerCase().includes(termino) ||
        medicamento.categoria.toLowerCase().includes(termino) ||
        medicamento.concentracion.toLowerCase().includes(termino) ||
        medicamento.lote.toLowerCase().includes(termino) ||
        medicamento.proveedor.toLowerCase().includes(termino)
    );
    
    // Actualizar tabla con resultados
    const tbody = document.getElementById('tbody-medicamentos');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (resultados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 20px; color: #666;">No se encontraron resultados</td></tr>';
        return;
    }
    
    resultados.forEach(medicamento => {
        const fila = document.createElement('tr');
        
        let estadoStock = 'optimo';
        let estadoText = 'Óptimo';
        
        if (medicamento.stockActual === 0) {
            estadoStock = 'critico';
            estadoText = 'Agotado';
        } else if (medicamento.stockActual < (medicamento.stockMinimo * 0.5)) {
            estadoStock = 'critico';
            estadoText = 'Crítico';
        } else if (medicamento.stockActual <= medicamento.stockMinimo) {
            estadoStock = 'bajo';
            estadoText = 'Bajo';
        }
        
        const hoy = new Date();
        const vencimiento = new Date(medicamento.fechaVencimiento);
        if (vencimiento < hoy) {
            estadoStock = 'vencido';
            estadoText = 'Vencido';
        }

        const categoriaText = {
            'antibiotico': 'Antibiótico',
            'analgesico': 'Analgésico',
            'cardiovascular': 'Cardiovascular',
            'diabetes': 'Diabetes',
            'respiratorio': 'Respiratorio',
            'gastrointestinal': 'Gastrointestinal',
            'neurologico': 'Neurológico'
        }[medicamento.categoria] || medicamento.categoria;

        fila.innerHTML = `
            <td>${medicamento.id}</td>
            <td>
                <div class="medicamento-info">
                    <div class="medicamento-avatar">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div>
                        <strong>${medicamento.nombre}</strong>
                        <span>${medicamento.concentracion} - ${medicamento.presentacion}</span>
                    </div>
                </div>
            </td>
            <td>${categoriaText}</td>
            <td>${medicamento.stockActual}</td>
            <td>${medicamento.stockMinimo}</td>
            <td><span class="status-badge ${estadoStock}">${estadoText}</span></td>
            <td>${formatearFecha(medicamento.fechaVencimiento)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" onclick="editarMedicamento(${medicamento.id})" title="Editar medicamento" aria-label="Editar ${medicamento.nombre}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action" onclick="ajustarStock(${medicamento.id})" title="Ajustar Stock" aria-label="Ajustar stock de ${medicamento.nombre}">
                        <i class="fas fa-boxes"></i>
                    </button>
                    <button class="btn-view" onclick="verDetalles(${medicamento.id})" title="Ver Detalles" aria-label="Ver detalles de ${medicamento.nombre}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

function realizarInventario() {
    console.log('Iniciando proceso de inventario...');
    alert('Funcionalidad de inventario:\nSe abrirá una interfaz para realizar el conteo físico de medicamentos y ajustar el stock en el sistema.');
}

function nuevoPedido() {
    console.log('Creando nuevo pedido...');
    alert('Funcionalidad de pedidos:\nSe abrirá un formulario para solicitar nuevos medicamentos a los proveedores.');
}

function exportMedicamentos() {
    console.log('Exportando lista de medicamentos...');
    alert('Generando reporte de medicamentos en formato PDF...\nEl reporte incluirá el inventario completo con niveles de stock y fechas de vencimiento.');
}

function refreshMedicamentos() {
    console.log('Actualizando lista de medicamentos...');
    // En una implementación real, aquí se haría una petición al servidor
    mostrarNotificacion('Lista de medicamentos actualizada.', 'info');
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
console.log('Script medicamentos inicializado');