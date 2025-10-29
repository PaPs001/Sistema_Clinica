@extends('plantillas.dashboard_paciente')
@section('title', 'Historial - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Mi Historial Médico</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar en historial...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Historial de Consultas -->
                <div class="history-section">
                    <h2><i class="fas fa-stethoscope"></i> Historial de Consultas</h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-date">15 Mar 2024</div>
                            <div class="timeline-content">
                                <h4>Consulta de Cardiología</h4>
                                <p><strong>Médico:</strong> Dr. Carlos Ruiz</p>
                                <p><strong>Diagnóstico:</strong> Control de hipertensión arterial</p>
                                <p><strong>Tratamiento:</strong> Ajuste de medicación - Losartán 50mg</p>
                                <p><strong>Notas:</strong> Presión arterial controlada, continuar tratamiento</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">28 Feb 2024</div>
                            <div class="timeline-content">
                                <h4>Consulta de Medicina General</h4>
                                <p><strong>Médico:</strong> Dra. Ana Martínez</p>
                                <p><strong>Diagnóstico:</strong> Control rutinario</p>
                                <p><strong>Tratamiento:</strong> Mantener Atorvastatina 20mg</p>
                                <p><strong>Notas:</strong> Exámenes de sangre dentro de parámetros normales</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">15 Ene 2024</div>
                            <div class="timeline-content">
                                <h4>Consulta de Cardiología</h4>
                                <p><strong>Médico:</strong> Dr. Carlos Ruiz</p>
                                <p><strong>Diagnóstico:</strong> Evaluación hipertensión</p>
                                <p><strong>Tratamiento:</strong> Iniciar Losartán 50mg</p>
                                <p><strong>Notas:</strong> Primera consulta por hipertensión diagnosticada</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exámenes y Procedimientos -->
                <div class="history-section">
                    <h2><i class="fas fa-vial"></i> Exámenes y Procedimientos</h2>
                    <div class="exams-grid">
                        <div class="exam-card">
                            <div class="exam-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="exam-info">
                                <h4>Electrocardiograma</h4>
                                <p><strong>Fecha:</strong> 10 Mar 2024</p>
                                <p><strong>Resultado:</strong> Normal</p>
                                <button class="btn-view">Ver Resultado</button>
                            </div>
                        </div>
                        <div class="exam-card">
                            <div class="exam-icon">
                                <i class="fas fa-flask"></i>
                            </div>
                            <div class="exam-info">
                                <h4>Análisis de Sangre</h4>
                                <p><strong>Fecha:</strong> 25 Feb 2024</p>
                                <p><strong>Resultado:</strong> Colesterol LDL: 110 mg/dL</p>
                                <button class="btn-view">Ver Resultado</button>
                            </div>
                        </div>
                        <div class="exam-card">
                            <div class="exam-icon">
                                <i class="fas fa-x-ray"></i>
                            </div>
                            <div class="exam-info">
                                <h4>Radiografía de Tórax</h4>
                                <p><strong>Fecha:</strong> 20 Ene 2024</p>
                                <p><strong>Resultado:</strong> Sin hallazgos relevantes</p>
                                <button class="btn-view">Ver Resultado</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medicamentos -->
                <div class="history-section">
                    <h2><i class="fas fa-pills"></i> Historial de Medicamentos</h2>
                    <div class="medications-timeline">
                        <div class="medication-record">
                            <div class="med-date">Mar 2024 - Actual</div>
                            <div class="med-details">
                                <h4>Losartán 50mg</h4>
                                <p><strong>Dosis:</strong> 1 tableta al día</p>
                                <p><strong>Para:</strong> Hipertensión arterial</p>
                                <p><strong>Estado:</strong> Activo</p>
                            </div>
                        </div>
                        <div class="medication-record">
                            <div class="med-date">Feb 2023 - Actual</div>
                            <div class="med-details">
                                <h4>Atorvastatina 20mg</h4>
                                <p><strong>Dosis:</strong> 1 tableta al día</p>
                                <p><strong>Para:</strong> Control de colesterol</p>
                                <p><strong>Estado:</strong> Activo</p>
                            </div>
                        </div>
                        <div class="medication-record">
                            <div class="med-date">Ene 2023 - Dic 2023</div>
                            <div class="med-details">
                                <h4>Omeprazol 20mg</h4>
                                <p><strong>Dosis:</strong> 1 tableta al día</p>
                                <p><strong>Para:</strong> Acidez estomacal</p>
                                <p><strong>Estado:</strong> Descontinuado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('scripts')
    @vite(['resources/js/PACIENTE/script-historial.js'])
@endsection