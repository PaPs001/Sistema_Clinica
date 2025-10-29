@extends('plantillas.dashboard_paciente')
@section('title', 'Dashboard Paciente - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>¡Hola María!</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar en mis registros..." aria-label="Buscar en mis registros">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>2</h3>
                            <p>Citas Pendientes</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <div class="stat-info">
                            <h3>15</h3>
                            <p>Documentos Médicos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>Consultas Este Mes</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-prescription"></i>
                        </div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Medicamentos Activos</p>
                        </div>
                    </div>
                </div>

                <!-- Próximas Citas -->
                <div class="recent-section">
                    <h2>
                        Próximas Citas
                        <div class="section-actions">
                            <button class="section-btn" id="filter-appointments">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button class="section-btn" id="export-appointments">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                        </div>
                    </h2>
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha y Hora</th>
                                    <th>Médico</th>
                                    <th>Especialidad</th>
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="appointment-info">
                                            <strong>20 Mar 2024</strong>
                                            <span>10:30 AM</span>
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
                                    <td>Consultorio 304</td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita con Dr. Carlos Ruiz">Ver Detalles</button>
                                        <button class="btn-cancel" aria-label="Cancelar cita con Dr. Carlos Ruiz">Cancelar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="appointment-info">
                                            <strong>25 Mar 2024</strong>
                                            <span>03:15 PM</span>
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
                                    <td>Consultorio 201</td>
                                    <td>
                                        <button class="btn-view" aria-label="Ver detalles de cita con Dra. Ana Martínez">Ver Detalles</button>
                                        <button class="btn-cancel" aria-label="Cancelar cita con Dra. Ana Martínez">Cancelar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Información de Salud -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-heartbeat"></i> Información de Salud</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>Grupo Sanguíneo:</strong>
                                <span>O+</span>
                            </div>
                            <div class="info-item">
                                <strong>Alergias:</strong>
                                <span>Penicilina</span>
                            </div>
                            <div class="info-item">
                                <strong>Condiciones Crónicas:</strong>
                                <span>Hipertensión</span>
                            </div>
                            <div class="info-item">
                                <strong>Última Visita:</strong>
                                <span>15 Mar 2024</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fas fa-prescription"></i> Medicamentos Activos</h3>
                        <div class="medications-list">
                            <div class="medication-item">
                                <strong>Losartán</strong>
                                <span>50mg - 1 vez al día</span>
                                <small>Para hipertensión</small>
                            </div>
                            <div class="medication-item">
                                <strong>Atorvastatina</strong>
                                <span>20mg - 1 vez al día</span>
                                <small>Para colesterol</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="solicitar-cita.html" class="action-card">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Agendar Cita</span>
                        </a>
                        <a href="mi-historial.html" class="action-card">
                            <i class="fas fa-file-medical"></i>
                            <span>Ver Historial</span>
                        </a>
                        <a href="mis-documentos.html" class="action-card">
                            <i class="fas fa-download"></i>
                            <span>Descargar Documentos</span>
                        </a>
                        <a href="perfil-paciente.html" class="action-card">
                            <i class="fas fa-user-edit"></i>
                            <span>Actualizar Perfil</span>
                        </a>
                    </div>
                </div>
            </div>

    <!-- Modal de notificaciones -->
    <div class="modal-overlay" id="notifications-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Tus Notificaciones</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Recordatorio: Cita con Dr. Carlos Ruiz - 20 Mar 10:30 AM</li>
                    <li>Nuevo resultado de laboratorio disponible</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/PACIENTE/script-paciente.js'])
@endsection