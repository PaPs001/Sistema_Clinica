@extends('plantillas.dashboard_recepcionista')
@section('title', 'Dashboard Recepcionista - Clínica "Ultima Asignatura"')
@section('content')
            <header class="content-header">
                <h1>¡Buenos días Ana!</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar paciente, cita o teléfono..." aria-label="Buscar en recepción">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications" role="button" aria-label="Ver notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">8</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $citasHoy }}</h3>
                            <p>Citas Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $nuevosPacientes }}</h3>
                            <p>Nuevos Pacientes</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $completadas }}</h3>
                            <p>Completadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $canceladas }}</h3>
                            <p>Canceladas</p>
                        </div>
                    </div>
                </div>

                <!-- Citas del Día -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-calendar-day"></i> Citas del Día
                        <div class="section-actions">
                            
                            <!--<button class="section-btn" id="export-schedule">
                                <i class="fas fa-download"></i> Exportar
                            </button>-->
                        </div>
                    </h2>
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Consultorio</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todaysAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="time-slot">
                                            <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</strong>
                                            <!--<span>Próxima</span>-->
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>
                                                    @if($appointment->patient && $appointment->patient->user)
                                                        {{ $appointment->patient->user->name }}
                                                    @elseif($appointment->patient && $appointment->patient->is_Temporary)
                                                        {{ $appointment->patient->temporary_name }}
                                                    @else
                                                        Desconocido
                                                    @endif
                                                </strong>
                                                <!--<span>65 años</span>-->
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($appointment->doctor && $appointment->doctor->user)
                                            {{ $appointment->doctor->user->name }}
                                        @else
                                            Por asignar
                                        @endif
                                    </td>
                                    <td>-</td> <!-- Consultorio not in DB yet -->
                                    <td><span class="type-badge consulta">{{ $appointment->reason }}</span></td>
                                    <td>
                                        @php
                                            $statusClass = match(strtolower($appointment->status)) {
                                                'confirmada' => 'confirmed',
                                                'en curso' => 'in-progress',
                                                'en consulta' => 'in-progress',
                                                'completada' => 'completed',
                                                'cancelada' => 'cancelled',
                                                'agendada' => 'waiting',
                                                default => 'pending'
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
                                    </td>
                                    <td>
                                        <!-- Actions can be added here, maybe link to management page -->
                                        <a href="{{ route('gestionCitas') }}" class="btn-view" aria-label="Gestionar cita">Gestionar</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center;">No hay citas programadas para hoy.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
              

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="{{ route('registroPaciente') }}" class="action-card">
                            <i class="fas fa-user-plus"></i>
                            <span>Nuevo Paciente</span>
                        </a>
                        <a href="{{ route('gestionCitas') }}" class="action-card">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Agendar Cita</span>
                        </a>
                        <a href="{{ route('pacientesRecepcionista') }}" class="action-card">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Ver Agenda</span>
                        </a>
                        <a href="{{ route('recordatorios') }}" class="action-card">
                            <i class="fas fa-bell"></i>
                            <span>Enviar Recordatorios</span>
                        </a>
                    </div>
                </div>
            </div>

    <!-- Modal de notificaciones -->
    <div class="modal-overlay" id="notifications-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Notificaciones de Recepción</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>3 pacientes nuevos esperando registro</li>
                    <li>Recordatorio: Llamar a Carlos Ruiz para confirmar cita</li>
                    <li>Miguel Torres lleva 15 minutos en espera</li>
                    <li>2 citas pendientes de confirmación para mañana</li>
                    <li>Nuevo paciente referido: Sofía Mendoza</li>
                    <li>Consultorio 208 con retraso de 10 minutos</li>
                    <li>Resultados de análisis listos para 3 pacientes</li>
                    <li>Recordatorio: Enviar confirmaciones de citas de la tarde</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
