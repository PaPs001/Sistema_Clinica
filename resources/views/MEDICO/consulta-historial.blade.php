@extends('plantillas.dashboard_general')
@section('title', 'Consulta Historial - Hospital Naval')

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

/* ===== SECCIÓN DE RESULTADOS ===== */
.results-section {
    background: var(--card-bg);
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.results-section h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
    font-size: 1.3rem;
}

/* ===== TARJETA DE INFORMACIÓN DEL PACIENTE ===== */
.patient-info-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
    border-left: 4px solid var(--accent-color);
}

.patient-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.patient-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent-color) 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.patient-details h3 {
    color: var(--primary-color);
    font-size: 1.5rem;
    margin-bottom: 5px;
}

.patient-meta {
    color: #666;
    font-size: 0.9rem;
}

.patient-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.summary-item {
    background: white;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.summary-item strong {
    color: var(--primary-color);
    display: block;
    margin-bottom: 5px;
}

/* ===== TABLA DE PACIENTES ===== */
.table-container {
    background: white;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search-filters {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    align-items: center;
}

.search-filters .search-box {
    flex: 1;
}

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

.table-wrapper {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

th {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    border: none;
}

th:first-child {
    border-top-left-radius: 7px;
}

th:last-child {
    border-top-right-radius: 7px;
}

td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
    background: var(--card-bg);
}

tbody tr {
    transition: all 0.3s ease;
}

tbody tr:hover {
    background-color: #f8fafc;
    transform: translateX(5px);
}

/* ===== BOTONES DE ACCIÓN ===== */
.btn-view {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-view:hover {
    background: #050d5c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(6, 17, 117, 0.3);
}

/* ===== HISTORIAL DEL PACIENTE ===== */
.expedienteContainer {
    margin-top: 30px;
}

.patient-history {
    background: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.patient-history h3 {
    color: var(--primary-color);
    margin-bottom: 15px;
}

.patient-history h4 {
    color: var(--secondary-color);
    margin: 20px 0 10px 0;
}

.btnVerMas {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.btnVerMas:hover {
    background: #5a6fd8;
    transform: translateY(-1px);
}

/* ===== GRID DE INFORMACIÓN MÉDICA ===== */
.medical-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.medical-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.medical-card-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 15px 20px;
}

.medical-card-header h3 {
    margin: 0;
    font-size: 1.1rem;
}

.medical-card-content {
    padding: 20px;
    max-height: 300px;
    overflow-y: auto;
}

.medical-item {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 10px;
    border-left: 3px solid var(--accent-color);
}

.medical-item .label {
    font-weight: 600;
    color: var(--primary-color);
    display: block;
}

.medical-item .detail {
    font-size: 0.8rem;
    color: #666;
    display: block;
    margin-top: 4px;
}

.no-data {
    color: #666;
    font-style: italic;
    text-align: center;
    padding: 20px;
}

/* ===== DOCUMENTOS ===== */
.document-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
    border-left: 3px solid var(--success-color);
}

.document-card i {
    font-size: 1.5rem;
    color: var(--danger-color);
}

.document-info {
    flex: 1;
}

.document-info strong {
    display: block;
    color: var(--primary-color);
    margin-bottom: 4px;
}

.document-info span {
    font-size: 0.8rem;
    color: #666;
    display: block;
}

/* ===== MODAL ===== */
#modalConsulta {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 10000;
}

#modalConsulta > div {
    background: white;
    padding: 30px;
    border-radius: 10px;
    width: 80%;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

#cerrarModal {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--danger-color);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    padding: 8px 12px;
    font-weight: bold;
    transition: all 0.3s ease;
}

#cerrarModal:hover {
    background: #c82333;
    transform: scale(1.1);
}

/* ===== PAGINACIÓN ===== */
.d-flex {
    display: flex;
}

.justify-content-center {
    justify-content: center;
}

.mt-4 {
    margin-top: 1.5rem;
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
    
    .search-filters {
        flex-direction: column;
    }
    
    .patient-header {
        flex-direction: column;
        text-align: center;
    }
    
    .medical-info-grid {
        grid-template-columns: 1fr;
    }
    
    #modalConsulta > div {
        width: 95%;
        margin: 20px;
    }
}

