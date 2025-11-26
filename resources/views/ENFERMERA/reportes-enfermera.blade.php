@extends('plantillas.dashboard_enfermera')
@section('title', 'Reportes y Estadísticas - Hospital Naval')
@section('styles')
    @vite(['resources/css/ENFERMERA/paginas/style-reportes.css'])
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <header class="content-header">
        <h1>Reportes y Estadísticas</h1>
        <div class="header-actions">
            <div class="date-range">
                <input type="date" id="fecha-inicio" aria-label="Fecha inicio">
                <span>a</span>
                <input type="date" id="fecha-fin" aria-label="Fecha fin">
            </div>
            <div class="search-box">
                <input type="text" placeholder="Buscar reportes..." id="search-input" aria-label="Buscar reportes">
                <i class="fas fa-search"></i>
            </div>
            <div class="notifications" role="button" aria-label="Ver notificaciones">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">2</span>
            </div>
            <button class="btn-primary" id="generar-reporte-btn">
                <i class="fas fa-file-pdf"></i>
                Generar Reporte
            </button>
        </div>
    </header>

    <div class="content">
        <div class="filters-section">
            <div class="filter-group">
                <label>Filtrar por:</label>
                <select id="filter-tipo" aria-label="Filtrar por tipo de reporte">
                    <option value="todos">Todos los reportes</option>
                    <option value="pacientes">Pacientes</option>
                    <option value="tratamientos">Tratamientos</option>
                    <option value="medicamentos">Medicamentos</option>
                    <option value="citas">Citas</option>
                    <option value="inventario">Inventario</option>
                </select>
                <select id="filter-periodo" aria-label="Filtrar por periodo">
                    <option value="hoy">Hoy</option>
                    <option value="semana">Esta semana</option>
                    <option value="mes">Este mes</option>
                    <option value="trimestre">Este trimestre</option>
                    <option value="personalizado">Personalizado</option>
                </select>
                <select id="filter-formato" aria-label="Filtrar por formato">
                    <option value="todos">Todos los formatos</option>
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                    <option value="grafico">Gráfico</option>
                </select>
                <button class="section-btn" id="aplicar-filtros">
                    <i class="fas fa-filter"></i> Aplicar
                </button>
                <button class="section-btn" id="actualizar-reportes">
                    <i class="fas fa-sync"></i> Actualizar
                </button>
            </div>
        </div>

        <div class="health-info">
            <div class="info-card">
                <h3><i class="fas fa-chart-line"></i> Resumen General</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <strong>Pacientes Atendidos</strong>
                        <span id="total-pacientes">0</span>
                        <small class="positive">+12%</small>
                    </div>
                    <div class="detail-item">
                        <strong>Tratamientos Aplicados</strong>
                        <span id="total-tratamientos">0</span>
                        <small class="positive">+8%</small>
                    </div>
                    <div class="detail-item">
                        <strong>Medicamentos Entregados</strong>
                        <span id="total-medicamentos">0</span>
                        <small class="negative">-3%</small>
                    </div>
                    <div class="detail-item">
                        <strong>Citas Registradas</strong>
                        <span id="total-citas">0</span>
                        <small class="positive">+5%</small>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-file-export"></i> Exportaciones Rápidas</h3>
                <div class="quick-actions-grid">
                    <button class="quick-action" id="exportar-todos">
                        <i class="fas fa-download"></i>
                        <div>
                            <strong>Exportar Todos</strong>
                            <small>PDF / Excel</small>
                        </div>
                    </button>
                    <button class="quick-action" id="guardar-plantilla">
                        <i class="fas fa-save"></i>
                        <div>
                            <strong>Guardar Plantilla</strong>
                            <small>Configuración actual</small>
                        </div>
                    </button>
                    <button class="quick-action" id="limpiar-formulario">
                        <i class="fas fa-undo"></i>
                        <div>
                            <strong>Limpiar</strong>
                            <small>Reiniciar filtros</small>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="recent-section">
            <h2>
                <i class="fas fa-list"></i> Generar Reporte Personalizado
                <div class="section-actions">
                    <button class="section-btn" id="generar-personalizado">
                        <i class="fas fa-file-alt"></i> Generar
                    </button>
                </div>
            </h2>
            <div class="report-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre del Reporte *</label>
                        <input type="text" id="reporte-nombre" placeholder="Ej: Reporte Semanal">
                    </div>
                    <div class="form-group">
                        <label>Tipo de Reporte</label>
                        <select id="reporte-tipo">
                            <option value="resumen">Resumen General</option>
                            <option value="pacientes">Pacientes</option>
                            <option value="tratamientos">Tratamientos</option>
                            <option value="medicamentos">Medicamentos</option>
                            <option value="citas">Citas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Formato de Salida</label>
                        <select id="formato-salida">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="grafico">Gráfico</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Rango de Fechas</label>
                        <div class="date-range">
                            <input type="date" aria-label="Inicio">
                            <span>a</span>
                            <input type="date" aria-label="Fin">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea id="observaciones" rows="2" placeholder="Notas adicionales para el reporte"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-section">
            <h2>
                <i class="fas fa-history"></i> Historial de Reportes
                <div class="section-actions">
                    <button class="section-btn" id="limpiar-historial">
                        <i class="fas fa-trash"></i> Limpiar
                    </button>
                </div>
            </h2>
            <div class="patients-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Formato</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="historial-body">
                        <tr>
                            <td colspan="5" style="text-align: center;">Sin reportes generados</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/ENFERMERA/script-reportes.js'])
@endsection
