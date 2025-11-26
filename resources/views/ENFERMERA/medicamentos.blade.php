@extends('plantillas.dashboard_enfermera')
@section('title', 'Gestión de Medicamentos - Clínica "Ultima Asignatura"')
@section('styles')
    @vite(['resources/css/ENFERMERA/paginas/style-medicamentos.css'])
@endsection
@section('content')
            <header class="content-header">
                <h1>Gestión de Medicamentos</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar medicamentos..." id="search-input" aria-label="Buscar medicamentos">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                    <button class="btn-primary" id="nuevo-medicamento-btn">
                        <i class="fas fa-plus"></i>
                        Nuevo Medicamento
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Filtros -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filtrar por:</label>
                        <select id="filter-categoria" aria-label="Filtrar por categoría">
                            <option value="todos">Todas las categorías</option>
                            <option value="antibiotico">Antibióticos</option>
                            <option value="analgesico">Analgésicos</option>
                            <option value="cardiovascular">Cardiovasculares</option>
                            <option value="diabetes">Diabetes</option>
                            <option value="respiratorio">Respiratorios</option>
                        </select>
                        <select id="filter-stock" aria-label="Filtrar por stock">
                            <option value="todos">Todo el stock</option>
                            <option value="bajo">Stock Bajo</option>
                            <option value="normal">Stock Normal</option>
                            <option value="optimo">Stock Óptimo</option>
                        </select>
                        <select id="filter-estado" aria-label="Filtrar por estado">
                            <option value="todos">Todos los estados</option>
                            <option value="activo">Activos</option>
                            <option value="inactivo">Inactivos</option>
                        </select>
                        <button class="section-btn" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-chart-bar"></i> Resumen de Inventario</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <strong>Total Medicamentos</strong>
                                <span id="total-medicamentos">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Stock Bajo</strong>
                                <span id="stock-bajo">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Por Vencer</strong>
                                <span id="por-vencer">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Activos</strong>
                                <span id="medicamentos-activos">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3><i class="fas fa-exclamation-triangle"></i> Alertas de Stock</h3>
                        <div class="vitals-summary">
                            <div class="vital-item">
                                <div class="vital-icon high">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="vital-info">
                                    <strong id="alertas-stock">0</strong>
                                    <span>Medicamentos con stock crítico</span>
                                </div>
                            </div>
                            <div class="vital-item">
                                <div class="vital-icon warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="vital-info">
                                    <strong id="proximos-vencer">0</strong>
                                    <span>Próximos a vencer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Medicamentos -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Inventario de Medicamentos
                        <div class="section-actions">
                            <button class="section-btn" id="export-medicamentos">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                            <button class="section-btn" id="refresh-list">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    <div class="patients-table">
                        <table id="tabla-medicamentos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Medicamento</th>
                                    <th>Categoría</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                    <th>Estado Stock</th>
                                    <th>Vencimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-medicamentos">
                                <!-- Los medicamentos se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="tratamientos.html" class="action-card">
                            <i class="fas fa-syringe"></i>
                            <span>Gestión de Tratamientos</span>
                        </a>
                        <a href="#" class="action-card" id="btn-inventario">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Realizar Inventario</span>
                        </a>
                        <a href="#" class="action-card" id="btn-pedido">
                            <i class="fas fa-truck"></i>
                            <span>Nuevo Pedido</span>
                        </a>
                        <a href="reportes-enfermera.html" class="action-card">
                            <i class="fas fa-file-medical"></i>
                            <span>Reporte de Stock</span>
                        </a>
                    </div>
                </div>
            </div>

    <!-- Modal para Nuevo/Editar Medicamento -->
    <div class="modal-overlay" id="modal-medicamento">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modal-titulo">Nuevo Medicamento</h3>
                <button class="close-modal" aria-label="Cerrar modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-medicamento">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre del Medicamento *</label>
                            <input type="text" id="nombre" placeholder="Ej: Amoxicilina" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoría *</label>
                            <select id="categoria" required>
                                <option value="">Seleccionar categoría</option>
                                <option value="antibiotico">Antibiótico</option>
                                <option value="analgesico">Analgésico</option>
                                <option value="cardiovascular">Cardiovascular</option>
                                <option value="diabetes">Diabetes</option>
                                <option value="respiratorio">Respiratorio</option>
                                <option value="gastrointestinal">Gastrointestinal</option>
                                <option value="neurologico">Neurológico</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="presentacion">Presentación *</label>
                            <select id="presentacion" required>
                                <option value="">Seleccionar presentación</option>
                                <option value="tabletas">Tabletas</option>
                                <option value="capsulas">Cápsulas</option>
                                <option value="jarabe">Jarabe</option>
                                <option value="inyectable">Inyectable</option>
                                <option value="crema">Crema</option>
                                <option value="unguento">Ungüento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="concentracion">Concentración *</label>
                            <input type="text" id="concentracion" placeholder="Ej: 500mg" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="stock-actual">Stock Actual *</label>
                            <input type="number" id="stock-actual" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="stock-minimo">Stock Mínimo *</label>
                            <input type="number" id="stock-minimo" min="0" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha-vencimiento">Fecha de Vencimiento *</label>
                            <input type="date" id="fecha-vencimiento" required>
                        </div>
                        <div class="form-group">
                            <label for="lote">Número de Lote</label>
                            <input type="text" id="lote" placeholder="Número de lote">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="proveedor">Proveedor</label>
                        <input type="text" id="proveedor" placeholder="Nombre del proveedor">
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="cancel-form">Cancelar</button>
                        <button type="submit" class="btn-primary">Guardar Medicamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@vite(['resources/js/ENFERMERA/script-medicamentos.js'])
@endsection 