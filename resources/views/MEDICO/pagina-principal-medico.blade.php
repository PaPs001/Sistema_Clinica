@extends('plantillas.dashboard_medico')
@section('title', 'Dashboard M�dico - Hospital Naval')
@section('styles')
    @vite('resources/css/medic/paginas/pagina_principal_medico.css')
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
            <!-- Estad�sticas -->
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

            <!-- Pr�ximas Citas de la Semana -->
            <div class="recent-patients">
                <h2>Pr�ximas Citas de la Semana</h2>
                <div class="appointments-search">
                    <input type="text" id="appointmentSearch" placeholder="Buscar cita por nombre de paciente...">
                </div>
                <div class="patients-table">
                    <table id="appointments-table">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="appointments-tbody">
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px;">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando citas...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Acciones R�pidas -->
            <div class="quick-actions">
                <h2>Acciones R�pidas</h2>
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
@vite(['resources/js/medic/script-medico.js', 'resources/js/medic/pagina-principal-medico.js'])
@endsection
