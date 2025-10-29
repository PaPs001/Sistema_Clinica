<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Recepcionista - Clínica "Ultima Asignatura"</title>
    <link rel="stylesheet" href="style-recepcionista.css">
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
                <a href="dashboard-recepcionista.html" class="nav-item active">
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
                <a href="pacientes-recepcion.html" class="nav-item">
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
