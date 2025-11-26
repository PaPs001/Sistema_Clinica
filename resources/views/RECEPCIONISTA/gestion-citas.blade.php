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
                                <tr>
                                    <td>
                                        <div class="time-slot">
                                            <strong>15 Nov, 08:30 AM</strong>
                                            <span>Hoy</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Carlos Ruiz</strong>
                                                <span>65 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dra. Elena Morales</td>
                                    <td>405</td>
                                    <td><span class="type-badge consulta">Consulta</span></td>
                                    <td><span class="status-badge confirmed">Confirmada</span></td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
                                        <button class="btn-cancel" aria-label="Cancelar cita">Cancelar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="time-slot">
                                            <strong>15 Nov, 09:15 AM</strong>
                                            <span>Hoy</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Ana López</strong>
                                                <span>42 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dr. Roberto Silva</td>
                                    <td>208</td>
                                    <td><span class="type-badge control">Control</span></td>
                                    <td><span class="status-badge in-progress">En consulta</span></td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
                                        <button class="btn-cancel" aria-label="Finalizar cita">Finalizar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="time-slot">
                                            <strong>15 Nov, 10:00 AM</strong>
                                            <span>Hoy</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Miguel Torres</strong>
                                                <span>38 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dra. Elena Morales</td>
                                    <td>405</td>
                                    <td><span class="type-badge emergencia">Urgencia</span></td>
                                    <td><span class="status-badge waiting">En espera</span></td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
                                        <button class="btn-cancel" aria-label="Cancelar cita">Cancelar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="time-slot">
                                            <strong>16 Nov, 11:30 AM</strong>
                                            <span>Mañana</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Laura García</strong>
                                                <span>29 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dr. Carlos Mendoza</td>
                                    <td>301</td>
                                    <td><span class="type-badge consulta">Consulta</span></td>
                                    <td><span class="status-badge confirmed">Confirmada</span></td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
                                        <button class="btn-cancel" aria-label="Cancelar cita">Cancelar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="time-slot">
                                            <strong>16 Nov, 02:15 PM</strong>
                                            <span>Mañana</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Juan Pérez</strong>
                                                <span>55 años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dra. Elena Morales</td>
                                    <td>405</td>
                                    <td><span class="type-badge control">Control</span></td>
                                    <td><span class="status-badge pending">Pendiente</span></td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
                                        <button class="btn-cancel" aria-label="Cancelar cita">Cancelar</button>
                                    </td>
                                </tr>
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
                            <h3>24</h3>
                            <p>Citas Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>18</h3>
                            <p>Confirmadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>En Espera</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <div class="stat-info">
                            <h3>2</h3>
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