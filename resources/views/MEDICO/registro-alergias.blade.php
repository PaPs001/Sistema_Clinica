@extends('plantillas.dashboard_general')
@section('title', 'Registro alergias Médico - Hospital Naval')

@section('styles')
@vite('resources/css/medic/registro-alergias.css')
@endsection

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

/* ===== LAYOUT CON SIDEBAR ===== */
.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR FIJO (EXACTAMENTE IGUAL AL DASHBOARD) ===== */
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

/* ===== CONTENIDO ===== */
.content {
    flex: 1;
    padding: 30px;
    overflow-y: auto;
    animation: contentFadeIn 0.8s ease-out;
}

/* ===== SECCIÓN DE REGISTRO ===== */
.registration-section {
    background: var(--card-bg);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-container {
    max-width: 100%;
}

.medical-form h3 {
    color: var(--primary-color);
    margin-bottom: 25px;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.medical-form h3 i {
    color: var(--accent-color);
}

/* ===== BOTONES PRINCIPALES ===== */
.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #050d5c 0%, #08188a 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(6, 17, 117, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #545b62;
    transform: translateY(-1px);
}

/* ===== GRID DE FORMULARIO ===== */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 25px;
    margin-bottom: 30px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-color);
    font-size: 0.95rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
    font-family: inherit;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

/* ===== CONTENEDORES DINÁMICOS ===== */
#contenedorAlergias,
#contenedorCronicas {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin: 20px 0;
}

/* ===== TARJETAS DE ALERGIAS/ENFERMEDADES ===== */
.alergia-card,
.cronica-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid var(--warning-color);
    position: relative;
}

.alergia-card {
    border-left-color: var(--danger-color);
}

.cronica-card {
    border-left-color: var(--success-color);
}

.card-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 15px;
}

.card-header h4 {
    color: var(--primary-color);
    font-size: 1.1rem;
    margin: 0;
}

.btn-remove {
    background: var(--danger-color);
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.btn-remove:hover {
    background: #c82333;
    transform: scale(1.05);
}

/* ===== GRID INTERNO DE FORMULARIOS ===== */
.form-subgrid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

/* ===== SUGERENCIAS ===== */
.sugerencias-lista {
    position: absolute;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-top: 2px;
}

.sugerencia-item {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.2s ease;
}

.sugerencia-item:hover {
    background-color: #f8f9fa;
}

.sugerencia-item:last-child {
    border-bottom: none;
}

/* ===== ACCIONES DEL FORMULARIO ===== */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    border-top: 1px solid var(--border-color);
    padding-top: 25px;
    margin-top: 20px;
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
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== MEJORAS DE ACCESIBILIDAD ===== */
button:focus,
input:focus,
select:focus,
textarea:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
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
    
    .content {
        padding: 20px 15px;
    }
    
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .registration-section {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-subgrid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .medical-form h3 {
        font-size: 1.2rem;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>

@section('content')
<div class="dashboard-container">
    <!-- Sidebar CON LAS OPCIONES ESPECÍFICAS QUE MOSTRASTE -->
    <aside class="sidebar">
        <div class="clinic-info">
            <h3>Hospital Naval</h3>
            <p>Sistema Médico</p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboardMedico') }}">
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
                <a href="{{ route('registro-alergias') }}" class="active">
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
            <h1>Registro de Antecedentes Médicos</h1>
        </header>

        <div class="content">
            <div class="registration-section">
                <div class="form-container">
                    <form id="alergiaForm" class="medical-form" method="post" action="{{ route('agregar_Alergia') }}">
                        <h3><i class="fas fa-plus-circle"></i> Registrar Nueva Alergia</h3>
                        @csrf 
                        
                        <div style="margin-bottom: 25px;">
                            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <button type="button" class="btn-primary" onclick="agregarAlergia()">
                                    <i class="fas fa-plus"></i> Agregar otra alergia
                                </button>
                                <button type="button" class="btn-primary" onclick="agregarCronica()">
                                    <i class="fas fa-heartbeat"></i> Agregar enfermedad crónica
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre-paciente">Nombre Paciente *</label>
                                <input type="text" id="nombre-paciente" class="nombre-paciente" name="nombre" required autocomplete="off">
                                <div class="sugerencias-lista sugerencias-pacientes"></div>
                                <input type="hidden" class="paciente_id" name="paciente_id">
                            </div>
                            
                            <div class="form-group">
                                <template id="template-alergia">
                                    @include('plantillas.formularios.form-alergia')
                                </template>
                            </div>

                            <div id="contenedorAlergias"></div>

                            <div class="form-group">
                                <h3><i class="fas fa-heartbeat"></i> Enfermedades Crónicas</h3>
                                <template id="template-cronica">
                                    @include('plantillas.formularios.form-enfermedades-cronicas')
                                </template>
                                <div id="contenedorCronicas"></div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="limpiarFormulario()">
                                <i class="fas fa-eraser"></i> Limpiar
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Registrar Alergia
                            </button>
                        </div>
                    </form>
                </div>  
            </div>
        </div>    
    </main>
</div>
@endsection

@section('scripts')
@vite(['resources/js/medic/script-agregar-alergias.js'])
@endsection