<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Enfermera - Hospital Naval</title>
    <link rel="stylesheet" href="style-enfermera.css">
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
                <a href="dashboard-enfermera.html" class="nav-item active">
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
