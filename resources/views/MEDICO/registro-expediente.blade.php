@extends('plantillas.dashboard_general')
@section('title', 'Registro de Expediente Médico - Hospital Naval')

@section('styles')
@vite(['resources/css/medic/registro-expediente.css'])
@endsection

@section('content')
<header class="content-header">
    <h1>Registro de Expediente Médico</h1>
</header>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="content">
    <div class="form-container">
        <form id="expedienteForm" class="medical-form" method="post" action="{{ route('save_medical_record') }}">
            @csrf
            
            <!-- Información del Paciente -->
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Información del Paciente</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre" required autocomplete="off">
                        <div id="sugerencias-pacientes" class="sugerencias-lista"></div>
                        <input type="hidden" id="paciente_id" name="paciente_id">
                    </div>
                    <div class="form-group">
                        <label for="fechaNacimiento">Fecha de Nacimiento *</label>
                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género *</label>
                        <select id="genero" name="genero" required>
                            <option value="">Seleccionar</option>
                            <option value="hombre">Masculino</option>
                            <option value="mujer">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="direccion">Dirección</label>
                        <textarea id="direccion" name="direccion" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <!-- Signos Vitales -->
            <div class="form-section">
                <h3><i class="fas fa-heartbeat"></i> Signos Vitales</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="presionArterial">Presión Arterial</label>
                        <input type="text" id="presionArterial" name="presionArterial" placeholder="Ej: 120/80">
                    </div>
                    <div class="form-group">
                        <label for="frecuenciaCardiaca">Frecuencia Cardíaca</label>
                        <input type="number" id="frecuenciaCardiaca" name="frecuenciaCardiaca" placeholder="lpm">
                    </div>
                    <div class="form-group">
                        <label for="temperatura">Temperatura</label>
                        <input type="number" id="temperatura" name="temperatura" step="0.1" placeholder="°C">
                    </div>
                    <div class="form-group">
                        <label for="peso">Peso</label>
                        <input type="number" id="peso" name="peso" step="0.1" placeholder="kg">
                    </div>
                    <div class="form-group">
                        <label for="estatura">Estatura</label>
                        <input type="number" id="estatura" name="estatura" step="0.1" placeholder="cm">
                    </div>
                </div>
            </div>

            <!-- Antecedentes Médicos - ESTRUCTURA HORIZONTAL CORRECTA -->
            <div class="form-section">
                <h3><i class="fas fa-stethoscope"></i> Antecedentes Médicos</h3>
                
                <!-- CONTENEDOR HORIZONTAL PARA BOTONES -->
                <div class="medical-buttons-horizontal">
                    <div class="medical-button-item">
                        <h4><i class="fas fa-allergies"></i> Alergia</h4>
                        <button type="button" class="btn-primary" onclick="agregarAlergia()">
                            <i class="fas fa-plus"></i> Agregar alergia
                        </button>
                    </div>

                    <div class="medical-button-item">
                        <h4><i class="fas fa-heartbeat"></i> Enfermedad crónica</h4>
                        <button type="button" class="btn-primary" onclick="agregarCronica()">
                            <i class="fas fa-plus"></i> Agregar enfermedad crónica
                        </button>
                    </div>
                </div>

                <!-- CONTENEDORES DE FORMULARIOS DINÁMICOS (aparecerán aquí) -->
                <div id="contenedorAlergias"></div>
                <div id="contenedorCronicas"></div>

                <!-- TEMPLATES (ocultos hasta que se usen) -->
                <template id="template-alergia">
                    @include('plantillas.formularios.form-alergia')
                </template>

                <template id="template-cronica">
                    @include('plantillas.formularios.form-enfermedades-cronicas')
                </template>
            </div>

            <!-- Consulta Actual -->
            <div class="form-section">
                <h3><i class="fas fa-notes-medical"></i> Consulta Actual</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="fechaConsulta">Fecha de Consulta *</label>
                        <input type="datetime-local" id="fechaConsulta" name="fechaConsulta" required>
                    </div>
                    <div class="form-group">
                        <label for="motivoConsulta">Motivo de Consulta *</label>
                        <input type="text" id="motivoConsulta" name="motivoConsulta" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="sintomas">Síntomas</label>
                        <textarea id="sintomas" name="sintomas" rows="3" placeholder="Describa los síntomas del paciente"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="exploracion">Exploración Física</label>
                        <textarea id="exploracion" name="exploracion" rows="3" placeholder="Hallazgos en la exploración física"></textarea>
                    </div>
                </div>
            </div>

            <!-- Diagnóstico y Tratamiento -->
            <div class="form-section">
                <h3><i class="fas fa-diagnoses"></i> Diagnóstico y Tratamiento</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="diagnostico">Diagnóstico *</label>
                        <input type="text" id="diagnostico" name="diagnostico" required autocomplete="off">
                        <div id="sugerencias-diagnosticos" class="sugerencias-lista-diagnosticos"></div>
                        <input type="hidden" id="diagnostico_id" name="diagnostico_id">
                    </div>
                    <div class="form-group full-width">
                        <label for="tratamiento">Tratamiento Indicado</label>
                        <textarea id="tratamiento" name="tratamiento" rows="3" placeholder="Medicamentos, dosis y recomendaciones"></textarea>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="limpiarFormulario()">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar Expediente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 

@section('scripts')
@vite(['resources/js/medic/script-medico.js'])
@endsection