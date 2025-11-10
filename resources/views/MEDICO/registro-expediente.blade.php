@extends('plantillas.dashboard_general')
@section('title', 'Registro de Expediente Médico - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Registro de Expediente Médico</h1>
                <!--<div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar paciente...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>-->
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
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaNacimiento">Fecha de Nacimiento *</label>
                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género *</label>
                        <select id="genero" name="genero" required>
                            <option value="">Seleccionar</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otro">Otro</option>
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

            <!-- Antecedentes Médicos -->
            <div class="form-section">
                <h3><i class="fas fa-stethoscope"></i> Antecedentes Médicos</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="alergias">Alergias</label>
                        <input type="text" id="alergias" name="alergias" placeholder="Ej: Penicilina, Mariscos">
                    </div>
                    <div class="form-group">
                        <label for="alergeno">Alergeno específico</label>
                        <input type="text" id="alergeno" name="alergeno" placeholder="Ej: Polen, Gluten, Mariscos">
                    </div>
                    <div class="form-group">
                        <label for="severidad_alergia">Severidad</label>
                        <select id="severidad_alergia" name="severidad_alergia">
                            <option value="">Seleccionar</option>
                            <option value="Leve">Leve</option>
                            <option value="Moderada">Moderada</option>
                            <option value="Grave">Grave</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_alergia">Estado</label>
                        <select id="status_alergia" name="status_alergia">
                            <option value="">Seleccionar</option>
                            <option value="Activa">Activa</option>
                            <option value="Inactiva">Inactiva</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label for="sintomas_alergia">Síntomas de la alergia</label>
                        <textarea id="sintomas_alergia" name="sintomas_alergia" rows="2" placeholder="Ej: Picazón, dificultad para respirar..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="tratamiento_alergias">Tratamiento para la alergia</label>
                        <textarea id="tratamiento_alergias" name="tratamiento_alergias" rows="2" placeholder="Ej: Antihistamínicos, evitar el alérgeno"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="notas">Notas adicionales</label>
                        <textarea id="notas" name="notas" rows="2" placeholder="Comentarios o información relevante"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="enfermedadesCronicas">Enfermedades Crónicas</label>
                        <input type="text" id="enfermedadesCronicas" name="enfermedadesCronicas" placeholder="Ej: Diabetes, Hipertensión">
                    </div>
                    <!--<div class="form-group">
                        <label for="medicamentos">Medicamentos Actuales</label>
                        <input type="text" id="medicamentos" name="medicamentos" placeholder="Ej: Metformina 500mg">
                    </div>
                    <div class="form-group">
                        <label for="cirugiasPrevias">Cirugías Previas</label>
                        <input type="text" id="cirugiasPrevias" name="cirugiasPrevias" placeholder="Ej: Apendicectomía 2010">
                    </div>-->
                </div>
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
                        <textarea id="diagnostico" name="diagnostico" rows="3" required placeholder="Diagnóstico principal"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="tratamiento">Tratamiento Indicado</label>
                        <textarea id="tratamiento" name="tratamiento" rows="3" placeholder="Medicamentos, dosis y recomendaciones"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="proximaCita">Próxima Cita</label>
                        <input type="datetime-local" id="proximaCita" name="proximaCita">
                    </div>
                </div>
            </div>

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
  <!--  <script src="script-medico.js"></script>
    <script>
        // Script específico para registro de expedientes
        document.getElementById('expedienteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validarFormulario()) {
                guardarExpediente();
            }
        });

        function validarFormulario() {
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#ff4757';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e1e5e9';
                }
            });

            return isValid;
        }

        function guardarExpediente() {
            const formData = new FormData(document.getElementById('expedienteForm'));
            const expediente = Object.fromEntries(formData);
            
            // Simular guardado en base de datos
            console.log('Expediente a guardar:', expediente);
            
            // Mostrar confirmación
            alert('¡Expediente guardado exitosamente!');
            limpiarFormulario();
            
            // Redirigir al dashboard después de 2 segundos
            setTimeout(() => {
                window.location.href = 'dashboard-medico.html';
            }, 2000);
        }

        function limpiarFormulario() {
            document.getElementById('expedienteForm').reset();
            // Limpiar estilos de validación
            const fields = document.querySelectorAll('input, textarea, select');
            fields.forEach(field => {
                field.style.borderColor = '#e1e5e9';
            });
        }

        // Calcular edad automáticamente
        document.getElementById('fechaNacimiento').addEventListener('change', function() {
            const fechaNacimiento = new Date(this.value);
            const hoy = new Date();
            const edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            
            // Actualizar algún campo si es necesario
            console.log('Edad calculada:', edad);
        });
    </script>-->    
@endsection