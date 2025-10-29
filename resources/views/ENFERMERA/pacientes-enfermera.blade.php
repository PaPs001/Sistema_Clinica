<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes - Hospital Naval</title>
    <link rel="stylesheet" href="style-pacientes.css">
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
                <a href="pacientes-enfermera.html" class="nav-item active">
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
                <h1>Gestión de Pacientes</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar paciente..." aria-label="Buscar paciente">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <button class="btn-primary" id="nuevo-paciente">
                        <i class="fas fa-user-plus"></i>
                        Nuevo Paciente
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Filtros Mejorados -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filtrar por:</label>
                        <select id="filter-status" aria-label="Filtrar por estado">
                            <option value="">Todos los estados</option>
                            <option value="active">Activos</option>
                            <option value="critical">Críticos</option>
                            <option value="stable">Estables</option>
                            <option value="discharged">Alta médica</option>
                        </select>
                        <select id="filter-ward" aria-label="Filtrar por área">
                            <option value="">Todas las áreas</option>
                            <option value="emergency">Urgencias</option>
                            <option value="surgery">Cirugía</option>
                            <option value="internal">Medicina Interna</option>
                            <option value="icu">UCI</option>
                        </select>
                        <select id="filter-doctor" aria-label="Filtrar por médico">
                            <option value="">Todos los médicos</option>
                            <option value="1">Dr. Carlos Ruiz</option>
                            <option value="2">Dra. Ana Martínez</option>
                            <option value="3">Dr. Roberto Silva</option>
                        </select>
                        <button class="section-btn" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Lista de Pacientes Mejorada -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Pacientes Hospitalizados
                        <div class="section-actions">
                            <button class="section-btn" id="export-patients">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                            <button class="section-btn" id="refresh-list">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    <div class="patients-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Habitación</th>
                                    <th>Edad</th>
                                    <th>Diagnóstico</th>
                                    <th>Médico</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="patient-row critical" data-patient="carlos-ruiz">
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Carlos Ruiz</strong>
                                                <span>DNI: 12345678A</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>304 - UCI</td>
                                    <td>65 años</td>
                                    <td>Hipertensión arterial severa</td>
                                    <td>Dr. Carlos Ruiz</td>
                                    <td><span class="status-badge critical">Crítico</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver historial" aria-label="Ver historial de Carlos Ruiz">
                                                <i class="fas fa-history"></i>
                                            </button>
                                            <button class="btn-action" title="Signos vitales" aria-label="Registrar signos vitales de Carlos Ruiz">
                                                <i class="fas fa-heartbeat"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar" aria-label="Editar información de Carlos Ruiz">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="patient-row warning" data-patient="ana-lopez">
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Ana López</strong>
                                                <span>DNI: 23456789B</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>205 - Medicina</td>
                                    <td>42 años</td>
                                    <td>Neumonía bacteriana</td>
                                    <td>Dra. Ana Martínez</td>
                                    <td><span class="status-badge warning">Grave</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver historial" aria-label="Ver historial de Ana López">
                                                <i class="fas fa-history"></i>
                                            </button>
                                            <button class="btn-action" title="Signos vitales" aria-label="Registrar signos vitales de Ana López">
                                                <i class="fas fa-heartbeat"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar" aria-label="Editar información de Ana López">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="patient-row stable" data-patient="miguel-torres">
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Miguel Torres</strong>
                                                <span>DNI: 34567890C</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>102 - Cirugía</td>
                                    <td>58 años</td>
                                    <td>Diabetes mellitus tipo 2</td>
                                    <td>Dr. Roberto Silva</td>
                                    <td><span class="status-badge stable">Estable</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver historial" aria-label="Ver historial de Miguel Torres">
                                                <i class="fas fa-history"></i>
                                            </button>
                                            <button class="btn-action" title="Signos vitales" aria-label="Registrar signos vitales de Miguel Torres">
                                                <i class="fas fa-heartbeat"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar" aria-label="Editar información de Miguel Torres">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Información del Paciente Seleccionado Mejorada -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-info-circle"></i> Información del Paciente</h3>
                        <div class="patient-details" id="patient-details">
                            <div class="detail-group">
                                <h4>Seleccione un paciente para ver detalles</h4>
                                <p class="no-selection">Haga clic en cualquier paciente de la lista para ver su información completa</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fas fa-stethoscope"></i> Últimos Signos Vitales</h3>
                        <div class="vitals-summary" id="vitals-summary">
                            <p class="no-selection">Seleccione un paciente para ver sus signos vitales</p>
                        </div>
                    </div>
                </div>

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
                        <a href="tratamientos.html" class="action-card">
                            <i class="fas fa-syringe"></i>
                            <span>Aplicar Tratamientos</span>
                        </a>
                        <a href="reportes-enfermera.html" class="action-card">
                            <i class="fas fa-file-medical"></i>
                            <span>Generar Reporte</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Paciente Mejorado -->
    <div class="modal-overlay" id="nuevo-paciente-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Registrar Nuevo Paciente</h3>
                <button class="close-modal" aria-label="Cerrar modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="nuevo-paciente-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient-name">Nombre Completo</label>
                            <input type="text" id="patient-name" placeholder="Nombre y apellidos" required>
                        </div>
                        <div class="form-group">
                            <label for="patient-dni">DNI</label>
                            <input type="text" id="patient-dni" placeholder="Número de documento" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient-birthdate">Fecha de Nacimiento</label>
                            <input type="date" id="patient-birthdate" required>
                        </div>
                        <div class="form-group">
                            <label for="patient-gender">Género</label>
                            <select id="patient-gender" required>
                                <option value="">Seleccionar</option>
                                <option value="male">Masculino</option>
                                <option value="female">Femenino</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="patient-address">Dirección</label>
                        <input type="text" id="patient-address" placeholder="Dirección completa">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient-phone">Teléfono</label>
                            <input type="tel" id="patient-phone" placeholder="Número de contacto">
                        </div>
                        <div class="form-group">
                            <label for="patient-email">Correo Electrónico</label>
                            <input type="email" id="patient-email" placeholder="correo@ejemplo.com">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient-ward">Área de Hospitalización</label>
                            <select id="patient-ward" required>
                                <option value="">Seleccionar área</option>
                                <option value="emergency">Urgencias</option>
                                <option value="surgery">Cirugía</option>
                                <option value="internal">Medicina Interna</option>
                                <option value="icu">UCI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="patient-room">Habitación</label>
                            <input type="text" id="patient-room" placeholder="Número de habitación" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="cancel-form">Cancelar</button>
                        <button type="submit" class="btn-primary">Guardar Paciente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="script-pacientes.js"></script>
</body>
</html>