@media (max-width: 480px) {
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .patient-details h3 {
        font-size: 1.3rem;
    }
    
    .table-container {
        padding: 15px;
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
                <a href="{{ route('registro-expediente') }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Nuevo Expediente</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta-historial') }}" class="active">
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
            <h1>Consulta de Historial Médico</h1>
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
            <!-- Resultados -->
            <div class="results-section">
                <h2>Resultados de Búsqueda</h2>
                
                <div class="patient-info-card" id="patientInfo" style="display: none;">
                    <div class="patient-header">
                        <div class="patient-avatar-large">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="patient-details">
                            <h3 id="patientName">Nombre del Paciente</h3>
                            <div class="patient-meta">
                                <span id="patientAge">Edad</span> • 
                                <span id="patientGender">Género</span> • 
                                <span id="patientId">ID</span>
                            </div>
                        </div>
                    </div>
                    <div class="patient-summary">
                        <div class="summary-item">
                            <strong>Alergias:</strong>
                            <span id="patientAllergies">Ninguna registrada</span>
                        </div>
                        <div class="summary-item">
                            <strong>Enfermedades Crónicas:</strong>
                            <span id="patientChronic">Ninguna registrada</span>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    
                    <!-- Panel de Búsqueda -->
                    <form method="GET" action="{{ route('consulta-historial') }}" class="search-filters">
                        <div class="search-box">
                            <div style="position: relative;">
                                <input type="text" name="buscar" id="searchPatient" placeholder="Buscar por nombre o ID..." value="{{ request('buscar') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </form>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Género</th>
                                <th>Teléfono</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody id="tablaPacientes">
                                @foreach($patientUser as $patient)
                                    @if($patient->userId != null)
                                        <tr>
                                            <td>{{ $patient->id }}</td>
                                            <td>{{ $patient->user->name }}</td>
                                            <td>{{ $patient->user->birthdate }}</td>
                                            <td>{{ $patient->user->genre }}</td>
                                            <td>{{ $patient->user->phone }}</td>
                                            <td>
                                                <button class="btn-view" onclick="verHistorial({{ $patient->id }})">
                                                    Ver historial
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $patientUser->onEachSide(1)->links('plantillas.pagination') }}
                    </div>
                </div>
                
                <div class="expedienteContainer" style="display: none;">
                    <div id="historialPaciente" class="patient-history" style="margin-top: 30px;">
                
                    </div>
                    <div class="medical-info-grid">
                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Alergias</h3>
                            </div>
                            <div class="medical-card-content">
                                <div id="alergias-content">
                                    <p class="no-data">No se han registrado alergias</p>
                                </div>
                            </div>
                        </div>

                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Enfermedades Crónicas</h3>
                            </div>
                            <div class="medical-card-content">
                                <div id="enfermedades-cronicas-content">
                                    <p class="no-data">No se han registrado enfermedades crónicas</p>
                                </div>
                            </div>
                        </div>

                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Medicamentos Actuales</h3>
                            </div>
                            <div class="medical-card-content">
                                <div id="medicamentos-content">
                                    <p class="no-data">No se han registrado medicamentos</p>
                                </div>
                            </div>
                        </div>
                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Documentos Adjuntos</h3>
                            </div>

                            <div class="medical-card-content" id="attached-documents">
                                <div id="archivos-content">
                                    <p class="no-data">No se han encontrado archivos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modalConsulta" style="
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        ">
            <div style="
                background: white;
                padding: 20px;
                border-radius: 10px;
                width: 80%;
                max-width: 600px;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            ">
                <button id="cerrarModal" style="
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: red;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    padding: 5px 10px;
                ">X</button>

                <div id="contenidoModal">
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
function verHistorial(id) {
    const container = document.querySelector('.expedienteContainer');
    container.style.display = 'none';

    fetch(`/obtenerDatos/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Error al obtener el historial del paciente');
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data); 

            const div = document.getElementById('historialPaciente');
            const divAlergias = document.getElementById('alergias-content');
            const divEnfermedades = document.getElementById('enfermedades-cronicas-content');
            const divMedicamentos = document.getElementById('medicamentos-content');
            const divArchivos = document.getElementById('attached-documents');
            const vitalSigns = data.vital_signs ?? [];
            const user = data.user ?? {};
            const allergies = data.medical_records?.flatMap(r => r.allergies ?? []) ?? [];
            const chronicDiseases = data.medical_records?.flatMap(r => r.disease_records ?? []) ?? [];
            const medicines = data.medical_records?.flatMap(r => r.medicines ?? []) ?? [];
            const medicalRecords = data.medical_records ?? [];
            const Archivos = data.medical_records[0]?.files ?? [];
            const ultimaConsulta = vitalSigns.length
                ? (vitalSigns[0].appointment?.appointment_date ?? 'N/A')
                : 'N/A';
            window.vitalSignsData = vitalSigns;
            window.medicalRecordsData = medicalRecords;
            div.innerHTML = `
                <h3>Historial de <strong>${user.name ?? 'Sin nombre'}</strong></h3>
                <p><strong>Fecha de última consulta:</strong> ${ultimaConsulta}</p>
                <p><strong>Edad:</strong> ${user.birthdate ?? 'N/A'}</p>
                <p><strong>Género:</strong> ${user.genre ?? 'N/A'}</p>
                <p><strong>Teléfono:</strong> ${user.phone ?? 'N/A'}</p>

                <h4>Signos Vitales</h4>
                ${
                    vitalSigns.length
                        ? vitalSigns.map((vs, i) => `
                            <div style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                                <p><strong>Fecha:</strong> ${vs.appointment?.appointment_date ?? 'N/A'}</p>
                                <p>Temperatura: ${vs.temperature ?? 'N/A'} °C</p>
                                <p>Frecuencia cardiaca: ${vs.heart_rate ?? 'N/A'} lpm</p>
                                <p>Peso: ${vs.weight ?? 'N/A'} kg</p>
                                <p>Altura: ${vs.height ?? 'N/A'} cm</p>
                                <button class="btnVerMas" onclick="abrirModal(${i})">Ver más</button>
                            </div>
                        `).join('')
                        : '<p>No hay signos vitales registrados.</p>'
                }
            `;

            divAlergias.innerHTML = allergies.length
                ? allergies.map(a => `
                    <div class="medical-item">
                        ${a.allergie_allergene?.allergie?.name ?? 'Desconocida'} 
                        – ${a.allergie_allergene?.allergene?.name ?? 'Desconocido'}
                        <span class="detail">Registrada: ${a.created_at?.slice(0,10) ?? 'N/A'}</span>
                    </div>
                `).join('')
                : '<p class="no-data">No se han registrado alergias</p>';

            divEnfermedades.innerHTML = chronicDiseases.length
                ? chronicDiseases.map(e => `
                    <div class="medical-item">
                        <span class="label">${e.disease?.name ?? 'No especificada'}</span>
                        <span class="detail">Fecha: ${e.created_at?.slice(0, 10) ?? 'N/A'}</span>
                    </div>
                `).join('')
                : '<p class="no-data">No se han registrado enfermedades crónicas</p>';

            divMedicamentos.innerHTML = medicines.length
                ? medicines.map(m => `
                    <div class="medical-item">
                        <span class="label">${m.name ?? 'Desconocido'}</span>
                        <span class="detail">${m.dosage ?? 'Dosis no especificada'}</span>
                    </div>
                `).join('')
                : '<p class="no-data">No se han registrado medicamentos</p>';
            
            divArchivos.innerHTML = Archivos.length
            ? Archivos.map(m => `
                <div class="document-card">
                    <i class="fas fa-file-pdf"></i>
                    <div class="document-info">
                        <strong>${m.file_name}</strong>
                        <span>${m.upload_date.slice(0, 10)} – ${m.file_size} MB</span>
                        <span>Tipo: ${m.document_type?.name ?? 'Sin especificar'}</span>
                    </div>
                    <a class="btn-view" href="/${m.route}" target="_blank">Ver</a>
                </div>
            `).join('')
            : '<p class="no-data">No se han registrado documentos</p>';

            container.style.display = 'block';
        })
        .catch(error => {
            console.error('Error cargando historial:', error);
            document.getElementById('historialPaciente').innerHTML =
                '<p style="color:red;">Error al cargar el historial del paciente.</p>';
        });
}

function abrirModal(index) {
    const consulta = window.vitalSignsData[index];
    const consultDiseases = window.medicalRecordsData.flatMap(mr => mr.consult_diseases);
    const diagnosticosPerConsulta = consultDiseases.find(cd => 
        cd.appointment_id === consulta.appointment.id
    ) || {};
    const modal = document.getElementById('modalConsulta');
    const contenidoModal = document.getElementById('contenidoModal');
    const cerrarModal = document.getElementById('cerrarModal');
    const enfermedad = diagnosticosPerConsulta.disease?.name ?? 'Sin diagnóstico';
    contenidoModal.innerHTML = `
        <h3>Consulta del ${consulta.appointment?.appointment_date ?? 'N/A'}</h3>
        <p><strong>Temperatura:</strong> ${consulta.temperature ?? 'N/A'} °C</p>
        <p><strong>Frecuencia cardiaca:</strong> ${consulta.heart_rate ?? 'N/A'} lpm</p>
        <p><strong>Peso:</strong> ${consulta.weight ?? 'N/A'} kg</p>
        <p><strong>Altura:</strong> ${consulta.height ?? 'N/A'} cm</p>
        <hr>
        <p><strong>Razon de consulta: </strong> ${diagnosticosPerConsulta.reason ?? 'Sin notas adicionales'}</p>
        <p><strong>Sintomas descritos: </strong> ${diagnosticosPerConsulta.symptoms ?? 'Sin notas adicionales'}</p>
        <p><strong>Revision: </strong> ${diagnosticosPerConsulta.findings ?? 'Sin notas adicionales'}</p>
        <p><strong>Diagnóstico: </strong>  ${enfermedad}</p>
        <p><strong>Tratamiento: </strong> ${diagnosticosPerConsulta.treatment_diagnosis ?? 'Sin notas adicionales'}</p>
    `;

    modal.style.display = 'flex';

    cerrarModal.onclick = () => modal.style.display = 'none';
    modal.onclick = e => {
        if (e.target === modal) modal.style.display = 'none';
    };
}
</script>
@endsection