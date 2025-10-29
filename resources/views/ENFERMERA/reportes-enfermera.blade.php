<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Hospital Naval</title>
    <link rel="stylesheet" href="style-reportes.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="hospital-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h2>Hospital Naval</h2>
                <p>Módulo Enfermera</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard-enfermera.html" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="pacientes-enfermera.html" class="nav-item">
                    <i class="fas fa-user-injured"></i>
                    <span>Pacientes</span>
                </a>
                <a href="signos-vitales.html" class="nav-item">
                    <i class="fas fa-heartbeat"></i>
                    <span>Signos Vitales</span>
                </a>
                <a href="tratamientos.html" class="nav-item">
                    <i class="fas fa-syringe"></i>
                    <span>Tratamientos</span>
                </a>
                <a href="medicamentos.html" class="nav-item">
                    <i class="fas fa-pills"></i>
                    <span>Medicamentos</span>
                </a>
                <a href="citas-enfermera.html" class="nav-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Citas del Día</span>
                </a>
                <a href="reportes-enfermera.html" class="nav-item active">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                    <div class="user-details">
                        <strong>Laura Martínez</strong>
                        <span>Enfermera</span>
                    </div>
                </div>
                <a href="index.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
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
                <!-- Filtros de Reportes -->
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
                        <select id="filter-periodo" aria-label="Filtrar por período">
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
                    </div>
                </div>

                <!-- Estadísticas Principales -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-pacientes">0</h3>
                            <p>Pacientes Atendidos</p>
                            <span class="stat-trend positive">+12%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-tratamientos">0</h3>
                            <p>Tratamientos Aplicados</p>
                            <span class="stat-trend positive">+8%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-medicamentos">0</h3>
                            <p>Medicamentos Usados</p>
                            <span class="stat-trend negative">-5%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-citas">0</h3>
                            <p>Citas Realizadas</p>
                            <span class="stat-trend positive">+15%</span>
                        </div>
                    </div>
                </div>

                <!-- Gráficos y Visualizaciones -->
                <div class="health-info">
                    <div class="info-card large">
                        <h3><i class="fas fa-chart-line"></i> Tendencia de Pacientes por Mes</h3>
                        <div class="chart-container">
                            <canvas id="pacientes-chart"></canvas>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3><i class="fas fa-chart-pie"></i> Distribución por Especialidad</h3>
                        <div class="chart-container">
                            <canvas id="especialidades-chart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Reportes Predefinidos -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-file-medical"></i> Reportes Predefinidos
                        <div class="section-actions">
                            <button class="section-btn" id="actualizar-reportes">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                            <button class="section-btn" id="exportar-todos">
                                <i class="fas fa-download"></i> Exportar Todos
                            </button>
                        </div>
                    </h2>
                    <div class="reports-grid">
                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-user-injured"></i>
                            </div>
                            <div class="report-content">
                                <h4>Reporte de Pacientes</h4>
                                <p>Listado completo de pacientes activos con su información médica</p>
                                <div class="report-meta">
                                    <span><i class="fas fa-calendar"></i> Actualizado: Hoy</span>
                                    <span><i class="fas fa-file"></i> PDF, Excel</span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-view" onclick="generarReporte('pacientes')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="descargarReporte('pacientes')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-syringe"></i>
                            </div>
                            <div class="report-content">
                                <h4>Reporte de Tratamientos</h4>
                                <p>Análisis de tratamientos aplicados y su efectividad</p>
                                <div class="report-meta">
                                    <span><i class="fas fa-calendar"></i> Actualizado: Ayer</span>
                                    <span><i class="fas fa-file"></i> PDF, Gráfico</span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-view" onclick="generarReporte('tratamientos')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="descargarReporte('tratamientos')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div class="report-content">
                                <h4>Reporte de Inventario</h4>
                                <p>Estado del inventario de medicamentos y suministros</p>
                                <div class="report-meta">
                                    <span><i class="fas fa-calendar"></i> Actualizado: Hoy</span>
                                    <span><i class="fas fa-file"></i> PDF, Excel</span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-view" onclick="generarReporte('inventario')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="descargarReporte('inventario')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="report-content">
                                <h4>Reporte de Citas</h4>
                                <p>Estadísticas de citas médicas y ocupación de consultorios</p>
                                <div class="report-meta">
                                    <span><i class="fas fa-calendar"></i> Actualizado: Esta semana</span>
                                    <span><i class="fas fa-file"></i> PDF, Excel</span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-view" onclick="generarReporte('citas')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="descargarReporte('citas')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="report-content">
                                <h4>Reporte de Signos Vitales</h4>
                                <p>Promedios y tendencias de signos vitales de pacientes</p>
                                <div class="report-meta">
                                    <span><i class="fas fa-calendar"></i> Actualizado: Hoy</span>
                                    <span><i class="fas fa-file"></i> PDF, Gráfico</span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-view" onclick="generarReporte('signos')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="descargarReporte('signos')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="report-content">
                                <h4>Reporte General</h4>
                                <p>Resumen completo de todas las actividades del hospital</p>
                                <div class="report-meta">
                                    <span><i class="fas fa-calendar"></i> Actualizado: Este mes</span>
                                    <span><i class="fas fa-file"></i> PDF, Excel</span>
                                </div>
                            </div>
                            <div class="report-actions">
                                <button class="btn-view" onclick="generarReporte('general')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="descargarReporte('general')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reportes Personalizados -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-cogs"></i> Generar Reporte Personalizado
                        <div class="section-actions">
                            <button class="section-btn" id="guardar-plantilla">
                                <i class="fas fa-save"></i> Guardar Plantilla
                            </button>
                        </div>
                    </h2>
                    <div class="custom-report-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="reporte-nombre">Nombre del Reporte</label>
                                <input type="text" id="reporte-nombre" placeholder="Ingrese nombre del reporte">
                            </div>
                            <div class="form-group">
                                <label for="reporte-tipo">Tipo de Reporte</label>
                                <select id="reporte-tipo">
                                    <option value="resumen">Resumen</option>
                                    <option value="detallado">Detallado</option>
                                    <option value="comparativo">Comparativo</option>
                                    <option value="tendencia">Tendencia</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Seleccionar Datos a Incluir</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="datos" value="pacientes" checked>
                                    <span class="checkmark"></span>
                                    Datos de Pacientes
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="datos" value="tratamientos" checked>
                                    <span class="checkmark"></span>
                                    Tratamientos
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="datos" value="medicamentos">
                                    <span class="checkmark"></span>
                                    Medicamentos
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="datos" value="citas">
                                    <span class="checkmark"></span>
                                    Citas
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="datos" value="signos">
                                    <span class="checkmark"></span>
                                    Signos Vitales
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="datos" value="inventario">
                                    <span class="checkmark"></span>
                                    Inventario
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="formato-salida">Formato de Salida</label>
                                <select id="formato-salida">
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="html">HTML</option>
                                    <option value="grafico">Gráfico Interactivo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ordenamiento">Ordenamiento</label>
                                <select id="ordenamiento">
                                    <option value="fecha">Por Fecha</option>
                                    <option value="nombre">Por Nombre</option>
                                    <option value="prioridad">Por Prioridad</option>
                                    <option value="especialidad">Por Especialidad</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="limpiar-formulario">
                                <i class="fas fa-broom"></i> Limpiar
                            </button>
                            <button type="button" class="btn-primary" id="generar-personalizado">
                                <i class="fas fa-magic"></i> Generar Reporte
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Historial de Reportes -->
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
                                    <th>Fecha Generación</th>
                                    <th>Tamaño</th>
                                    <th>Formato</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="historial-body">
                                <!-- El historial se cargará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Vista Previa -->
    <div class="modal-overlay" id="modal-preview">
        <div class="modal large">
            <div class="modal-header">
                <h3 id="preview-titulo">Vista Previa del Reporte</h3>
                <button class="close-modal" aria-label="Cerrar modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="report-preview" id="report-preview">
                    <!-- La vista previa se cargará aquí -->
                </div>
                <div class="preview-actions">
                    <button class="btn-cancel" id="cerrar-preview">Cerrar</button>
                    <button class="btn-primary" id="descargar-preview">
                        <i class="fas fa-download"></i> Descargar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script-reportes.js"></script>
</body>
</html>