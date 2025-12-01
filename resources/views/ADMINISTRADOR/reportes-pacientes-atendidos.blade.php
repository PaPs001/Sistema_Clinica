@extends('plantillas.dashboard_administrador')
@section('title', 'Reporte Pacientes Atendidos')

@section('content')
    <header class="content-header">
        <h1><i class="fas fa-chart-bar"></i> Reporte de Pacientes Atendidos</h1>
    </header>

    <div class="content">
        <div class="recent-section">
            <h2><i class="fas fa-filter"></i> Filtros</h2>
            <form method="GET" action="{{ route('reportes.pacientesAtendidos') }}" class="filters-form">
                <div class="filters-grid">
                    <div class="filter-item">
                        <label for="desde">Desde</label>
                        <input type="date" id="desde" name="desde" value="{{ $filtros['desde'] ?? '' }}" class="filter-input">
                    </div>
                    <div class="filter-item">
                        <label for="hasta">Hasta</label>
                        <input type="date" id="hasta" name="hasta" value="{{ $filtros['hasta'] ?? '' }}" class="filter-input">
                    </div>
                    <div class="filter-item">
                        <label for="medic_id">Médico</label>
                        <select id="medic_id" name="medic_id" class="filter-select">
                            <option value="">Todos</option>
                            @foreach($medicos as $medic)
                                <option value="{{ $medic->id }}" {{ ($filtros['medic_id'] ?? '') == $medic->id ? 'selected' : '' }}>
                                    {{ $medic->user->name ?? ('Médico '.$medic->id) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-actions section-actions">
                        <button type="submit" class="section-btn">
                            <i class="fas fa-filter"></i> Aplicar filtros
                        </button>
                        <a href="{{ route('reportes.pacientesAtendidos') }}" class="section-btn" style="background-color: #6c757d; text-decoration: none; text-align: center;">
                            <i class="fas fa-eraser"></i> Limpiar filtros
                        </a>
                        @hasPermission('descargar_reportes')
                            <a href="{{ route('reportes.pacientesAtendidos.export', request()->query()) }}" class="section-btn">
                                <i class="fas fa-file-excel"></i> Exportar Excel
                            </a>
                        @endhasPermission
                    </div>
                </div>
            </form>
        </div>

        <div class="recent-section">
            <h2><i class="fas fa-list"></i> Pacientes atendidos</h2>
            <div class="appointments-table">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Recepcionista</th>
                            <th>Motivo</th>
                            <th>Diagnóstico</th>
                            <th>Medicamentos</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                            <tr>
                                <td>{{ $cita->appointment_date }}</td>
                                <td>{{ $cita->appointment_time }}</td>
                                <td>{{ optional($cita->patient)->display_name ?? 'N/A' }}</td>
                                <td>{{ $cita->doctor->user->name ?? 'N/A' }}</td>
                                <td>{{ optional($cita->receptionist->user)->name ?? 'N/A' }}</td>
                                <td>{{ $cita->reason }}</td>
                                <td>
                                    @foreach($cita->consultDiseases as $consult)
                                        <span class="badge badge-info">{{ optional($consult->disease)->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($cita->consultDiseases as $consult)
                                        @foreach($consult->medications as $medication)
                                            <span class="badge badge-success">{{ $medication->name }}</span>
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>{{ $cita->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No hay registros con los filtros seleccionados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container mt-3 text-center">
                {{ $citas->links('plantillas.pagination') }}
            </div>
        </div>
    </div>
@endsection
