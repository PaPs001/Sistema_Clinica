@extends('MEDICO.plantillas.dashboard_general')
@section('title', 'Consulta Historial - Hospital Naval')
@section('content')
        <!-- Main Content -->
        <div class="main-content">
            <header class="content-header">
                <h1>Consulta de Historial Médico</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchPatient" placeholder="Buscar por nombre o ID...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Panel de Búsqueda -->
                <div class="search-panel">
                    <div class="search-filters">
                        <div class="filter-group">
                            <label for="filterDate">Filtrar por fecha:</label>
                            <input type="date" id="filterDate">
                        </div>
                        <div class="filter-group">
                            <label for="filterDiagnosis">Filtrar por diagnóstico:</label>
                            <select id="filterDiagnosis">
                                <option value="">Todos los diagnósticos</option>
                                <option value="hipertension">Hipertensión</option>
                                <option value="diabetes">Diabetes</option>
                                <option value="infeccion">Infección</option>
                            </select>
                        </div>
                        <button class="btn-primary" onclick="buscarPacientes()">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Resultados -->
                <div class="results-section">
                    <h2>Resultados de Búsqueda</h2>
                    
                    <!-- Información del Paciente Seleccionado -->
                    <div class="patient-info-card" id="patientInfo" style="display: none;">
                        <div class="patient-header">
                            <div class="patient-avatar-large">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="patient-details">
                                <h3 id="patientName">Nombre del Paciente</h3>
                                <div class="patient-meta">
                                    <span id="patientAge">Edad</span> • 
                                    <span id="patientGender">Género</span> • 
                                    <span id="patientId">ID</span>
                                </div>
                            </div>
                        </div>
                        <div class="patient-summary">
                            <div class="summary-item">
                                <strong>Alergias:</strong>
                                <span id="patientAllergies">Ninguna registrada</span>
                            </div>
                            <div class="summary-item">
                                <strong>Enfermedades Crónicas:</strong>
                                <span id="patientChronic">Ninguna registrada</span>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Consultas -->
                    <div class="consultation-history">
                        <h3>Historial de Consultas</h3>
                        <div class="timeline">
                            <!-- Consulta 1 -->
                            <div class="timeline-item">
                                <div class="timeline-date">15 Mar 2024 - 10:30 AM</div>
                                <div class="timeline-content">
                                    <h4>Consulta de Seguimiento</h4>
                                    <div class="consultation-details">
                                        <p><strong>Motivo:</strong> Control de presión arterial</p>
                                        <p><strong>Diagnóstico:</strong> Hipertensión controlada</p>
                                        <p><strong>Tratamiento:</strong> Continuar con Losartán 50mg</p>
                                        <p><strong>Signos Vitales:</strong> PA: 125/80, FC: 72 lpm</p>
                                    </div>
                                    <div class="consultation-actions">
                                        <button class="btn-view" onclick="verConsultaCompleta(1)">Ver Completo</button>
                                        <button class="btn-edit" onclick="editarConsulta(1)">Editar</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Consulta 2 -->
                            <div class="timeline-item">
                                <div class="timeline-date">01 Mar 2024 - 09:15 AM</div>
                                <div class="timeline-content">
                                    <h4>Consulta Inicial</h4>
                                    <div class="consultation-details">
                                        <p><strong>Motivo:</strong> Evaluación de presión alta</p>
                                        <p><strong>Diagnóstico:</strong> Hipertensión arterial</p>
                                        <p><strong>Tratamiento:</strong> Iniciar Losartán 50mg diario</p>
                                        <p><strong>Signos Vitales:</strong> PA: 145/95, FC: 78 lpm</p>
                                    </div>
                                    <div class="consultation-actions">
                                        <button class="btn-view" onclick="verConsultaCompleta(2)">Ver Completo</button>
                                        <button class="btn-edit" onclick="editarConsulta(2)">Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentos Adjuntos -->
                    <div class="attached-documents">
                        <h3>Documentos Adjuntos</h3>
                        <div class="documents-grid">
                            <div class="document-card">
                                <i class="fas fa-file-pdf"></i>
                                <div class="document-info">
                                    <strong>Radiografía Torax.pdf</strong>
                                    <span>15 Mar 2024 - 250 KB</span>
                                </div>
                                <button class="btn-view" onclick="verDocumento(1)">Ver</button>
                            </div>
                            <div class="document-card">
                                <i class="fas fa-file-image"></i>
                                <div class="document-info">
                                    <strong>Analisis Sangre.jpg</strong>
                                    <span>01 Mar 2024 - 180 KB</span>
                                </div>
                                <button class="btn-view" onclick="verDocumento(2)">Ver</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')

    <script src="script-medico.js"></script>
    <script>
        // Script específico para consulta de historial
        function buscarPacientes() {
            const searchTerm = document.getElementById('searchPatient').value;
            const filterDate = document.getElementById('filterDate').value;
            const filterDiagnosis = document.getElementById('filterDiagnosis').value;
            
            // Simular búsqueda
            console.log('Buscando:', { searchTerm, filterDate, filterDiagnosis });
            
            // Mostrar información del paciente (simulado)
            document.getElementById('patientInfo').style.display = 'block';
            document.getElementById('patientName').textContent = 'María González';
            document.getElementById('patientAge').textContent = '35 años';
            document.getElementById('patientGender').textContent = 'Femenino';
            document.getElementById('patientId').textContent = 'ID: MG-001';
            document.getElementById('patientAllergies').textContent = 'Penicilina';
            document.getElementById('patientChronic').textContent = 'Hipertensión';
        }

        function verConsultaCompleta(consultaId) {
            alert(`Mostrando consulta completa #${consultaId}`);
            // Aquí se abriría un modal con toda la información
        }

        function editarConsulta(consultaId) {
            if (confirm('¿Estás seguro de que quieres editar esta consulta?')) {
                alert(`Editando consulta #${consultaId}`);
                // Redirigir a edición
            }
        }

        function verDocumento(documentoId) {
            alert(`Abriendo documento #${documentoId}`);
            // Aquí se abriría el documento en una nueva pestaña o visor
        }

        // Búsqueda en tiempo real
        document.getElementById('searchPatient').addEventListener('input', function(e) {
            if (e.target.value.length >= 3) {
                buscarPacientes();
            }
        });
    </script>
@endsection