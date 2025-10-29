@extends('plantillas.dashboard_enfermera')
@section('title', 'Dashboard Enfermera - Hospital Naval')
@section('styles')
    @vite(['resources/css/ENFERMERA/paginas/style-enfermera.css'])
@endsection
@section('content')
            <header class="content-header">
                <h1>¡Hola Laura!</h1>
                <!--<div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar paciente o procedimiento..." aria-label="Buscar paciente o procedimiento">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                </div>-->
            </header>

            <div class="content">
                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    <!--<div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <div class="stat-info">
                            <h3>8</h3>
                            <p>Pacientes Activos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Signos Pendientes</p>
                        </div>
                    </div>-->
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div class="stat-info">
                            <h3>6</h3>
                            <p>Tratamientos Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-info">
                            <h3>15</h3>
                            <p>Citas del Día</p>
                        </div>
                    </div>
                </div>

                <!-- Alertas Urgentes -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-exclamation-triangle"></i> Alertas Urgentes
                        <div class="section-actions">
                            <button class="section-btn" id="filter-alerts">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button class="section-btn" id="mark-all-read">
                                <i class="fas fa-check-double"></i> Marcar Todo
                            </button>
                        </div>
                    </h2>
                    <div class="alerts-grid">
                        <div class="alert-card critical">
                            <div class="alert-header">
                                <h3>Presión Arterial Crítica</h3>
                                <span class="alert-badge">Urgente</span>
                            </div>
                            <div class="alert-details">
                                <p><i class="fas fa-user-injured"></i> <strong>Paciente:</strong> Carlos Ruiz - Hab. 304</p>
                                <p><i class="fas fa-heartbeat"></i> <strong>Lectura:</strong> 180/110 mmHg</p>
                                <p><i class="fas fa-clock"></i> <strong>Hora:</strong> 10:30 AM</p>
                            </div>
                            <div class="alert-actions">
                                <button class="btn-view" aria-label="Atender alerta de Carlos Ruiz">Atender</button>
                                <button class="btn-cancel" aria-label="Posponer alerta de Carlos Ruiz">Posponer</button>
                            </div>
                        </div>

                        <div class="alert-card warning">
                            <div class="alert-header">
                                <h3>Fiebre Elevada</h3>
                                <span class="alert-badge">Alta</span>
                            </div>
                            <div class="alert-details">
                                <p><i class="fas fa-user-injured"></i> <strong>Paciente:</strong> Ana López - Hab. 205</p>
                                <p><i class="fas fa-temperature-high"></i> <strong>Lectura:</strong> 39.2°C</p>
                                <p><i class="fas fa-clock"></i> <strong>Hora:</strong> 11:15 AM</p>
                            </div>
                            <div class="alert-actions">
                                <button class="btn-view" aria-label="Atender alerta de Ana López">Atender</button>
                                <button class="btn-cancel" aria-label="Posponer alerta de Ana López">Posponer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pacientes Activos -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-procedures"></i> Pacientes Activos
                        <div class="section-actions">
                            <button class="section-btn" id="filter-patients">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button class="section-btn" id="export-patients">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                        </div>
                    </h2>
                    <div class="patients-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Habitación</th>
                                    <th>Condición</th>
                                    <th>Signos Vitales</th>
                                    <th>Última Medición</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Carlos Ruiz</strong>
                                                <span>65 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>304</td>
                                    <td><span class="status-badge critical">Crítico</span></td>
                                    <td>
                                        <div class="vitals-info">
                                            <span class="vital-item high">TA: 180/110</span>
                                            <span class="vital-item">FC: 92</span>
                                            <span class="vital-item">Temp: 37.2°C</span>
                                        </div>
                                    </td>
                                    <td>10:30 AM</td>
                                    <td>
                                        <button class="btn-view" aria-label="Registrar signos de Carlos Ruiz">Signos</button>
                                        <button class="btn-cancel" aria-label="Medicar a Carlos Ruiz">Medicar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Ana López</strong>
                                                <span>42 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>205</td>
                                    <td><span class="status-badge warning">Grave</span></td>
                                    <td>
                                        <div class="vitals-info">
                                            <span class="vital-item">TA: 130/85</span>
                                            <span class="vital-item">FC: 88</span>
                                            <span class="vital-item high">Temp: 39.2°C</span>
                                        </div>
                                    </td>
                                    <td>11:15 AM</td>
                                    <td>
                                        <button class="btn-view" aria-label="Registrar signos de Ana López">Signos</button>
                                        <button class="btn-cancel" aria-label="Medicar a Ana López">Medicar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Información del Turno -->
 
                    <div class="info-card">
                        <h3><i class="fas fa-tasks"></i> Tareas del Turno</h3>
                        <div class="tasks-list">
                            <div class="task-item urgent">
                                <div class="task-content">
                                    <h4>Administrar insulina - Miguel Torres</h4>
                                    <p><i class="fas fa-map-marker-alt"></i> Habitación 102</p>
                                    <p><i class="fas fa-clock"></i> 12:00 PM - <span class="task-status overdue">Retrasado 30 min</span></p>
                                </div>
                                <button class="btn-view" aria-label="Realizar tarea de insulina">Realizar</button>
                            </div>
                            <div class="task-item">
                                <div class="task-content">
                                    <h4>Control signos vitales - Ana López</h4>
                                    <p><i class="fas fa-map-marker-alt"></i> Habitación 205</p>
                                    <p><i class="fas fa-clock"></i> 01:15 PM - <span class="task-status pending">Pendiente</span></p>
                                </div>
                                <button class="btn-view" aria-label="Registrar signos de Ana López">Registrar</button>
                            </div>
                            <div class="task-item completed">
                                <div class="task-content">
                                    <h4>Cambio de vendaje - Carlos Ruiz</h4>
                                    <p><i class="fas fa-map-marker-alt"></i> Habitación 304</p>
                                    <p><i class="fas fa-clock"></i> 10:45 AM - <span class="task-status completed">Completado</span></p>
                                </div>
                                <button class="btn-view" aria-label="Ver tarea completada">Ver</button>
                            </div>
                        </div>
                    </div>
                    
                    <!--<div class="info-card">
                        <h3><i class="fas fa-calendar-check"></i> Próximas Citas Médicas</h3>
                        <div class="appointments-list">
                            <div class="appointment-item">
                                <div class="appointment-time">
                                    <strong>02:00 PM</strong>
                                    <span>Consulta</span>
                                </div>
                                <div class="appointment-details">
                                    <h4>Dra. Elena Morales</h4>
                                    <p><i class="fas fa-user-injured"></i> Carlos Ruiz - Cardiología</p>
                                    <p><i class="fas fa-map-marker-alt"></i> Consultorio 405</p>
                                </div>
                                <button class="btn-view" aria-label="Preparar cita de Carlos Ruiz">Preparar</button>
                            </div>
                            <div class="appointment-item">
                                <div class="appointment-time">
                                    <strong>03:30 PM</strong>
                                    <span>Control</span>
                                </div>
                                <div class="appointment-details">
                                    <h4>Dr. Roberto Silva</h4>
                                    <p><i class="fas fa-user-injured"></i> Ana López - Medicina General</p>
                                    <p><i class="fas fa-map-marker-alt"></i> Consultorio 208</p>
                                </div>
                                <button class="btn-view" aria-label="Preparar cita de Ana López">Preparar</button>
                            </div>
                        </div>
                    </div>-->


                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="signos-vitales.html" class="action-card">
                            <i class="fas fa-heartbeat"></i>
                            <span>Registrar Signos</span>
                        </a>
                        <a href="medicamentos.html" class="action-card">
                            <i class="fas fa-pills"></i>
                            <span>Administrar Medicamentos</span>
                        </a>
                        <!--<a href="pacientes-enfermera.html" class="action-card">
                            <i class="fas fa-user-plus"></i>
                            <span>Nuevo Paciente</span>
                        </a>
                        <a href="reportes-enfermera.html" class="action-card">
                            <i class="fas fa-file-medical"></i>
                            <span>Generar Reporte</span>
                        </a>-->
                    </div>
                </div>
            </div>

    <!-- Modal de notificaciones -->
    <div class="modal-overlay" id="notifications-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Tus Notificaciones</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Alerta: Presión arterial crítica - Carlos Ruiz</li>
                    <li>Recordatorio: Administrar insulina - Miguel Torres</li>
                    <li>Nuevo paciente asignado: Habitación 107</li>
                    <li>Signos vitales pendientes: 5 pacientes</li>
                    <li>Reporte de turno listo para revisión</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@vite('resources/js/ENFERMERA/script-enfermera.js')
@endsection