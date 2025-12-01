@extends('plantillas.dashboard_enfermera')
@section('title', 'Registro de Signos Vitales - Hospital Naval')
@section('styles')
    @vite(['resources/css/ENFERMERA/paginas/style-signos.css'])
@endsection

@section('content')
    <header class="content-header">
        <h1>Registro de Signos Vitales</h1>
        <div class="header-actions">
            <button class="btn-primary" id="nuevo-registro">
                <i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </header>

    <div class="content">
        <!-- Filtros -->
        <div class="filters-section">
            <div class="filter-group">
                <label>Filtrar por:</label>
                <select id="filter-patient">
                    <option value="">Todos los pacientes</option>
                </select>
                <select id="filter-date">
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                </select>
            </div>
        </div>

        <!-- Citas del día para registrar signos vitales -->
        <div class="recent-section">
            <h2><i class="fas fa-history"></i> Citas para Registro de Signos</h2>
            <div class="vitals-table">
                <table>
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Hora de cita</th>
                            <th>Médico</th>
                            <th>Presión Arterial</th>
                            <th>Frec. Cardíaca</th>
                            <th>Temperatura</th>
                            <th>Frec. Respiratoria</th>
                            <th>Sat. O2</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Valores de referencia -->
        <div class="info-card">
            <h3><i class="fas fa-exclamation-circle"></i> Valores de Referencia</h3>
            <div class="reference-values">
                <div class="reference-item">
                    <strong>Presión Arterial</strong>
                    <span>Normal: 120/80 mmHg</span>
                    <span>Alerta: &gt;140/90 mmHg</span>
                </div>
                <div class="reference-item">
                    <strong>Frecuencia Cardíaca</strong>
                    <span>Normal: 60-100 lpm</span>
                    <span>Alerta: &lt;50 o &gt;120 lpm</span>
                </div>
                <div class="reference-item">
                    <strong>Temperatura</strong>
                    <span>Normal: 36.5-37.5 °C</span>
                    <span>Alerta: &gt;38 °C</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/ENFERMERA/script-signos.js'])
@endsection
