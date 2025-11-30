@extends('plantillas.dashboard_medico')
@section('title', 'Dashboard Médico - Hospital Naval')
@section('styles')
    @vite('resources/css/medic/paginas/modulo_plantilla.css')
@endsection
@section('content')
        <header class="content-header">
            <h1>Hola {{ Auth::user()->name }}</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" placeholder="Buscar paciente...">
                    <i class="fas fa-search"></i>
                </div>
                @include('partials.header-notifications')
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
@endsection

@section('scripts')
@vite(['resources/js/medic/script-medico.js'])
@endsection