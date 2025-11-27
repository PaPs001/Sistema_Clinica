@extends('plantillas.dashboard_general')
@section('title', 'Dashboard Médico - Hospital Naval')

@section('styles')
@vite('resources/css/medic/dashboard_medico.css')
<style>
/* ===== VARIABLES Y RESET ===== */
:root {
    --primary-color: #061175;
    --secondary-color: #0a1fa0;
    --accent-color: #667eea;
    --danger-color: #dc3545;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --text-color: #333;
    --light-bg: #f5f7fa;
    --card-bg: #ffffff;
    --border-color: #e1e5e9;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--light-bg);
    color: var(--text-color);
    line-height: 1.6;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR FIJO (CON LAS OPCIONES QUE TE GUSTARON) ===== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
}

.clinic-info {
    padding: 30px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 20px;
    text-align: center;
}

.clinic-info h3 {
    font-size: 1.5rem;
    margin-bottom: 5px;
    font-weight: 600;
}

.clinic-info p {
    font-size: 0.9rem;
    opacity: 0.8;
}

.sidebar-menu {
    list-style: none;
    padding: 0 15px;
    flex: 1;
}

.sidebar-menu li {
    margin-bottom: 8px;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
}

.sidebar-menu a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.sidebar-menu a:hover::before {
    left: 100%;
}

.sidebar-menu a:hover {
    background: rgba(255, 255, 255, 0.15);
    border-left-color: #fff;
    transform: translateX(5px);
}

.sidebar-menu a.active {
    background: rgba(255, 255, 255, 0.2);
    border-left-color: #fff;
}

.sidebar-menu i {
    margin-right: 15px;
    width: 20px;
    text-align: center;
    font-size: 1.1rem;
}

.user-section {
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 1.2rem;
}

.user-info strong {
    display: block;
    font-size: 0.95rem;
    margin-bottom: 3px;
}

.user-info div:last-child div {
    font-size: 0.8rem;
    opacity: 0.8;
}

.weather-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.weather-info:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* ===== CONTENIDO PRINCIPAL ===== */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin-left: 280px;
    width: calc(100% - 280px);
    min-height: 100vh;
}

.content-header {
    background: white;
    padding: 20px 30px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 999;
}

