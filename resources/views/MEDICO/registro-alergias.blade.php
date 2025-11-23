@extends('plantillas.dashboard_general')
@section('title', 'Registro alergias Médico - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Registro de Antecedentes medicos</h1>
            </header>

            <div class="content">
                <div class="registration-section">
                    <div class="form-container">
                        <form id="alergiaForm" class="medical-form" method="post" action="{{ route('agregar_Alergia') }}">
                            <h3><i class="fas fa-plus-circle"></i> Registrar Nueva Alergia</h3>
                            @csrf 
                            <div>
                                <div>
                                    <button type="button" class="btn-primary" onclick="agregarAlergia()">Agregar otra alergia</button>
                                    <button type="button" class="btn-primary" onclick="agregarCronica()">Agregar otra enfermedad crónica</button>
                                </div>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Nombre Paciente *</label>
                                    <input type="text" class="nombre-paciente" name="nombre" required autocomplete="off">
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
                                    <h3><i class="fas fa-heartbeat"></i> Registrar Enfermedad Crónica</h3>

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

                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save"></i> Registrar Alergia
                                </button>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>    
@endsection
@section('scripts')
@vite(['resources/js/medic/script-agregar-alergias.js'])
@endsection