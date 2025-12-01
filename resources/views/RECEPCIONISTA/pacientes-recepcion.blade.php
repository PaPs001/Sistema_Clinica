@extends('plantillas.dashboard_recepcionista')
@section('title', 'Gestión de Pacientes - Hospital Naval')
@section('content')
            <form action="{{ route('pacientesRecepcionista') }}" method="GET" id="filter-form">
                <header class="content-header">
                    <h1>Gestión de Pacientes</h1>
                    <div class="header-actions">
                    </div>
                </header>

                <div class="content">
                    <!-- Filtros y Estadísticas -->
                    <div class="patients-controls">
                        <div class="filters-container">
                            <div class="filter-group">
                                <label for="status-filter">Estado:</label>
                                <select id="status-filter" name="status">
                                    <option value="">Todos los estados</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="date-filter">Fecha de Registro:</label>
                                <select id="date-filter" name="date">
                                    <option value="">Todas las fechas</option>
                                    <option value="hoy" {{ request('date') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                    <option value="semana" {{ request('date') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                                    <option value="mes" {{ request('date') == 'mes' ? 'selected' : '' }}>Este mes</option>
                                    <option value="anio" {{ request('date') == 'anio' ? 'selected' : '' }}>Este año</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="sort-by">Ordenar por:</label>
                                <select id="sort-by" name="sort">
                                    <option value="nombre_asc" {{ request('sort') == 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
                                    <option value="nombre_desc" {{ request('sort') == 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
                                    <option value="fecha_desc" {{ request('sort') == 'fecha_desc' ? 'selected' : '' }}>Más Reciente</option>
                                    <option value="fecha_asc" {{ request('sort') == 'fecha_asc' ? 'selected' : '' }}>Más Antiguo</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="section-btn" id="apply-filters">
                                <i class="fas fa-filter"></i> Aplicar
                            </button>
                            <a href="{{ route('pacientesRecepcionista') }}" class="section-btn btn-cancel" id="reset-filters" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-redo"></i> Limpiar
                            </a>
                        </div>
                    
                    <div class="patients-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $totalPatients }}</span>
                            <span class="stat-label">Total Pacientes</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $newPatientsWeek }}</span>
                            <span class="stat-label">Esta Semana</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $newPatientsToday }}</span>
                            <span class="stat-label">Hoy</span>
                        </div>
                    </div>
                </div>

                <!-- Lista de Pacientes -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-users"></i> Lista de Pacientes
                        <div class="section-actions">
                            
                        </div>
                    </h2>
                    
                    <div class="patients-table-container">
                        <table class="patients-table">
                            <thead>
                                <tr>
                                    <!--<th class="select-column">
                                        <input type="checkbox" id="select-all">
                                    </th>-->
                                    <th>Paciente</th>
                                    <th>Contacto</th>
                                    <th>Información</th>
                                    <th>Fecha de Registro</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                <tr class="patient-row" data-status="{{ $patient->status }}">
                                    <!--<td class="select-column">
                                        <input type="checkbox" class="patient-select" value="{{ $patient->id }}">
                                    </td>-->
                                    <td>
                                        <div class="patient-info-compact">
                                            <div class="patient-avatar {{ $patient->status == 'inactive' ? 'inactive' : '' }}">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="patient-details">
                                                <strong>{{ $patient->name }}</strong>
                                                <!--<span>ID: {{ $patient->id }}</span>-->
                                                <span>{{ \Carbon\Carbon::parse($patient->birthdate)->age }} años</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p><i class="fas fa-phone"></i> {{ $patient->phone }}</p>
                                            <p><i class="fas fa-envelope"></i> {{ $patient->email }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <p><i class="fas fa-tint"></i> {{ $patient->genre }}</p>
                                            <!-- Placeholders for data not in general_users -->
                                            <!--<p><i class="fas fa-allergies"></i> Sin alergias</p>-->
                                            <!--<p><i class="fas fa-file-medical"></i> Ninguna</p>-->
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-visit">
                                            <strong>{{ $patient->created_at->format('d M Y') }}</strong>
                                            <span>Registro</span>
                                            <!--<span class="visit-type consulta">Consulta</span>-->
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $patient->status == 'active' ? 'active' : 'inactive' }}">
                                            {{ ucfirst($patient->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            @hasPermission('gestionar_citas')
                                            <a href="{{ route('crearCita', [
                                                      'name' => $patient->name,
                                                      'phone' => $patient->phone,
                                                      'email' => $patient->email,
                                                      'patient_id' => $patient->id,
                                                ]) }}" class="btn-calendar" title="Agendar cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </a>
                                            @endhasPermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px;">No se encontraron pacientes.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="pagination">
                        @if ($patients->onFirstPage())
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @else
                            <a href="{{ $patients->previousPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($patients->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span class="pagination-ellipsis">{{ $element }}</span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $patients->currentPage())
                                        <button class="pagination-btn active">{{ $page }}</button>
                                    @else
                                        <a href="{{ $url }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($patients->hasMorePages())
                            <a href="{{ $patients->nextPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Resumen Rápido
                <div class="quick-summary">
                    <div class="summary-card">
                        <h3><i class="fas fa-chart-pie"></i> Distribución por Edad</h3>
                        <div class="age-distribution">
                            <div class="age-group">
                                <span class="age-range">0-18 años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 15%"></div>
                                </div>
                                <span class="age-percent">15%</span>
                            </div>
                            <div class="age-group">
                                <span class="age-range">19-35 años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 35%"></div>
                                </div>
                                <span class="age-percent">35%</span>
                            </div>
                            <div class="age-group">
                                <span class="age-range">36-55 años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 30%"></div>
                                </div>
                                <span class="age-percent">30%</span>
                            </div>
                            <div class="age-group">
                                <span class="age-range">56+ años</span>
                                <div class="age-bar">
                                    <div class="age-fill" style="width: 20%"></div>
                                </div>
                                <span class="age-percent">20%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <h3><i class="fas fa-heartbeat"></i> Condiciones Comunes</h3>
                        <div class="conditions-list">
                            <div class="condition-item">
                                <span class="condition-name">Hipertensión</span>
                                <span class="condition-count">423 pacientes</span>
                            </div>
                            <div class="condition-item">
                                <span class="condition-name">Diabetes</span>
                                <span class="condition-count">287 pacientes</span>
                            </div>
                            <div class="condition-item">
                                <span class="condition-name">Asma</span>
                                <span class="condition-count">156 pacientes</span>
                            </div>
                            <div class="condition-item">
                                <span class="condition-name">Artritis</span>
                                <span class="condition-count">134 pacientes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
-->
    <!-- Modal de Perfil de Paciente -->
    <div class="modal-overlay" id="patient-profile-modal">
        <div class="modal large-modal">
            <div class="modal-header">
                <h3>Perfil del Paciente</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="patient-profile">
                    <!-- Contenido se carga dinámicamente -->
                </div>
            </div>
        </div>
    </div>
@endsection
