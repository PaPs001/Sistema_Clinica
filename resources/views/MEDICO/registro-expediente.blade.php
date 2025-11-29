@extends('plantillas.dashboard_medico')
@section('title', 'Registro de Expediente Medico - Clinica Ultima Asignatura')
@section('styles')
    @vite('resources/css/medic/paginas/registro-expediente.css')
@endsection
@section('content')
        <header class="content-header">
            <h1>Registro de Expediente Medico</h1>
            <!--<div class="header-actions">
                <div class="search-box">
                    <input type="text" placeholder="Buscar paciente...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
            </div>-->
        </header>
        
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-container">
                <form id="expedienteForm" class="medical-form" method="post" action="{{ route('save_medical_record') }}">
                    @csrf
                    
                    <div class="form-section">
                        <h3><i class="fas fa-calendar-check"></i> Datos de la Consulta</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fechaConsulta">Fecha de Consulta *</label>
                                <input type="datetime-local" id="fechaConsulta" name="fechaConsulta" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-user"></i> Informacion del Paciente</h3>
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
                                <label for="genero">Genero *</label>
                                <select id="genero" name="genero" required>
                                    <option value="">Seleccionar</option>
                                    <option value="hombre">Masculino</option>
                                    <option value="mujer">Femenino</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="tel" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrenico *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="direccion">Direccion</label>
                                <textarea id="direccion" name="direccion" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-user-check"></i> Hábitos y Necesidades Especiales</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="smoking_status">Tabaquismo</label>
                                <select id="smoking_status" name="smoking_status">
                                    <option value="">Seleccionar</option>
                                    <option value="actual">Actual</option>
                                    <option value="exfumador">Exfumador</option>
                                    <option value="nunca">Nunca</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alcohol_use">Consumo de alcohol</label>
                                <select id="alcohol_use" name="alcohol_use">
                                    <option value="">Seleccionar</option>
                                    <option value="ninguno">Ninguno</option>
                                    <option value="ocasional">Ocasional</option>
                                    <option value="frecuente">Frecuente</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="physical_activity">Actividad física</label>
                                <select id="physical_activity" name="physical_activity">
                                    <option value="">Seleccionar</option>
                                    <option value="sedentario">Sedentario</option>
                                    <option value="moderado">Moderado</option>
                                    <option value="activo">Activo</option>
                                </select>
                            </div>
                            <div class="form-group full-width">
                                <label for="special_needs">Necesidades especiales</label>
                                <textarea id="special_needs" name="special_needs" rows="2" placeholder="Discapacidad visual, auditiva, movilidad reducida, etc."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Signos Vitales -->
                    <div class="form-section">
                        <h3><i class="fas fa-heartbeat"></i> Signos Vitales</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="presionArterial">Presion Arterial</label>
                                <input type="text" id="presionArterial" name="presionArterial" placeholder="Ej: 120/80">
                            </div>
                            <div class="form-group">
                                <label for="frecuenciaCardiaca">Frecuencia Cardiaca</label>
                                <input type="number" id="frecuenciaCardiaca" name="frecuenciaCardiaca" placeholder="lpm">
                            </div>
                            <div class="form-group">
                                <label for="temperatura">Temperatura</label>
                                <input type="number" id="temperatura" name="temperatura" step="0.1" placeholder="C">
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

                    <!-- Antecedentes Medicos -->
                    <div class="form-section">
                        <h3><i class="fas fa-stethoscope"></i> Antecedentes Medicos</h3>
                        
                        <div class="medical-buttons-horizontal">
                            <div class="medical-button-item">
                                <h4><i class="fas fa-allergies"></i> Alergia</h4>
                                <button type="button" class="btn-primary" onclick="agregarAlergia()">
                                    <i class="fas fa-plus"></i> Agregar alergia
                                </button>
                            </div>

                            <div class="medical-button-item">
                                <h4><i class="fas fa-heartbeat"></i> Enfermedad cronica</h4>
                                <button type="button" class="btn-primary" onclick="agregarCronica()">
                                    <i class="fas fa-plus"></i> Agregar enfermedad cronica
                                </button>
                            </div>

                            <div class="medical-button-item">
                                <h4><i class="fas fa-pills"></i> Medicamento actual</h4>
                                <button type="button" class="btn-primary" onclick="agregarMedicamento()">
                                    <i class="fas fa-plus"></i> Agregar medicamento
                                </button>
                            </div>
                        </div>

                        <div id="contenedorAlergias"></div>
                        <div id="contenedorCronicas"></div>
                        <div id="contenedorMedicamentos"></div>

                        <template id="template-alergia">
                            @include('plantillas.formularios.form-alergia')
                        </template>

                        <template id="template-cronica">
                            @include('plantillas.formularios.form-enfermedades-cronicas')
                        </template>

                        <template id="template-medicamento">
                            @include('plantillas.formularios.form-medicamento-actual')
                        </template>
                    </div>

                    <!-- Consulta Actual -->
                    <div class="form-section">
                        <h3><i class="fas fa-notes-medical"></i> Consulta Actual</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="motivoConsulta">Motivo de Consulta *</label>
                                <input type="text" id="motivoConsulta" name="motivoConsulta" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="sintomas">Sintomas</label>
                                <textarea id="sintomas" name="sintomas" rows="3" placeholder="Describa los sontomas del paciente"></textarea>
                            </div>
                            <div class="form-group full-width">
                                <label for="exploracion">Exploracion Fisica</label>
                                <textarea id="exploracion" name="exploracion" rows="3" placeholder="Hallazgos en la exploracion fisica"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-diagnoses"></i> Diagnostico y Tratamiento</h3>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="diagnostico">Diagnostico *</label>
                                <input type="text" id="diagnostico" name="diagnostico" required autocomplete="off">
                                <div id="sugerencias-diagnosticos" class="sugerencias-lista-diagnosticos"></div>
                                <input type="hidden" id="diagnostico_id" name="diagnostico_id">
                            </div>
                            <div class="form-group full-width">
                                <label for="medication_search">Medicamentos a recetar</label>
                                <input type="text" id="medication_search" autocomplete="off" placeholder="Buscar medicamento por nombre, categoría o presentación">
                                <div id="sugerencias-medicamentos" class="sugerencias-lista"></div>
                                <input type="hidden" id="prescribed_medications" name="prescribed_medications">
                                <input type="hidden" id="prescribed_medications_ids" name="prescribed_medications_ids">
                                <div class="selected-medications" id="selected-medications"></div>
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
