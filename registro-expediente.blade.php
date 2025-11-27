@extends('plantillas.dashboard_general')
@section('title', 'Registro de Expediente Médico - Hospital Naval')

@section('styles')
@vite(['resources/css/medic/registro-expediente.css'])
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

/* ===== ALERTAS ===== */
.alert {
    padding: 15px 20px;
    margin: 20px 30px;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

/* ===== FORMULARIO MÉDICO ===== */
.form-container {
    max-width: 1200px;
    margin: 0 auto;
}

.medical-form {
    background: var(--card-bg);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-section {
    padding: 30px;
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    color: var(--primary-color);
    font-size: 1.3rem;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-section h3 i {
    color: var(--accent-color);
}

/* ===== GRID DE FORMULARIOS ===== */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-color);
    font-size: 0.95rem;
}

.form-group label::after {
    content: " *";
    color: var(--danger-color);
    opacity: 0;
}

.form-group input:required + label::after,
.form-group select:required + label::after,
.form-group textarea:required + label::after {
    opacity: 1;
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
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

/* ===== BOTONES HORIZONTALES PARA ANTECEDENTES ===== */
.medical-buttons-horizontal {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.medical-button-item {
    text-align: center;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 10px;
    border: 2px dashed var(--border-color);
    transition: all 0.3s ease;
}

.medical-button-item:hover {
    border-color: var(--accent-color);
    background: white;
    transform: translateY(-2px);
}

.medical-button-item h4 {
    color: var(--primary-color);
    margin-bottom: 15px;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.medical-button-item h4 i {
    color: var(--accent-color);
}

/* ===== BOTONES ===== */
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

/* ===== CONTENEDORES DINÁMICOS ===== */
#contenedorAlergias,
#contenedorCronicas {
    margin-top: 20px;
}

.dynamic-form-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 4px solid var(--accent-color);
}

/* ===== SUGERENCIAS ===== */
.sugerencias-lista,
.sugerencias-lista-diagnosticos {
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
    padding: 30px;
    background: #f8f9fa;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    border-top: 1px solid var(--border-color);
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

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.form-section {
    animation: fadeIn 0.5s ease-out;
}

/* ===== ESTILOS PARA CAMPOS REQUERIDOS ===== */
.form-group input:required,
.form-group select:required,
.form-group textarea:required {
    border-left: 3px solid var(--accent-color);
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
    
    .header-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .search-box input {
        width: 200px;
    }
    
    .form-section {
        padding: 20px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .medical-buttons-horizontal {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-actions {
        padding: 20px;
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .form-section h3 {
        font-size: 1.1rem;
    }
    
    .medical-button-item {
        padding: 20px;
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
</style>

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
                <a href="{{ route('dashboardMedico') }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registro-expediente') }}" class="active">
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
            <h1>Registro de Expediente Médico</h1>
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
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-container">
                <form id="expedienteForm" class="medical-form" method="post" action="{{ route('save_medical_record') }}">
                    @csrf
                    
                    <!-- Información del Paciente -->
                    <div class="form-section">
                        <h3><i class="fas fa-user"></i> Información del Paciente</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre">Nombre Completo *</label>
                                <input type="text" id="nombre" name="nombre" required autocomplete="off">
                                <div id="sugerencias-pacientes" class="sugerencias-lista"></div>
                                <input type="hidden" id="paciente_id" name="paciente_id">
                            </div>
                            <div class="form-group">
                                <label for="fechaNacimiento">Fecha de Nacimiento *</label>
                                <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                            </div>
                            <div class="form-group">
                                <label for="genero">Género *</label>
                                <select id="genero" name="genero" required>
                                    <option value="">Seleccionar</option>
                                    <option value="hombre">Masculino</option>
                                    <option value="mujer">Femenino</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="direccion">Dirección</label>
                                <textarea id="direccion" name="direccion" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Signos Vitales -->
                    <div class="form-section">
                        <h3><i class="fas fa-heartbeat"></i> Signos Vitales</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="presionArterial">Presión Arterial</label>
                                <input type="text" id="presionArterial" name="presionArterial" placeholder="Ej: 120/80">
                            </div>
                            <div class="form-group">
                                <label for="frecuenciaCardiaca">Frecuencia Cardíaca</label>
                                <input type="number" id="frecuenciaCardiaca" name="frecuenciaCardiaca" placeholder="lpm">
                            </div>
                            <div class="form-group">
                                <label for="temperatura">Temperatura</label>
                                <input type="number" id="temperatura" name="temperatura" step="0.1" placeholder="°C">
                            </div>
                            <div class="form-group">
                                <label for="peso">Peso</label>
                                <input type="number" id="peso" name="peso" step="0.1" placeholder="kg">
                            </div>
                            <div class="form-group">
                                <label for="estatura">Estatura</label>
                                <input type="number" id="estatura" name="estatura" step="0.1" placeholder="cm">
                            </div>
                        </div>
                    </div>

                    <!-- Antecedentes Médicos -->
                    <div class="form-section">
                        <h3><i class="fas fa-stethoscope"></i> Antecedentes Médicos</h3>
                        
                        <div class="medical-buttons-horizontal">
                            <div class="medical-button-item">
                                <h4><i class="fas fa-allergies"></i> Alergia</h4>
                                <button type="button" class="btn-primary" onclick="agregarAlergia()">
                                    <i class="fas fa-plus"></i> Agregar alergia
                                </button>
                            </div>

                            <div class="medical-button-item">
                                <h4><i class="fas fa-heartbeat"></i> Enfermedad crónica</h4>
                                <button type="button" class="btn-primary" onclick="agregarCronica()">
                                    <i class="fas fa-plus"></i> Agregar enfermedad crónica
                                </button>
                            </div>
                        </div>

                        <div id="contenedorAlergias"></div>
                        <div id="contenedorCronicas"></div>

                        <template id="template-alergia">
                            @include('plantillas.formularios.form-alergia')
                        </template>

                        <template id="template-cronica">
                            @include('plantillas.formularios.form-enfermedades-cronicas')
                        </template>
                    </div>

                    <!-- Consulta Actual -->
                    <div class="form-section">
                        <h3><i class="fas fa-notes-medical"></i> Consulta Actual</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fechaConsulta">Fecha de Consulta *</label>
                                <input type="datetime-local" id="fechaConsulta" name="fechaConsulta" required>
                            </div>
                            <div class="form-group">
                                <label for="motivoConsulta">Motivo de Consulta *</label>
                                <input type="text" id="motivoConsulta" name="motivoConsulta" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="sintomas">Síntomas</label>
                                <textarea id="sintomas" name="sintomas" rows="3" placeholder="Describa los síntomas del paciente"></textarea>
                            </div>
                            <div class="form-group full-width">
                                <label for="exploracion">Exploración Física</label>
                                <textarea id="exploracion" name="exploracion" rows="3" placeholder="Hallazgos en la exploración física"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnóstico y Tratamiento -->
                    <div class="form-section">
                        <h3><i class="fas fa-diagnoses"></i> Diagnóstico y Tratamiento</h3>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="diagnostico">Diagnóstico *</label>
                                <input type="text" id="diagnostico" name="diagnostico" required autocomplete="off">
                                <div id="sugerencias-diagnosticos" class="sugerencias-lista-diagnosticos"></div>
                                <input type="hidden" id="diagnostico_id" name="diagnostico_id">
                            </div>
                            <div class="form-group full-width">
                                <label for="tratamiento">Tratamiento Indicado</label>
                                <textarea id="tratamiento" name="tratamiento" rows="3" placeholder="Medicamentos, dosis y recomendaciones"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="limpiarFormulario()">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> Guardar Expediente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection 

@section('scripts')
@vite(['resources/js/medic/script-medico.js'])
@endsection