.content-header h1 {
    color: var(--primary-color);
    font-size: 1.8rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.search-box {
    position: relative;
}

.search-box input {
    padding: 10px 40px 10px 15px;
    border: 1px solid var(--border-color);
    border-radius: 25px;
    width: 300px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
    transform: scale(1.02);
}

.search-box i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.notifications {
    position: relative;
    cursor: pointer;
    font-size: 1.2rem;
    color: #666;
    transition: all 0.3s ease;
}

.notifications:hover {
    color: var(--primary-color);
    transform: scale(1.1);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--danger-color);
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

/* ===== CONTENIDO ===== */
.content {
    flex: 1;
    padding: 30px;
    overflow-y: auto;
    animation: contentFadeIn 0.8s ease-out;
}

/* ===== ESTADÍSTICAS ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: var(--card-bg);
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(to bottom, var(--accent-color), #764ba2);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--accent-color) 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    color: white;
    font-size: 1.5rem;
}

.stat-info h3 {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 5px;
}

.stat-info p {
    color: #666;
    font-size: 0.9rem;
}

/* ===== PACIENTES RECIENTES ===== */
.recent-patients {
    background: var(--card-bg);
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.recent-patients h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.patients-table {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.patients-table table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.patients-table th {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    border: none;
}

.patients-table th:first-child {
    border-top-left-radius: 7px;
}

.patients-table th:last-child {
    border-top-right-radius: 7px;
}

.patients-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
    background: var(--card-bg);
}

.patients-table tbody tr {
    transition: all 0.3s ease;
    animation: slideInRight 0.5s ease-out forwards;
    opacity: 0;
    transform: translateX(20px);
}

.patients-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
.patients-table tbody tr:nth-child(2) { animation-delay: 0.2s; }

.patients-table tbody tr:hover {
    background-color: #f8fafc;
    transform: translateX(5px);
}

/* ===== INFORMACIÓN DEL PACIENTE ===== */
.patient-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.patient-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent-color) 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.patient-info div {
    display: flex;
    flex-direction: column;
}

.patient-info strong {
    font-size: 0.95rem;
    color: var(--text-color);
    margin-bottom: 3px;
}

.patient-info span {
    font-size: 0.8rem;
    color: #666;
}

/* ===== BOTONES DE ACCIÓN ===== */
.btn-view, .btn-edit {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-right: 8px;
    display: inline-block;
}

.btn-view {
    background: var(--primary-color);
    color: white;
    box-shadow: 0 2px 5px rgba(6, 17, 117, 0.2);
}

.btn-edit {
    background: var(--warning-color);
    color: #000;
    box-shadow: 0 2px 5px rgba(255, 193, 7, 0.3);
}

.btn-view:hover {
    background: #050d5c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(6, 17, 117, 0.3);
}

.btn-edit:hover {
    background: #e0a800;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
}

.btn-view:active, .btn-edit:active {
    transform: translateY(0);
}

/* ===== ACCIONES RÁPIDAS ===== */
.quick-actions {
    background: var(--card-bg);
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.quick-actions h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;
    background: #f8f9fa;
    border-radius: 10px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.action-card:hover::before {
    opacity: 1;
}

.action-card:hover {
    background: white;
    border-color: var(--primary-color);
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 10px 25px rgba(6, 17, 117, 0.1);
}

.action-card i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.action-card span {
    font-weight: 600;
    text-align: center;
    position: relative;
    z-index: 1;
}

/* ===== ANIMACIONES ===== */
@keyframes contentFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
    
    .main-content {
        margin-left: 0;
        width: 100%;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .search-box input {
        width: 200px;
    }
    
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .content {
        padding: 20px 15px;
    }
    
    .header-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .actions-grid {
        grid-template-columns: 1fr 1fr;
    }
}

/* ===== MEJORAS DE ACCESIBILIDAD ===== */
button:focus, a:focus, input:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Sidebar CON LAS OPCIONES QUE TE GUSTARON -->
    <aside class="sidebar">
        <div class="clinic-info">
            <h3>Hospital Naval</h3>
            <p>Sistema Médico</p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboardMedico') }}" class="active">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registro-expediente') }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Nuevo Expediente</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta-historial') }}">
                    <i class="fas fa-history"></i>
                    <span>Historial Médico</span>
                </a>
            </li>
            <li>
                <a href="{{ route('iniciar-Upload-files') }}">
                    <i class="fas fa-upload"></i>
                    <span>Subir Documentos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('filtrar-expedientes') }}">
                    <i class="fas fa-filter"></i>
                    <span>Filtrar Expedientes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registro-alergias') }}">
                    <i class="fas fa-allergies"></i>
                    <span>Antecedentes Medicos</span>
                </a>
            </li>
        </ul>
        
        <div class="user-section">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <strong>Dr. {{ Auth::user()->name }}</strong>
                    <div>Médico General</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: inherit;">
                <div class="weather-info">
                    <span>Cerrar Sesión</span>
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="main-content">
        <header class="content-header">
            <h1>Hola {{ Auth::user()->name }}</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" placeholder="Buscar paciente...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
            </div>
        </header>
        
        <div class="content">
            <!-- Estadísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div class="stat-info">
                        <h3>156</h3>
                        <p>Pacientes Activos</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>24</h3>
                        <p>Citas Hoy</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div class="stat-info">
                        <h3>89</h3>
                        <p>Expedientes Nuevos</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>5</h3>
                        <p>Pendientes</p>
                    </div>
                </div>
            </div>

            <!-- Pacientes Recientes -->
            <div class="recent-patients">
                <h2>Pacientes Recientes</h2>
                <div class="patients-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Edad</th>
                                <th>Última Visita</th>
                                <th>Diagnóstico</th>
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
                                            <strong>María González</strong>
                                            <span>ID: MG-001</span>
                                        </div>
                                    </div>
                                </td>
                                <td>35 años</td>
                                <td>15 Mar 2024</td>
                                <td>Hipertensión</td>
                                <td>
                                    <button class="btn-view">Ver</button>
                                    <button class="btn-edit">Editar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <strong>Carlos López</strong>
                                            <span>ID: CL-002</span>
                                        </div>
                                    </div>
                                </td>
                                <td>42 años</td>
                                <td>14 Mar 2024</td>
                                <td>Diabetes Tipo 2</td>
                                <td>
                                    <button class="btn-view">Ver</button>
                                    <button class="btn-edit">Editar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="quick-actions">
                <h2>Acciones Rápidas</h2>
                <div class="actions-grid">
                    <a href="{{ route('registro-expediente') }}" class="action-card">
                        <i class="fas fa-file-medical"></i>
                        <span>Nuevo Expediente</span>
                    </a>
                    <a href="{{ route('consulta-historial') }}" class="action-card">
                        <i class="fas fa-search"></i>
                        <span>Buscar Paciente</span>
                    </a>
                    <a href="{{ route('iniciar-Upload-files') }}" class="action-card">
                        <i class="fas fa-upload"></i>
                        <span>Subir Documentos</span>
                    </a>
                    <a href="{{ route('registro-alergias') }}" class="action-card">
                        <i class="fas fa-allergies"></i>
                        <span>Registrar Alergias</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
@vite(['resources/js/medic/script-medico.js'])
@endsection