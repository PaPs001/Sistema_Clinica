<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas del Día - Hospital Naval</title>
    <link rel="stylesheet" href="style-citas.css">
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
                <a href="citas-enfermera.html" class="nav-item active">
                    <i class="fas fa-calendar-check"></i>
                    <span>Citas del Día</span>
                </a>
                <a href="reportes-enfermera.html" class="nav-item">
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
                <h1>Citas del Día</h1>
                <div class="header-actions">
                    <div class="date-selector">
                        <input type="date" id="fecha-citas" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="search-box">
                        <input type="text" placeholder="Buscar citas..." id="search-input" aria-label="Buscar citas">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                    <button class="btn-primary" id="nueva-cita-btn">
                        <i class="fas fa-plus"></i>
                        Nueva Cita
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Filtros -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filtrar por:</label>
                        <select id="filter-estado" aria-label="Filtrar por estado">
                            <option value="todos">Todos los estados</option>
                            <option value="pendiente">Pendientes</option>
                            <option value="confirmada">Confirmadas</option>
                            <option value="completada">Completadas</option>
                            <option value="cancelada">Canceladas</option>
                        </select>
                        <select id="filter-medico" aria-label="Filtrar por médico">
                            <option value="todos">Todos los médicos</option>
                        </select>
                        <select id="filter-especialidad" aria-label="Filtrar por especialidad">
                            <option value="todos">Todas las especialidades</option>
                            <option value="cardiologia">Cardiología</option>
                            <option value="pediatria">Pediatría</option>
                            <option value="cirugia">Cirugía</option>
                            <option value="medicina-general">Medicina General</option>
                        </select>
                        <button class="section-btn" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-chart-bar"></i> Resumen del Día</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <strong>Total Citas</strong>
                                <span id="total-citas">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Pendientes</strong>
                                <span id="citas-pendientes">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>En Curso</strong>
                                <span id="citas-curso">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Completadas</strong>
                        <span id="citas-completadas">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3><i class="fas fa-clock"></i> Próximas Citas</h3>
                        <div class="vitals-summary">
                            <div class="vital-item">
                                <div class="vital-icon warning">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="vital-info">
                                    <strong id="proximas-citas">0</strong>
                                    <span>En los próximos 30 min</span>
                                </div>
                            </div>
                            <div class="vital-item">
                                <div class="vital-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div class="vital-info">
                                    <strong id="medicos-activos">0</strong>
                                    <span>Médicos disponibles</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Citas -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Citas Programadas
                        <div class="section-actions">
                            <button class="section-btn" id="export-citas">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                            <button class="section-btn" id="refresh-list">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    <div class="patients-table">
                        <table id="tabla-citas">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Especialidad</th>
                                    <th>Consultorio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-citas">
                                <!-- Las citas se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Calendario de Citas -->
                <div class="recent-section">
                    <h2><i class="fas fa-calendar-alt"></i> Vista de Agenda</h2>
                    <div class="calendar-view">
                        <div class="calendar-header">
                            <button class="calendar-nav" id="prev-hour"><i class="fas fa-chevron-left"></i></button>
                            <h3 id="current-time-range">08:00 - 17:00</h3>
                            <button class="calendar-nav" id="next-hour"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="time-slots" id="time-slots">
                            <!-- Las franjas horarias se cargarán aquí dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="pacientes-enfermera.html" class="action-card">
                            <i class="fas fa-user-injured"></i>
                            <span>Gestión de Pacientes</span>
                        </a>
                        <a href="signos-vitales.html" class="action-card">
                            <i class="fas fa-heartbeat"></i>
                            <span>Preparar Consulta</span>
                        </a>
                        <a href="#" class="action-card" id="btn-urgencias">
                            <i class="fas fa-ambulance"></i>
                            <span>Registro Urgencias</span>
                        </a>
                        <a href="reportes-enfermera.html" class="action-card">
                            <i class="fas fa-file-medical"></i>
                            <span>Reporte Diario</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nueva/Editar Cita -->
    <div class="modal-overlay" id="modal-cita">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modal-titulo">Nueva Cita</h3>
                <button class="close-modal" aria-label="Cerrar modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-cita">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="paciente">Paciente *</label>
                            <select id="paciente" required>
                                <option value="">Seleccionar paciente</option>
                                <option value="Carlos Ruiz">Carlos Ruiz</option>
                                <option value="Ana López">Ana López</option>
                                <option value="Miguel Torres">Miguel Torres</option>
                                <option value="Elena Morales">Elena Morales</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="medico">Médico *</label>
                            <select id="medico" required>
                                <option value="">Seleccionar médico</option>
                                <option value="Dr. Carlos Ruiz">Dr. Carlos Ruiz</option>
                                <option value="Dra. Ana Martínez">Dra. Ana Martínez</option>
                                <option value="Dr. Roberto Silva">Dr. Roberto Silva</option>
                                <option value="Dra. Elena Morales">Dra. Elena Morales</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha">Fecha *</label>
                            <input type="date" id="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="hora">Hora *</label>
                            <input type="time" id="hora" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="especialidad">Especialidad *</label>
                            <select id="especialidad" required>
                                <option value="">Seleccionar especialidad</option>
                                <option value="cardiologia">Cardiología</option>
                                <option value="pediatria">Pediatría</option>
                                <option value="cirugia">Cirugía</option>
                                <option value="medicina-general">Medicina General</option>
                                <option value="dermatologia">Dermatología</option>
                                <option value="ginecologia">Ginecología</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="consultorio">Consultorio *</label>
                            <select id="consultorio" required>
                                <option value="">Seleccionar consultorio</option>
                                <option value="Consulta 101">Consulta 101</option>
                                <option value="Consulta 102">Consulta 102</option>
                                <option value="Consulta 201">Consulta 201</option>
                                <option value="Consulta 202">Consulta 202</option>
                                <option value="Consulta 301">Consulta 301</option>
                                <option value="Consulta 302">Consulta 302</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="motivo">Motivo de la Consulta</label>
                        <textarea id="motivo" placeholder="Describa el motivo de la consulta"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="cancel-form">Cancelar</button>
                        <button type="submit" class="btn-primary">Guardar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="script-citas.js"></script>
</body>
</html>