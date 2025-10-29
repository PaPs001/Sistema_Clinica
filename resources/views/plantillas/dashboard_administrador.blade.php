<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - Clínica "Ultima Asignatura"</title>
    <link rel="stylesheet" href="style-admin.css">
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
                <p>Módulo Administrador</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard-admin.html" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="gestion-roles.html" class="nav-item">
                    <i class="fas fa-user-shield"></i>
                    <span>Gestión de Roles</span>
                </a>
                <a href="control-accesos.html" class="nav-item">
                    <i class="fas fa-lock"></i>
                    <span>Control de Accesos</span>
                </a>
                <a href="respaldo-datos.html" class="nav-item">
                    <i class="fas fa-database"></i>
                    <span>Respaldo de Datos</span>
                </a>
                <a href="reportes-admin.html" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
                <a href="auditoria.html" class="nav-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Auditoría</span>
                </a>
                <a href="configuracion.html" class="nav-item">
                    <i class="fas fa-cogs"></i>
                    <span>Configuración</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="user-details">
                        <strong>Carlos Mendoza</strong>
                        <span>Administrador</span>
                    </div>
                </div>
                <a href="index.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->