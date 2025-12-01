@extends('plantillas.dashboard_recepcionista')
@section('title', 'Dashboard Recepcionista - Clínica "Ultima Asignatura"')
@section('content')
            <header class="content-header">
                <h1>¡Buenos días Ana!</h1>
                <div class="header-actions">
                   
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
                                    <td>-</td> 
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
                                        @hasPermission('editar_citas')
                                        <a href="{{ route('gestionCitas') }}" class="btn-view" aria-label="Gestionar cita">Gestionar</a>
                                        @endhasPermission
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
                    
                    <!-- Paginación -->
                    <div class="pagination">
                        @if ($todaysAppointments->onFirstPage())
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @else
                            <a href="{{ $todaysAppointments->previousPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($todaysAppointments->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span class="pagination-ellipsis">{{ $element }}</span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $todaysAppointments->currentPage())
                                        <button class="pagination-btn active">{{ $page }}</button>
                                    @else
                                        <a href="{{ $url }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($todaysAppointments->hasMorePages())
                            <a href="{{ $todaysAppointments->nextPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
              

                <!-- Acciones Rápidas -->
                <div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        @hasPermission('registrar_pacientes')
                        <a href="{{ route('registroPaciente') }}" class="action-card">
                            <i class="fas fa-user-plus"></i>
                            <span>Nuevo Paciente</span>
                        </a>
                        @endhasPermission
                        
                        @hasPermission('gestionar_citas')
                        <a href="{{ route('gestionCitas') }}" class="action-card">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Agendar Cita</span>
                        </a>
                        @endhasPermission
                        
                        @hasPermission('ver_pacientes')
                        <a href="{{ route('pacientesRecepcionista') }}" class="action-card">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Ver Agenda</span>
                        </a>
                        @endhasPermission
                        
                        @hasPermission('gestionar_citas')
                        <a href="{{ route('recordatorios') }}" class="action-card">
                            <i class="fas fa-bell"></i>
                            <span>Enviar Recordatorios</span>
                        </a>
                        @endhasPermission
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
