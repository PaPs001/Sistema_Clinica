@extends('plantillas.dashboard_paciente')
@section('title', 'Mis Citas - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Mis Citas Médicas</h1>
                <div class="header-actions">
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Filtros -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filtrar por:</label>
                        <select id="filter-status">
                            <option value="all">Todas las citas</option>
                            <option value="pending">Pendientes</option>
                            <option value="confirmed">Confirmadas</option>
                            <option value="completed">Completadas</option>
                            <option value="cancelled">Canceladas</option>
                        </select>
                        <select id="filter-specialty">
                            <option value="all">Todas las especialidades</option>
                            <option value="cardiology">Cardiología</option>
                            <option value="general">Medicina General</option>
                            <option value="dermatology">Dermatología</option>
                        </select>
                    </div>
                </div>

                <!-- Citas Pendientes -->
                <div class="appointments-section">
                    <h2><i class="fas fa-clock"></i> Citas Pendientes</h2>
                    <div class="appointments-grid">
                        <div class="appointment-card pending">
                            <div class="appointment-header">
                                <h3>Dr. Carlos Ruiz</h3>
                                <span class="status-badge confirmed">Confirmada</span>
                            </div>
                            <div class="appointment-details">
                                <p><i class="fas fa-calendar"></i> <strong>20 Mar 2024 - 10:30 AM</strong></p>
                                <p><i class="fas fa-stethoscope"></i> Cardiología</p>
                                <p><i class="fas fa-map-marker-alt"></i> Consultorio 304</p>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn-view">Ver Detalles</button>
                                <button class="btn-cancel">Cancelar Cita</button>
                                <button class="btn-reschedule">Reprogramar</button>
                            </div>
                        </div>

                        <div class="appointment-card pending">
                            <div class="appointment-header">
                                <h3>Dra. Ana Martínez</h3>
                                <span class="status-badge confirmed">Confirmada</span>
                            </div>
                            <div class="appointment-details">
                                <p><i class="fas fa-calendar"></i> <strong>25 Mar 2024 - 03:15 PM</strong></p>
                                <p><i class="fas fa-stethoscope"></i> Medicina General</p>
                                <p><i class="fas fa-map-marker-alt"></i> Consultorio 201</p>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn-view">Ver Detalles</button>
                                <button class="btn-cancel">Cancelar Cita</button>
                                <button class="btn-reschedule">Reprogramar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Historial de Citas -->
                <div class="appointments-section">
                    <h2><i class="fas fa-history"></i> Historial de Citas</h2>
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Médico</th>
                                    <th>Especialidad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="completed">
                                    <td>
                                        <div class="appointment-info">
                                            <strong>15 Mar 2024</strong>
                                            <span>10:00 AM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="doctor-info">
                                            <div class="doctor-avatar">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                <strong>Dr. Carlos Ruiz</strong>
                                                <span>Cardiólogo</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Cardiología</td>
                                    <td><span class="status-badge completed">Completada</span></td>
                                    <td>
                                        <button class="btn-view">Ver Detalles</button>
                                        <button class="btn-download">Descargar</button>
                                    </td>
                                </tr>
                                <tr class="completed">
                                    <td>
                                        <div class="appointment-info">
                                            <strong>28 Feb 2024</strong>
                                            <span>02:30 PM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="doctor-info">
                                            <div class="doctor-avatar">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div>
                                                <strong>Dra. Ana Martínez</strong>
                                                <span>Medicina General</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Medicina General</td>
                                    <td><span class="status-badge completed">Completada</span></td>
                                    <td>
                                        <button class="btn-view">Ver Detalles</button>
                                        <button class="btn-download">Descargar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    <!-- Modal Nueva Cita -->
    <div class="modal-overlay" id="nueva-cita-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Agendar Nueva Cita</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="nueva-cita-form">
                    <div class="form-group">
                        <label>Especialidad:</label>
                        <select required>
                            <option value="">Seleccionar especialidad</option>
                            <option value="cardiology">Cardiología</option>
                            <option value="general">Medicina General</option>
                            <option value="dermatology">Dermatología</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Médico:</label>
                        <select required>
                            <option value="">Seleccionar médico</option>
                            <option value="1">Dr. Carlos Ruiz - Cardiología</option>
                            <option value="2">Dra. Ana Martínez - Medicina General</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha:</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Hora:</label>
                        <select required>
                            <option value="">Seleccionar hora</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Motivo de la consulta:</label>
                        <textarea rows="3" placeholder="Describa el motivo de su consulta..."></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel">Cancelar</button>
                        <button type="submit" class="btn-primary">Agendar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/PACIENTE/script-citas.js'])
@endsection