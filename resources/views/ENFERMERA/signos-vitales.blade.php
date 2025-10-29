<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signos Vitales - Hospital Naval</title>
    <link rel="stylesheet" href="style-signos.css">
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
                <a href="signos-vitales.html" class="nav-item active">
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
                <h1>Registro de Signos Vitales</h1>
                <div class="header-actions">
                    <button class="btn-primary" id="nuevo-registro">
                        <i class="fas fa-plus"></i>
                        Nuevo Registro
                    </button>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Filtros -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filtrar por:</label>
                        <select id="filter-patient">
                            <option value="">Todos los pacientes</option>
                            <option value="1">Carlos Ruiz</option>
                            <option value="2">Ana López</option>
                            <option value="3">Miguel Torres</option>
                        </select>
                        <select id="filter-date">
                            <option value="today">Hoy</option>
                            <option value="week">Esta semana</option>
                            <option value="month">Este mes</option>
                        </select>
                    </div>
                </div>

                <!-- Registros de Signos Vitales -->
                <div class="recent-section">
                    <h2><i class="fas fa-history"></i> Registros Recientes</h2>
                    <div class="vitals-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Hora</th>
                                    <th>Presión Arterial</th>
                                    <th>Frec. Cardíaca</th>
                                    <th>Temperatura</th>
                                    <th>Frec. Respiratoria</th>
                                    <th>Sat. O2</th>
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
                                                <span>Habitación 304</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>10:30 AM</td>
                                    <td><span class="vital-reading high">180/110</span></td>
                                    <td><span class="vital-reading">92 lpm</span></td>
                                    <td><span class="vital-reading">37.2°C</span></td>
                                    <td><span class="vital-reading">18 rpm</span></td>
                                    <td><span class="vital-reading">96%</span></td>
                                    <td>
                                        <button class="btn-view">Editar</button>
                                        <button class="btn-cancel">Eliminar</button>
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
                                                <span>Habitación 205</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>11:15 AM</td>
                                    <td><span class="vital-reading">130/85</span></td>
                                    <td><span class="vital-reading">88 lpm</span></td>
                                    <td><span class="vital-reading high">39.2°C</span></td>
                                    <td><span class="vital-reading">20 rpm</span></td>
                                    <td><span class="vital-reading">95%</span></td>
                                    <td>
                                        <button class="btn-view">Editar</button>
                                        <button class="btn-cancel">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gráficos de Tendencia -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-chart-line"></i> Tendencia de Signos Vitales</h3>
                        <div class="chart-placeholder">
                            <p>Gráfico de tendencias de presión arterial y frecuencia cardíaca</p>
                            <div class="chart-legend">
                                <span class="legend-item"><i class="fas fa-square" style="color: #667eea;"></i> Presión Sistólica</span>
                                <span class="legend-item"><i class="fas fa-square" style="color: #764ba2;"></i> Presión Diastólica</span>
                                <span class="legend-item"><i class="fas fa-square" style="color: #28a745;"></i> Frec. Cardíaca</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fas fa-exclamation-circle"></i> Valores de Referencia</h3>
                        <div class="reference-values">
                            <div class="reference-item">
                                <strong>Presión Arterial</strong>
                                <span>Normal: 120/80 mmHg</span>
                                <span>Alerta: >140/90 mmHg</span>
                            </div>
                            <div class="reference-item">
                                <strong>Frecuencia Cardíaca</strong>
                                <span>Normal: 60-100 lpm</span>
                                <span>Alerta: <50 o >120 lpm</span>
                            </div>
                            <div class="reference-item">
                                <strong>Temperatura</strong>
                                <span>Normal: 36.5-37.5°C</span>
                                <span>Alerta: >38°C</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="script-signos.js"></script>
</body>
</html>