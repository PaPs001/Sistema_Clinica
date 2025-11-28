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
                            <option value="1">Carlos Ruiz</option>
                            <option value="2">Ana López</option>
                            <option value="3">Miguel Torres</option>
                        </select>
                        <select id="filter-date">
                            <option value="today">Hoy</option>
                            <option value="week">Esta semana</option>
                            <option value="month">Este mes</option>
                        </select>
                    </div>
                </div>

                <!-- Registros de Signos Vitales -->
                <div class="recent-section">
                    <h2><i class="fas fa-history"></i> Registros Recientes</h2>
                    <div class="vitals-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Hora</th>
                                    <th>Presión Arterial</th>
                                    <th>Frec. Cardíaca</th>
                                    <th>Temperatura</th>
                                    <th>Frec. Respiratoria</th>
                                    <th>Sat. O2</th>
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
                                                <strong>Carlos Ruiz</strong>
                                                <span>Habitación 304</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>10:30 AM</td>
                                    <td><span class="vital-reading high">180/110</span></td>
                                    <td><span class="vital-reading">92 lpm</span></td>
                                    <td><span class="vital-reading">37.2°C</span></td>
                                    <td><span class="vital-reading">18 rpm</span></td>
                                    <td><span class="vital-reading">96%</span></td>
                                    <td>
                                        <button class="btn-view-enfermera">Editar</button>
                                        <button class="btn-cancel">Eliminar</button>
                                    </td>
                                </tr>
                                <tr><!--
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Ana López</strong>
                                                <span>Habitación 205</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>11:15 AM</td>
                                    <td><span class="vital-reading">130/85</span></td>
                                    <td><span class="vital-reading">88 lpm</span></td>
                                    <td><span class="vital-reading high">39.2°C</span></td>
                                    <td><span class="vital-reading">20 rpm</span></td>
                                    <td><span class="vital-reading">95%</span></td>
                                    <td>
                                        <button class="btn-view">Editar</button>
                                        <button class="btn-cancel">Eliminar</button>
                                    </td>-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gráficos de Tendencia -->

                    <div class="info-card">
                        <h3><i class="fas fa-exclamation-circle"></i> Valores de Referencia</h3>
                        <div class="reference-values">
                            <div class="reference-item">
                                <strong>Presión Arterial</strong>
                                <span>Normal: 120/80 mmHg</span>
                                <span>Alerta: >140/90 mmHg</span>
                            </div>
                            <div class="reference-item">
                                <strong>Frecuencia Cardíaca</strong>
                                <span>Normal: 60-100 lpm</span>
                                <span>Alerta: <50 o >120 lpm</span>
                            </div>
                            <div class="reference-item">
                                <strong>Temperatura</strong>
                                <span>Normal: 36.5-37.5°C</span>
                                <span>Alerta: >38°C</span>
                            </div>
                        </div>
                    </div>
 
@endsection
@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/js/ENFERMERA/script-signos.js'])
@endsection