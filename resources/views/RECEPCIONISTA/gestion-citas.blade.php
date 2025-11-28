@extends('plantillas.dashboard_recepcionista')
@section('title', 'Gestión de Citas - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Gestión de Citas</h1>
                <div class="header-actions">
                    <!--<div class="search-box">
                        <input type="text" placeholder="Buscar cita por paciente, médico o fecha..." aria-label="Buscar citas">
                        <i class="fas fa-search"></i>
                    </div>-->
                    <button class="section-btn" id="new-appointment-btn">
                        <i class="fas fa-plus"></i> Nueva Cita
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Filtros de Citas -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-filter"></i> Filtros de Citas
                    </h2>
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="date-filter">Fecha:</label>
                            <input type="date" id="date-filter">
                        </div>
                        <div class="filter-group">
                            <label for="doctor-filter">Médico:</label>
                            <select id="doctor-filter">
                                <option value="">Todos los médicos</option>
                                <option value="Dra. Elena Morales">Dra. Elena Morales</option>
                                <option value="Dr. Roberto Silva">Dr. Roberto Silva</option>
                                <option value="Dr. Carlos Mendoza">Dr. Carlos Mendoza</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="status-filter">Estado:</label>
                            <select id="status-filter">
                                <option value="">Todos los estados</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="en-consulta">En consulta</option>
                                <option value="completada">Completada</option>
                                <option value="cancelada">Cancelada</option>
                            </select>
                        </div>
                        <button class="section-btn" id="apply-filters">
                            <i class="fas fa-check"></i> Aplicar Filtros
                        </button>
                        <button class="section-btn btn-cancel" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Lista de Citas -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Lista de Citas
                        <div class="section-actions">
                            <!--<button class="section-btn" id="export-citas">
                                <i class="fas fa-download"></i> Exportar
                            </button>-->
                            <button class="section-btn" id="refresh-citas">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha y Hora</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Consultorio</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las citas se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Estadísticas de Citas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-citas-hoy">0</h3>
                            <p>Citas Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-confirmadas">0</h3>
                            <p>Confirmadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-agendadas">0</h3>
                            <p>Citas Agendadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-canceladas">0</h3>
                            <p>Canceladas</p>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal para Nueva Cita eliminado, se usará SweetAlert2 -->
@endsection
@section('scripts')
    @vite(['resources/js/RECEPCIONISTA/script-gestion-citas.js'])
@endsection