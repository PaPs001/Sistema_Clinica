@extends('plantillas.dashboard_medico')
@section('title', 'Filtrar Expedientes - Hospital Naval')
@section('styles')
    @vite('resources/css/medic/paginas/filtrar_exp_medico.css')
@endsection
@section('content')
        <header class="content-header">
            <h1>Filtrar Expedientes Médicos</h1>
            <!--<div class="header-actions">
                <button class="btn-primary" onclick="exportarResultados()">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>-->
        </header>

        <div class="content">
            <div class="filters-panel">
                <h3><i class="fas fa-sliders-h"></i> Filtros de Búsqueda</h3>
                
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="diagnostico">Buscar por enfermedad: </label>
                        <input type="text" id="diagnostico" name="diagnostico" required autocomplete="off">
                        <div id="sugerencias-diagnosticos" class="sugerencias-lista-diagnosticos"></div>
                        <input type="hidden" id="diagnostico_id" name="diagnostico_id">
                    </div>

                    <!--<div class="filter-group">
                        <label for="filterAge">Rango de Edad</label>
                        <select id="filterAge">
                            <option value="">Todas las edades</option>
                            <option value="0-18">0-18 años</option>
                            <option value="19-35">19-35 años</option>
                            <option value="36-50">36-50 años</option>
                            <option value="51-65">51-65 años</option>
                            <option value="65+">65+ años</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="filterGender">Género</label>
                        <select id="filterGender">
                            <option value="">Todos</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="filterDateFrom">Fecha Desde</label>
                        <input type="date" id="filterDateFrom">
                    </div>

                    <div class="filter-group">
                        <label for="filterDateTo">Fecha Hasta</label>
                        <input type="date" id="filterDateTo">
                    </div>

                    <div class="filter-group">
                        <label for="filterStatus">Estado</label>
                        <select id="filterStatus">
                            <option value="">Todos</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="alta">Dado de Alta</option>
                        </select>
                    </div>-->
                </div>

                <div class="filter-actions">
                    <button class="btn-secondary" onclick="limpiarFiltros()">
                        <i class="fas fa-eraser"></i> Limpiar Filtros
                    </button>
                    @hasPermission('ver_expedientes')
                    <button id="btnBuscar" class="btn-primary">
                        <i class="fas fa-search"></i> Aplicar Filtros
                    </button>
                    @endhasPermission
                </div>
            </div>

            @hasPermission('ver_expedientes')
            <div class="results-section">
                <div class="results-header">
                    <h3>Resultados de la Búsqueda</h3>
                    <div class="results-count">
                        <span id="resultsCount">0</span> expedientes encontrados
                    </div>
                </div>

                <div class="patients-grid" id="patientsGrid">
                    <div class="mt-3 text-center">
                        <!-- Los resultados se cargarán aquí dinámicamente -->
                    </div>
                </div>

                <div class="pagination-container mt-3 text-center" id="paginationContainer">
                    <!-- Los controles de paginación se cargarán aquí -->
                </div>
            </div>
            @endhasPermission

                <!-- Estadísticas
                <div class="stats-cards">
                    <div class="stat-card-small">
                        <div class="stat-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-info">
                            <h4 id="statDiagnosis">0</h4>
                            <p>Diagnósticos diferentes</p>
                        </div>
                    </div>
                    <div class="stat-card-small">
                        <div class="stat-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="stat-info">
                            <h4 id="statAgeAvg">0</h4>
                            <p>Edad promedio</p>
                        </div>
                    </div>
                    <div class="stat-card-small">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h4 id="statRecent">0</h4>
                            <p>Últimos 30 días</p>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
@endsection
@section('scripts')
@vite(['resources/js/medic/script-filtrar-expedientes.js'])
@endsection