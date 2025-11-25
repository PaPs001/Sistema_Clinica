@extends('plantillas.dashboard_administrador')
@section('title', 'Dashboard Administrador - Clínica "Ultima Asignatura"')
@section('content')
            <header class="content-header">
                <h1>Panel de Administración</h1>
                <!--
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar usuario, reporte o configuración..." aria-label="Buscar en el sistema">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                </div>-->
            </header>

            <div class="content">
                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>42</h3>
                            <p>Usuarios Activos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="stat-info">
                            <h3>15</h3>
                            <p>Médicos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-nurse"></i>
                        </div>
                        <div class="stat-info">
                            <h3>22</h3>
                            <p>Enfermeras</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Recepcionistas</p>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Roles -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-user-shield"></i> Gestión de Roles de Usuario
                        <div class="section-actions">
                            <button class="section-btn" id="filter-roles">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button class="section-btn" id="add-user">
                                <i class="fas fa-user-plus"></i> Agregar Usuario
                            </button>
                        </div>
                    </h2>
                    <div class="users-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                    <th>Último Acceso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                <strong>Dra. Elena Morales</strong>
                                                <span>Cardiología</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Médico</td>
                                    <td>Cardiología</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>Hoy, 08:45 AM</td>
                                    <td>
                                        <button class="btn-view" aria-label="Editar rol de Dra. Elena Morales">Editar</button>
                                        <button class="btn-cancel" aria-label="Desactivar usuario Dra. Elena Morales">Desactivar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user-nurse"></i>
                                            </div>
                                            <div>
                                                <strong>Laura Martínez</strong>
                                                <span>Enfermería</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Enfermera</td>
                                    <td>Urgencias</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>Hoy, 07:30 AM</td>
                                    <td>
                                        <button class="btn-view" aria-label="Editar rol de Laura Martínez">Editar</button>
                                        <button class="btn-cancel" aria-label="Desactivar usuario Laura Martínez">Desactivar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user-clock"></i>
                                            </div>
                                            <div>
                                                <strong>Ana Rodríguez</strong>
                                                <span>Recepción</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Recepcionista</td>
                                    <td>Recepción Principal</td>
                                    <td><span class="status-badge inactive">Inactivo</span></td>
                                    <td>Ayer, 05:20 PM</td>
                                    <td>
                                        <button class="btn-view" aria-label="Editar rol de Ana Rodríguez">Editar</button>
                                        <button class="btn-cancel" aria-label="Activar usuario Ana Rodríguez">Activar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Control de Accesos -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-lock"></i> Control de Accesos por Niveles
                        <div class="section-actions">
                            <button class="section-btn" id="manage-permissions">
                                <i class="fas fa-cog"></i> Gestionar Permisos
                            </button>
                            <button class="section-btn" id="access-log">
                                <i class="fas fa-history"></i> Ver Historial
                            </button>
                        </div>
                    </h2>
                    <div class="access-grid">
                        <div class="access-card">
                            <div class="access-header">
                                <h3>Médicos</h3>
                                <span class="access-badge">Alto</span>
                            </div>
                            <div class="access-details">
                                <p><i class="fas fa-check-circle"></i> <strong>Permisos:</strong> Expedientes completos, Historial médico, Subir documentos</p>
                                <p><i class="fas fa-times-circle"></i> <strong>Restricciones:</strong> Sin acceso a configuración del sistema</p>
                                <p><i class="fas fa-users"></i> <strong>Usuarios:</strong> 15</p>
                            </div>
                            <div class="access-actions">
                                <button class="btn-view" aria-label="Configurar permisos de médicos">Configurar</button>
                                <button class="btn-cancel" aria-label="Ver usuarios médicos">Ver Usuarios</button>
                            </div>
                        </div>

                        <div class="access-card">
                            <div class="access-header">
                                <h3>Enfermeras</h3>
                                <span class="access-badge">Medio</span>
                            </div>
                            <div class="access-details">
                                <p><i class="fas fa-check-circle"></i> <strong>Permisos:</strong> Signos vitales, Tratamientos, Medicamentos</p>
                                <p><i class="fas fa-times-circle"></i> <strong>Restricciones:</strong> Sin acceso a diagnósticos completos</p>
                                <p><i class="fas fa-users"></i> <strong>Usuarios:</strong> 22</p>
                            </div>
                            <div class="access-actions">
                                <button class="btn-view" aria-label="Configurar permisos de enfermeras">Configurar</button>
                                <button class="btn-cancel" aria-label="Ver usuarios enfermeras">Ver Usuarios</button>
                            </div>
                        </div>

                        <div class="access-card">
                            <div class="access-header">
                                <h3>Recepcionistas</h3>
                                <span class="access-badge">Básico</span>
                            </div>
                            <div class="access-details">
                                <p><i class="fas fa-check-circle"></i> <strong>Permisos:</strong> Registrar pacientes, Agendar citas</p>
                                <p><i class="fas fa-times-circle"></i> <strong>Restricciones:</strong> Sin acceso a expedientes médicos</p>
                                <p><i class="fas fa-users"></i> <strong>Usuarios:</strong> 5</p>
                            </div>
                            <div class="access-actions">
                                <button class="btn-view" aria-label="Configurar permisos de recepcionistas">Configurar</button>
                                <button class="btn-cancel" aria-label="Ver usuarios recepcionistas">Ver Usuarios</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema 
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-database"></i> Estado del Sistema</h3>
                        <div class="system-status">
                            <div class="status-item">
                                <h4>Base de Datos</h4>
                                <div class="status-bar">
                                    <div class="status-fill" style="width: 65%"></div>
                                </div>
                                <p>65% de capacidad utilizada</p>
                            </div>
                            <div class="status-item">
                                <h4>Almacenamiento</h4>
                                <div class="status-bar">
                                    <div class="status-fill" style="width: 42%"></div>
                                </div>
                                <p>42% de capacidad utilizada</p>
                            </div>
                            <div class="status-item">
                                <h4>Rendimiento</h4>
                                <div class="status-bar">
                                    <div class="status-fill" style="width: 78%"></div>
                                </div>
                                <p>78% de capacidad utilizada</p>
                            </div>
                        </div>
                        <div class="backup-actions">
                            <button class="btn-view" id="backup-now">
                                <i class="fas fa-save"></i> Respaldo Ahora
                            </button>
                            <button class="btn-cancel" id="schedule-backup">
                                <i class="fas fa-calendar-alt"></i> Programar Respaldo
                            </button>
                        </div>
                    </div>
