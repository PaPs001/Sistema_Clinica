@extends('plantillas.dashboard_paciente')
@section('title', 'Dashboard Paciente - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>¡Hola {{ Auth::user()->name }}</h1>
                <div class="header-actions">
                    @include('partials.header-notifications')
                </div>
            </header>

           <!-- <div class="content">
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
                </div>-->

                <div class="recent-section">
                    <h2>
                        Próximas Citas
                        <div class="section-actions">
                            <button class="section-btn" id="filter-appointments">
                                <i class="fas fa-filter"></i> Filtrar
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
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody id="appointments-tbody">
                            </tbody>
                        </table>
                    </div>
                        <template id="cita-template">
                            <tr>
                                <td>
                                    <div class="appointment-info">
                                        <strong class="fecha"></strong>
                                        <span class="hora"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="doctor-info">
                                        <div class="doctor-avatar"><i class="fas fa-user-md"></i></div>
                                        <div>
                                            <strong class="doctor-nombre"></strong>
                                            <span class="doctor-servicio"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="doctor-especialidad"></td>
                                <td>
                                    <button class="btn-view">Ver Detalles</button>
                                    <button class="btn-cancel">Cancelar</button>
                                </td>
                            </tr>
                        </template>
                    <div id="paginationContainer-appointments"></div>
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
    @vite(['resources/js/PACIENTE/script-historial.js'])
@endsection