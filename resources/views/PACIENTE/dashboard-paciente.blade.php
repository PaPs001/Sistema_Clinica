@extends('plantillas.dashboard_paciente')
@section('title', 'Dashboard Paciente - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Hola {{ $user->name }}</h1>
                <div class="header-actions">
                    @include('partials.header-notifications')
                </div>
            </header>

            <div class="content">
                <div class="recent-section">
                    <h2>
                        Próximas Citas
                        <div class="section-actions">
                            <div class="filters-inline">
                                <select id="filterDoctor">
                                    <option value="">Todos los médicos</option>
                                    @foreach($medics as $medic)
                                        <option value="{{ $medic->id }}">{{ $medic->user->name ?? 'Médico' }}</option>
                                    @endforeach
                                </select>
                                <input type="date" id="filterDate">
                            </div>
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
                                <strong>Edad:</strong>
                                <span>
                                    @php
                                        $birth = $user->birthdate ? \Carbon\Carbon::parse($user->birthdate) : null;
                                    @endphp
                                    {{ $birth ? $birth->age . ' años' : 'No registrado' }}
                                </span>
                            </div>
                            <div class="info-item">
                                <strong>Teléfono:</strong>
                                <span>{{ $user->phone ?? 'No registrado' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Dirección:</strong>
                                <span>{{ $user->address ?? 'No registrada' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Última consulta:</strong>
                                <span>
                                    @if($lastAppointment)
                                        {{ \Carbon\Carbon::parse($lastAppointment->appointment_date)->format('d/m/Y') }}
                                    @else
                                        Sin consultas registradas
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fas fa-prescription"></i> Medicamentos / Tratamientos Activos</h3>
                        <div class="medications-list" id="active-treatments"></div>
                        <template id="tratamiento-activo-template">
                            <div class="medication-item">
                                <strong class="tratamiento-nombre"></strong>
                                <span class="tratamiento-detalle"></span>
                                <small class="tratamiento-fecha"></small>
                            </div>
                        </template>
                        <div id="paginationContainer-treatments"></div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="{{ route('historialPaciente') }}" class="action-card">
                            <i class="fas fa-file-medical"></i>
                            <span>Ver Historial</span>
                        </a>
                        <a href="{{ route('documentosPaciente') }}" class="action-card">
                            <i class="fas fa-download"></i>
                            <span>Mis Documentos</span>
                        </a>
                        <a href="{{ route('perfilPaciente') }}" class="action-card">
                            <i class="fas fa-user-edit"></i>
                            <span>Mi Perfil</span>
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