-->
                    
                    <div class="info-card">
                        <h3><i class="fas fa-chart-line"></i> Reportes Recientes</h3>
                        <div class="reports-list">
                            <div class="report-item">
                                <div class="report-icon">
                                    <i class="fas fa-file-medical-alt"></i>
                                </div>
                                <div class="report-details">
                                    <h4>Reporte Mensual de Pacientes</h4>
                                    <p><i class="fas fa-calendar"></i> Octubre 2023</p>
                                    <p><i class="fas fa-download"></i> Generado: Hoy, 09:00 AM</p>
                                </div>
                                <button class="btn-view" aria-label="Ver reporte mensual">Ver</button>
                            </div>
                            <div class="report-item">
                                <div class="report-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="report-details">
                                    <h4>Reporte de Eficiencia Médica</h4>
                                    <p><i class="fas fa-calendar"></i> Semana 42</p>
                                    <p><i class="fas fa-download"></i> Generado: Ayer, 05:30 PM</p>
                                </div>
                                <button class="btn-view" aria-label="Ver reporte de eficiencia">Ver</button>
                            </div>
                            <div class="report-item">
                                <div class="report-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="report-details">
                                    <h4>Reporte de Incidentes</h4>
                                    <p><i class="fas fa-calendar"></i> Últimos 7 días</p>
                                    <p><i class="fas fa-download"></i> Generado: Hoy, 08:15 AM</p>
                                </div>
                                <button class="btn-view" aria-label="Ver reporte de incidentes">Ver</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="gestion-roles.html" class="action-card">
                            <i class="fas fa-user-shield"></i>
                            <span>Gestionar Roles</span>
                        </a>
                        <a href="control-accesos.html" class="action-card">
                            <i class="fas fa-lock"></i>
                            <span>Control de Accesos</span>
                        </a>
                        <a href="respaldo-datos.html" class="action-card">
                            <i class="fas fa-database"></i>
                            <span>Respaldo de Datos</span>
                        </a>
                        <a href="reportes-admin.html" class="action-card">
                            <i class="fas fa-chart-bar"></i>
                            <span>Generar Reportes</span>
                        </a>
                    </div>
                </div>
            </div>

    <!-- Modal de notificaciones -->
    <div class="modal-overlay" id="notifications-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Notificaciones del Sistema</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Respaldo programado para hoy a las 2:00 AM</li>
                    <li>2 usuarios requieren verificación de permisos</li>
                    <li>Espacio en disco al 78% de capacidad</li>
                    <li>Reporte mensual listo para revisión</li>
                    <li>Actualización de seguridad disponible</li>
                </ul>
            </div>
        </div>
    </div>
@endsection