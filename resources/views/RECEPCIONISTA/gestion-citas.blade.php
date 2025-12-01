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
                    @hasPermission('gestionar_citas')
                    <button class="section-btn" id="new-appointment-btn">
                        <i class="fas fa-plus"></i> Nueva Cita
                    </button>
                    @endhasPermission
                </div>
            </header>

            <div class="content">
                <!-- Filtros de Citas -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-filter"></i> Filtros de Citas
                    </h2>
                    <form action="{{ route('gestionCitas') }}" method="GET" class="filters-container">
                        <div class="filter-group">
                            <label for="date-filter">Fechas:</label>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input
                                    type="date"
                                    id="date-filter"
                                    name="date_from"
                                    value="{{ request('date_from') }}"
                                >
                                <span style="font-size: 0.85rem; color: #666;">a</span>
                                <input
                                    type="date"
                                    id="date-filter-to"
                                    name="date_to"
                                    value="{{ request('date_to') }}"
                                >
                            </div>
                        </div>
                        <div class="filter-group">
                            <label for="doctor-filter">Médico:</label>
                            <select id="doctor-filter" name="doctor_id">
                                <option value="">Todos los médicos</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="status-filter">Estado:</label>
                            <select id="status-filter" name="status">
                                <option value="">Todos los estados</option>
                                <option value="Confirmada" {{ request('status') == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="agendada" {{ request('status') == 'agendada' ? 'selected' : '' }}>Agendada</option>
                                <option value="En curso" {{ request('status') == 'En curso' ? 'selected' : '' }}>En consulta</option>
                                <option value="completada" {{ request('status') == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="Sin confirmar" {{ request('status') == 'Sin confirmar' ? 'selected' : '' }}>Sin confirmar</option>
                            </select>
                        </div>
                        <button type="submit" class="section-btn" id="apply-filters">
                            <i class="fas fa-check"></i> Aplicar Filtros
                        </button>
                        <a href="{{ route('gestionCitas') }}" class="section-btn btn-cancel" id="reset-filters" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-redo"></i> Limpiar
                        </a>
                        
                        <!-- Buscador con Typeahead -->
                        <div class="search-box-container" style="margin-left: auto; position: relative;">
                            <div class="search-box" style="display: flex; align-items: center; background: #f0f2f5; border-radius: 20px; padding: 5px 15px; border: 1px solid #ddd;">
                                <input type="text" id="appointment-search" name="search" value="{{ request('search') }}" placeholder="Buscar por paciente..." autocomplete="off" style="border: none; background: transparent; outline: none; padding: 5px; width: 250px;">
                                <button type="submit" style="border: none; background: none; cursor: pointer; color: #666;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div id="search-suggestions" style="position: absolute; top: 100%; left: 0; width: 100%; background: white; border: 1px solid #ddd; border-radius: 0 0 10px 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                                <!-- Suggestions will be populated here -->
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Lista de Citas -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Lista de Citas
                        <div class="section-actions">
                            <!--<button class="section-btn" id="export-citas">
                                <i class="fas fa-download"></i> Exportar
                            </button>-->
                            <a href="{{ route('gestionCitas') }}" class="section-btn" id="refresh-citas" style="text-decoration: none;">
                                <i class="fas fa-sync"></i> Actualizar
                            </a>
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
                                @forelse($appointments as $appointment)
                                    @php
                                        $patientName = 'Desconocido';
                                        if ($appointment->patient) {
                                            if ($appointment->patient->is_Temporary) {
                                                $patientName = $appointment->patient->temporary_name;
                                            } elseif ($appointment->patient->user) {
                                                $patientName = $appointment->patient->user->name;
                                            }
                                        }

                                        $doctorName = 'Por asignar';
                                        if ($appointment->doctor && $appointment->doctor->user) {
                                            $doctorName = $appointment->doctor->user->name;
                                        }

                                        $statusClass = match($appointment->status) {
                                            'agendada' => 'pending',
                                            'Confirmada' => 'confirmed',
                                            'completada' => 'completed',
                                            'cancelada' => 'canceled',
                                            'En curso' => 'in-progress',
                                            'Sin confirmar' => 'pending',
                                            default => 'pending'
                                        };
                                        
                                        $statusText = match($appointment->status) {
                                            'agendada' => 'Agendada',
                                            'Confirmada' => 'Confirmada',
                                            'completada' => 'Completada',
                                            'cancelada' => 'Cancelada',
                                            'En curso' => 'En Consulta',
                                            'Sin confirmar' => 'Sin confirmar',
                                            default => $appointment->status
                                        };
                                    @endphp
                                    <tr data-id="{{ $appointment->id }}">
                                        <td>
                                            <div class="time-slot">
                                                <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time)->format('d M, H:i') }}</strong>
                                                <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->isToday() ? 'Hoy' : (\Carbon\Carbon::parse($appointment->appointment_date)->isTomorrow() ? 'Mañana' : 'Próxima') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-avatar">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $patientName }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $doctorName }}</td>
                                        <td>Por asignar</td>
                                        <td><span class="type-badge {{ strtolower($appointment->reason) }}">{{ ucfirst($appointment->reason) }}</span></td>
                                        <td><span class="status-badge {{ $statusClass }}">{{ $statusText }}</span></td>
                                        <td>
                                            <div style="display: flex; gap: 5px;">
                                                <button class="btn-view" aria-label="Ver detalles de cita">Detalles</button>
                                                @hasPermission('gestionar_citas')
                                                <button class="section-btn btn-status" style="background-color: #ffc107; color: #000; padding: 5px 10px; font-size: 0.8rem;" aria-label="Cambiar estado" {{ $appointment->status == 'cancelada' ? 'disabled' : '' }}>Estado</button>
                                                <button class="btn-cancel" aria-label="Cancelar cita" {{ in_array($appointment->status, ['cancelada', 'completada']) ? 'disabled' : '' }}>
                                                    {{ $appointment->status == 'cancelada' ? 'Cancelada' : ($appointment->status == 'completada' ? 'Completada' : 'Cancelar') }}
                                                </button>
                                                @endhasPermission
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 20px;">No se encontraron citas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="pagination">
                        @if ($appointments->onFirstPage())
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @else
                            <a href="{{ $appointments->previousPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($appointments->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span class="pagination-ellipsis">{{ $element }}</span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $appointments->currentPage())
                                        <button class="pagination-btn active">{{ $page }}</button>
                                    @else
                                        <a href="{{ $url }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($appointments->hasMorePages())
                            <a href="{{ $appointments->nextPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Estadísticas de Citas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-citas-hoy">{{ $stats['today'] }}</h3>
                            <p>Citas Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-confirmadas">{{ $stats['confirmed'] }}</h3>
                            <p>Confirmadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-agendadas">{{ $stats['scheduled'] }}</h3>
                            <p>Citas Agendadas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="stat-canceladas">{{ $stats['cancelled'] }}</h3>
                            <p>Canceladas</p>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal para Nueva Cita eliminado, se usará SweetAlert2 -->
@endsection
@section('scripts')
    @vite(['resources/js/RECEPCIONISTA/script-gestion-citas.js'])
    @if($appointments->isEmpty() && (request('date_from') || request('date_to') || request('doctor_id') || request('status') || request('search')))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof showToast === 'function') {
                    showToast('No se encontraron citas con los criterios seleccionados', 'warning');
                }
            });
        </script>
    @endif
@endsection
