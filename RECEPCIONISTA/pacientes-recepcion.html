<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes - Clínica "Ultima Asignatura"</title>
    <link rel="stylesheet" href="style-recepcionista.css">
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
                <p>Módulo Recepcionista</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard-recepcionista.html" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="registro-pacientes.html" class="nav-item">
                    <i class="fas fa-user-plus"></i>
                    <span>Registrar Pacientes</span>
                </a>
                <a href="gestion-citas.html" class="nav-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Gestión de Citas</span>
                </a>
                <a href="agenda.html" class="nav-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Agenda</span>
                </a>
                <a href="pacientes-recepcion.html" class="nav-item active">
                    <i class="fas fa-user-injured"></i>
                    <span>Pacientes</span>
                </a>
                <a href="recordatorios.html" class="nav-item">
                    <i class="fas fa-bell"></i>
                    <span>Recordatorios</span>
                </a>
                <a href="reportes-recepcion.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="user-details">
                        <strong>Ana Rodríguez</strong>
                        <span>Recepcionista</span>
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
                        <input type="text" placeholder="Buscar por nombre, teléfono o ID..." aria-label="Buscar pacientes">
                        <i class="fas fa-search"></i>
                    </div>
                    <button class="section-btn" id="add-patient-btn">
                        <i class="fas fa-user-plus"></i> Nuevo Paciente
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Filtros y Estadísticas -->
                <div class="patients-controls">
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="status-filter">Estado:</label>
                            <select id="status-filter">
                                <option value="">Todos los estados</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="nuevo">Nuevo</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="date-filter">Fecha de Registro:</label>
                            <select id="date-filter">
                                <option value="">Todas las fechas</option>
                                <option value="hoy">Hoy</option>
                                <option value="semana">Esta semana</option>
                                <option value="mes">Este mes</option>
                                <option value="anio">Este año</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="sort-by">Ordenar por:</label>
                            <select id="sort-by">
                                <option value="nombre">Nombre A-Z</option>
                                <option value="fecha">Fecha de Registro</option>
                                <option value="reciente">Más Reciente</option>
                                <option value="antiguo">Más Antiguo</option>
                            </select>
                        </div>
                        
                        <button class="section-btn" id="apply-filters">
                            <i class="fas fa-filter"></i> Aplicar
                        </button>
                        <button class="section-btn btn-cancel" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                    
                    <div class="patients-stats">
                        <div class="stat-item">
                            <span class="stat-number">2,847</span>
                            <span class="stat-label">Total Pacientes</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">48</span>
                            <span class="stat-label">Esta Semana</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">12</span>
                            <span class="stat-label">Hoy</span>
                        </div>
                    </div>
                </div>

                <!-- Lista de Pacientes -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-users"></i> Lista de Pacientes
                        <div class="section-actions">
                            <button class="section-btn" id="export-patients">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                            <button class="section-btn" id="refresh-patients">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                            <button class="section-btn" id="bulk-actions">
                                <i class="fas fa-cog"></i> Acciones
                            </button>
                        </div>
                    </h2>
                    
                    <div class="patients-table-container">
                        <table class="patients-table">
                            <thead>
                                <tr>
                                    <th class="select-column">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>Paciente</th>
                                    <th>Contacto</th>
                                    <th>Información</th>
                                    <th>Última Visita</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="patient-row" data-status="activo">
                                    <td class="select-column">
                                        <input type="checkbox" class="patient-select">
                                    </td>
                                    <td>
                                        <div class="patient-info-compact">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="patient-details">
                                                <strong>Carlos Ruiz Hernández</strong>
                                                <span>ID: CR-2847</span>
                                                <span>65 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p><i class="fas fa-phone"></i> 555-123-4567</p>
                                            <p><i class="fas fa-envelope"></i> carlos.ruiz@email.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <p><i class="fas fa-tint"></i> Tipo A+</p>
                                            <p><i class="fas fa-allergies"></i> Sin alergias</p>
                                            <p><i class="fas fa-file-medical"></i> Hipertensión</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-visit">
                                            <strong>15 Nov 2023</strong>
                                            <span>Dr. Elena Morales</span>
                                            <span class="visit-type consulta">Consulta</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge active">Activo</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver perfil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-calendar" title="Agendar cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            <button class="btn-message" title="Enviar mensaje">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr class="patient-row" data-status="nuevo">
                                    <td class="select-column">
                                        <input type="checkbox" class="patient-select">
                                    </td>
                                    <td>
                                        <div class="patient-info-compact">
                                            <div class="patient-avatar new">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="patient-details">
                                                <strong>Ana López García</strong>
                                                <span>ID: AL-2848</span>
                                                <span>42 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p><i class="fas fa-phone"></i> 555-987-6543</p>
                                            <p><i class="fas fa-envelope"></i> ana.lopez@email.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <p><i class="fas fa-tint"></i> Tipo O+</p>
                                            <p><i class="fas fa-allergies"></i> Penicilina</p>
                                            <p><i class="fas fa-file-medical"></i> Diabetes tipo 2</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-visit">
                                            <strong>14 Nov 2023</strong>
                                            <span>Dr. Roberto Silva</span>
                                            <span class="visit-type control">Control</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge new">Nuevo</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver perfil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-calendar" title="Agendar cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            <button class="btn-message" title="Enviar mensaje">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr class="patient-row" data-status="activo">
                                    <td class="select-column">
                                        <input type="checkbox" class="patient-select">
                                    </td>
                                    <td>
                                        <div class="patient-info-compact">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="patient-details">
                                                <strong>Miguel Torres Ramírez</strong>
                                                <span>ID: MT-2849</span>
                                                <span>38 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p><i class="fas fa-phone"></i> 555-456-7890</p>
                                            <p><i class="fas fa-envelope"></i> miguel.torres@email.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <p><i class="fas fa-tint"></i> Tipo B+</p>
                                            <p><i class="fas fa-allergies"></i> Mariscos</p>
                                            <p><i class="fas fa-file-medical"></i> Asma</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-visit">
                                            <strong>10 Nov 2023</strong>
                                            <span>Dra. Elena Morales</span>
                                            <span class="visit-type emergencia">Urgencia</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge active">Activo</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver perfil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-calendar" title="Agendar cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            <button class="btn-message" title="Enviar mensaje">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr class="patient-row" data-status="inactivo">
                                    <td class="select-column">
                                        <input type="checkbox" class="patient-select">
                                    </td>
                                    <td>
                                        <div class="patient-info-compact">
                                            <div class="patient-avatar inactive">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="patient-details">
                                                <strong>Laura García Mendoza</strong>
                                                <span>ID: LG-2850</span>
                                                <span>29 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p><i class="fas fa-phone"></i> 555-321-0987</p>
                                            <p><i class="fas fa-envelope"></i> laura.garcia@email.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <p><i class="fas fa-tint"></i> Tipo AB+</p>
                                            <p><i class="fas fa-allergies"></i> Sin alergias</p>
                                            <p><i class="fas fa-file-medical"></i> Ninguna</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-visit">
                                            <strong>05 Oct 2023</strong>
                                            <span>Dr. Carlos Mendoza</span>
                                            <span class="visit-type consulta">Consulta</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge inactive">Inactivo</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver perfil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-calendar" title="Agendar cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            <button class="btn-message" title="Enviar mensaje">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr class="patient-row" data-status="activo">
                                    <td class="select-column">
                                        <input type="checkbox" class="patient-select">
                                    </td>
                                    <td>
                                        <div class="patient-info-compact">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="patient-details">
                                                <strong>Juan Pérez Castro</strong>
                                                <span>ID: JP-2851</span>
                                                <span>55 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p><i class="fas fa-phone"></i> 555-654-3210</p>
                                            <p><i class="fas fa-envelope"></i> juan.perez@email.com</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <p><i class="fas fa-tint"></i> Tipo A-</p>
                                            <p><i class="fas fa-allergies"></i> Ibuprofeno</p>
                                            <p><i class="fas fa-file-medical"></i> Artritis</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-visit">
                                            <strong>12 Nov 2023</strong>
                                            <span>Dra. Elena Morales</span>
                                            <span class="visit-type control">Control</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge active">Activo</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="Ver perfil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-calendar" title="Agendar cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            <button class="btn-message" title="Enviar mensaje">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="pagination">
                        <button class="pagination-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <span class="pagination-ellipsis">...</span>
                        <button class="pagination-btn">10</button>
                        <button class="pagination-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Resumen Rápido -->
                <div class="quick-summary">
                    <div class="summary-card">
                        <h3><i class="fas fa-chart-pie"></i> Distribución por Edad</h3>
                        <div class="age-distribution">
                            <div class="age-group">
                                <span class="age-range">0-18 años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 15%"></div>
                                </div>
                                <span class="age-percent">15%</span>
                            </div>
                            <div class="age-group">
                                <span class="age-range">19-35 años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 35%"></div>
                                </div>
                                <span class="age-percent">35%</span>
                            </div>
                            <div class="age-group">
                                <span class="age-range">36-55 años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 30%"></div>
                                </div>
                                <span class="age-percent">30%</span>
                            </div>
                            <div class="age-group">
                                <span class="age-range">56+ años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 20%"></div>
                                </div>
                                <span class="age-percent">20%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <h3><i class="fas fa-heartbeat"></i> Condiciones Comunes</h3>
                        <div class="conditions-list">
                            <div class="condition-item">
                                <span class="condition-name">Hipertensión</span>
                                <span class="condition-count">423 pacientes</span>
                            </div>
                            <div class="condition-item">
                                <span class="condition-name">Diabetes</span>
                                <span class="condition-count">287 pacientes</span>
                            </div>
                            <div class="condition-item">
                                <span class="condition-name">Asma</span>
                                <span class="condition-count">156 pacientes</span>
                            </div>
                            <div class="condition-item">
                                <span class="condition-name">Artritis</span>
                                <span class="condition-count">134 pacientes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Perfil de Paciente -->
    <div class="modal-overlay" id="patient-profile-modal">
        <div class="modal large-modal">
            <div class="modal-header">
                <h3>Perfil del Paciente</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="patient-profile">
                    <!-- Contenido se carga dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <script src="script-pacientes.js"></script>
</body>
</html>