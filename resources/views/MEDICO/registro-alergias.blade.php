@extends('plantillas.dashboard_medico')
@section('title', 'Registro alergias Médico - Hospital Naval')
@section('styles')
    @vite('resources/css/medic/paginas/registro_alergias_medico.css')
@endsection
@section('content')
        <header class="content-header">
            <h1>Registro de Antecedentes Médicos</h1>
        </header>

        <div class="content">
            <div class="registration-section">
                <div class="form-container">
                    <form id="alergiaForm" class="medical-form" method="post" action="{{ route('agregar_Alergia') }}">
                        <h3><i class="fas fa-plus-circle"></i> Registrar Nueva Alergia</h3>
                        @csrf 
                        
                        <div style="margin-bottom: 25px;">
                            @hasPermission('crear_expedientes')
                            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <button type="button" class="btn-primary" onclick="agregarAlergia()">
                                    <i class="fas fa-plus"></i> Agregar otra alergia
                                </button>
                                <button type="button" class="btn-primary" onclick="agregarCronica()">
                                    <i class="fas fa-heartbeat"></i> Agregar enfermedad crónica
                                </button>
                            </div>
                            @endhasPermission
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre-paciente">Nombre Paciente *</label>
                                <input type="text" id="nombre-paciente" class="nombre-paciente" name="nombre" required autocomplete="off">
                                <div class="sugerencias-lista sugerencias-pacientes"></div>
                                <input type="hidden" class="paciente_id" name="paciente_id">
                            </div>
                            
                            <div class="form-group">
                                <template id="template-alergia">
                                    @include('plantillas.formularios.form-alergia')
                                </template>
                            </div>

                            <div id="contenedorAlergias"></div>

                            <div class="form-group">
                                <h3><i class="fas fa-heartbeat"></i> Enfermedades Crónicas</h3>
                                <template id="template-cronica">
                                    @include('plantillas.formularios.form-enfermedades-cronicas')
                                </template>
                                <div id="contenedorCronicas"></div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="limpiarFormulario()">
                                <i class="fas fa-eraser"></i> Limpiar
                            </button>
                            @hasPermission('crear_expedientes')
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Registrar Alergia
                            </button>
                            @endhasPermission
                        </div>
                    </form>
                </div>  
            </div>
        </div>
@endsection

@section('scripts')
@vite(['resources/js/medic/script-agregar-alergias.js'])
@endsection