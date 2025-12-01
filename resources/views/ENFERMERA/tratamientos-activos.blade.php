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
    <div class="filters-section">
        <div class="filter-group">
            <!--<label for="status-filter">Estado:</label>
            <select id="status-filter">
                <option value="todos">Todos los estados</option>
                <option value="En seguimiento">En seguimiento</option>
                <option value="Completado">Completado</option>
                <option value="suspendido">Suspendido</option>
            </select>-->

            <label for="medication-filter">Medicamento:</label>
            <input type="text" id="medication-filter" placeholder="Buscar por medicamento...">

            <button type="button" class="btn-primary" id="btn-clear-filters">
                <i class="fas fa-redo"></i> Limpiar
            </button>
        </div>
    </div>

    <div class="appointments-section">
        <h2>Pacientes con Tratamientos en Seguimiento</h2>
        <div class="appointments-table">
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Tratamiento</th>
                        <th>Medicamentos</th>
                        <th>Inicio</th>
                        <th>Fin Programado</th>
                        <th>Médico</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="treatments-tbody">
                    @forelse($patients as $patient)
                        @foreach($patient->patient->medicalRecords as $record)
                            @foreach($record->treatmentRecords as $treatment)
                                <tr class="treatment-row" data-status="{{ $treatment->status ?? 'En seguimiento' }}">
                                    <td>
                                        <div class="doctor-info">
                                            <div class="doctor-avatar">
                                                <i class="fas fa-user-injured"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $patient->name }}</strong>
                                                <span>DNI: {{ $patient->patient->DNI }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $treatment->treatment->treatment_description ?? 'Tratamiento General' }}</strong>
                                        <br>
                                        <small>{{ Str::limit($treatment->notes, 60) }}</small>
                                    </td>
                                    <td class="treatment-medications">
                                        @php
                                            $hasMeds = false;
                                        @endphp
                                        
                                        @foreach($record->consultDiseases as $consult)
                                            @if($consult->medications->isNotEmpty())
                                                @php $hasMeds = true; @endphp
                                                <ul style="padding-left: 15px; margin: 0; font-size: 0.85rem;">
                                                    @foreach($consult->medications as $med)
                                                        <li>{{ $med->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach

                                        @if(!$hasMeds)
                                            <span class="medications-placeholder">—</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($treatment->start_date)->format('d/m/Y') }}</td>
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
                                    <td>Dr. {{ $treatment->medicUser->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ $treatment->status ?? 'En seguimiento' }}</span>
                                    </td>
                                    <td>
                                        <button class="btn-edit" onclick="openEditModal({{ $treatment->id }})" title="Editar tratamiento">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:20px;">No hay pacientes con tratamientos activos en este momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                    <textarea id="treatment-description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Medicamentos Recetados</label>
                    <div class="medications-container">
                        <div class="med-search-box">
                            <input type="text" id="medication-search" placeholder="Buscar medicamento para agregar..." autocomplete="off">
                            <div id="med-search-results" class="search-results"></div>
                        </div>
                        <div id="medications-list" class="medications-list">
                            <!-- Medications will be added here dynamically -->
                        </div>
                    </div>
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
