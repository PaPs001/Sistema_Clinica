@extends('plantillas.dashboard_enfermera')
@section('title', 'Tratamientos Activos')

@section('styles')
    @vite([
        'resources/css/ENFERMERA/paginas/style-tratamientos.css',
        'resources/css/ENFERMERA/paginas/tratamientos-activos.css',
    ])
@endsection

@section('content')
<div class="content-header">
    <h1><i class="fas fa-pills"></i> Tratamientos Activos</h1>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>Pacientes con Tratamientos en Seguimiento</h3>
        </div>
        <div class="card-body">
            @if($patients->isEmpty())
                <div class="alert alert-info">
                    No hay pacientes con tratamientos activos en este momento.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Tratamiento</th>
                                <th>Inicio</th>
                                <th>Fin Programado</th>
                                <th>Médico</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                                @foreach($patient->patient->medicalRecords as $record)
                                    @foreach($record->treatmentRecords as $treatment)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle mr-2">{{ substr($patient->name, 0, 1) }}</div>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $patient->name }}</div>
                                                        <small class="text-muted">DNI: {{ $patient->patient->DNI }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $treatment->treatment->treatment_description ?? 'Tratamiento General' }}</strong>
                                                <br>
                                                <small>{{ Str::limit($treatment->notes, 50) }}</small>
                                            </td>
                                            <td>{{ $treatment->start_date->format('d/m/Y') }}</td>
                                            <td>
                                                @if($treatment->end_date)
                                                    {{ $treatment->end_date->format('d/m/Y') }}
                                                    <br>
                                                    <small class="{{ $treatment->end_date->isPast() ? 'text-danger' : 'text-success' }}">
                                                        ({{ $treatment->end_date->diffForHumans() }})
                                                    </small>
                                                @else
                                                    <span class="text-muted">Indefinido</span>
                                                @endif
                                            </td>
                                            <td>Dr. {{ $treatment->medicUser->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-success">En Seguimiento</span>
                                            </td>
                                            <td>
                                                <button class="btn-edit" onclick="openEditModal({{ $treatment->id }})" title="Editar tratamiento">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Edición de Tratamiento -->
<div class="modal-overlay" id="modal-edit-treatment">
    <div class="modal">
        <div class="modal-header">
            <h3>Editar Tratamiento</h3>
            <button class="close-modal" onclick="closeEditModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="form-edit-treatment">
                <input type="hidden" id="treatment-id">
                
                <div class="form-group">
                    <label>Paciente</label>
                    <input type="text" id="patient-name" readonly class="readonly-input">
                </div>

                <div class="form-group">
                    <label>Tratamiento</label>
                    <textarea id="treatment-description" readonly class="readonly-input" rows="2"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha de Inicio</label>
                        <input type="date" id="start-date" readonly class="readonly-input">
                    </div>
                    <div class="form-group">
                        <label>Médico</label>
                        <input type="text" id="prescribed-by" readonly class="readonly-input">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status">Estado *</label>
                        <select id="status" required>
                            <option value="En seguimiento">En Seguimiento</option>
                            <option value="Completado">Completado</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Fecha de Finalización</label>
                        <input type="date" id="end-date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notas Adicionales</label>
                    <textarea id="notes" rows="4" placeholder="Agregar observaciones sobre el tratamiento..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancelar</button>
                    <button type="submit" class="btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite('resources/js/ENFERMERA/tratamientos-activos.js')
@endsection
