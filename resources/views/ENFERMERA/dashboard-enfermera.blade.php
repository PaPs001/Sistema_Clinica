@extends('plantillas.dashboard_enfermera')
@section('title', 'Dashboard Enfermera - Hospital Naval')
@section('styles')
    @vite(['resources/css/ENFERMERA/paginas/style-enfermera.css'])
@endsection

@section('content')
    <header class="content-header">
        <h1>¡Hola Laura!</h1>
    </header>

    <div class="content">
        {{-- Estadísticas rápidas (placeholder) --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-syringe"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat-tratamientos">0</h3>
                    <p>Tratamientos hoy</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat-citas">0</h3>
                    <p>Citas del día</p>
                </div>
            </div>
        </div>

        {{-- Alertas urgentes --}}
        <div class="recent-section">
            <h2>
                <i class="fas fa-exclamation-triangle"></i> Alertas Urgentes
                <div class="section-actions">
                    <button class="section-btn" id="filter-alerts">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button class="section-btn" id="mark-all-read">
                        <i class="fas fa-check-double"></i> Marcar todo
                    </button>
                </div>
            </h2>
            <div class="alerts-grid" id="alertas-container">
                <div class="alert-empty">Sin alertas pendientes</div>
            </div>
        </div>

        {{-- Pacientes activos --}}
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-procedures"></i> Pacientes Activos
                        <div class="section-actions">
                            <button class="section-btn" id="filter-patients">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </h2>
            <div class="patients-table">
                <table>
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Habitación</th>
                            <th>Condición</th>
                            <th>Signos Vitales</th>
                            <th>Última medición</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="pacientes-body">
                        <tr>
                            <td colspan="6" style="text-align:center;">Sin pacientes activos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tareas del turno --}}
        <div class="info-card">
            <h3><i class="fas fa-tasks"></i> Tareas del Turno</h3>
            <div class="tasks-list" id="tareas-container">
                <div class="task-empty">Sin tareas para este turno</div>
            </div>
        </div>

        {{-- Acciones rápidas --}}
        <div class="quick-actions">
            <h2>Acciones Rápidas</h2>
            <div class="actions-grid">
                <a href="{{ route('signosVitales') }}" class="action-card">
                    <i class="fas fa-heartbeat"></i>
                    <span>Registrar Signos</span>
                </a>
                <a href="{{ route('medicamentos') }}" class="action-card">
                    <i class="fas fa-pills"></i>
                    <span>Administrar Medicamentos</span>
                </a>
                <a href="{{ route('tratamientos') }}" class="action-card">
                    <i class="fas fa-syringe"></i>
                    <span>Tratamientos</span>
                </a>
                <a href="{{ route('reportesEnfermera') }}" class="action-card">
                    <i class="fas fa-file-medical"></i>
                    <span>Reportes</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/ENFERMERA/script-enfermera.js')
@endsection
