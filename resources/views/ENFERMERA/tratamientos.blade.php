@extends('plantillas.dashboard_enfermera')
@section('title', 'Gestión de Tratamientos - Hospital Naval')
@section('styles')
    @vite(['resources/css/ENFERMERA/paginas/style-tratamientos.css'])
@endsection
@section('content')
            <header class="content-header">
                <h1>Gestión de Tratamientos Médicos</h1>
                <!--<div class="header-actions">
                    <button class="btn-primary" id="nuevo-tratamiento-btn">
                        <i class="fas fa-plus"></i>
                        Nuevo Tratamiento
                    </button>
                </div>-->
            </header>

            <div class="content">
                <!-- Estadísticas Mejoradas -->
                    <div class="info-card">
                        <h3><i class="fas fa-chart-bar"></i> Resumen de Tratamientos</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <strong>Total</strong>
                                <span id="total-tratamientos">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Activos</strong>
                                <span id="tratamientos-activos">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Completados</strong>
                                <span id="tratamientos-completados">0</span>
                            </div>
                            <div class="detail-item">
                                <strong>Pacientes Activos</strong>
                                <span id="pacientes-activos">0</span>
                            </div>
                        </div>
                    </div>
                <!-- Filtros Mejorados -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filtrar por:</label>
                        <select id="filter-status" aria-label="Filtrar por estado">
                            <option value="todos">Todos los estados</option>
                            <option value="activo">Activos</option>
                            <option value="completado">Completados</option>
                            <option value="suspendido">Suspendidos</option>
                        </select>
                        <select id="filter-paciente" aria-label="Filtrar por paciente">
                            <option value="todos">Todos los pacientes</option>
                        </select>
                        <select id="filter-medico" aria-label="Filtrar por médico">
                            <option value="todos">Todos los médicos</option>
                        </select>
                        <button class="section-btn" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                </div>



                <!-- Lista de Tratamientos Mejorada -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Lista de Tratamientos
                        <div class="section-actions">
                            <button class="section-btn" id="refresh-list">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    <div class="patients-table">
                        <table id="tabla-tratamientos">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Diagnóstico</th>
                                    <th>Medicamento</th>
                                    <th>Estado</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-tratamientos">
                                <!-- Los tratamientos se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <!--<div class="quick-actions">
                    <h2>Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="{{ route('pacientesEnfermera') }}" class="action-card">
                            <i class="fas fa-user-injured"></i>
                            <span>Gestión de Pacientes</span>
                        </a>
                        <a href="{{ route('medicamentos') }}" class="action-card">
                            <i class="fas fa-pills"></i>
                            <span>Control de Medicamentos</span>
                        </a>
                        <a href="{{ route('signosVitales') }}" class="action-card">
                            <i class="fas fa-heartbeat"></i>
                            <span>Registrar Signos</span>
                        </a>
                    </div>
                </div>
            </div>-->

    <!-- Modal para Nuevo/Editar Tratamiento Mejorado -->
    <div class="modal-overlay" id="modal-tratamiento">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modal-titulo">Nuevo Tratamiento</h3>
                <button class="close-modal" aria-label="Cerrar modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-tratamiento">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="paciente">Paciente *</label>
                            <select id="paciente" required>
                                <option value="">Seleccionar paciente</option>
                                <option value="Carlos Ruiz">Carlos Ruiz</option>
                                <option value="Ana López">Ana López</option>
                                <option value="Miguel Torres">Miguel Torres</option>
                                <option value="Elena Morales">Elena Morales</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="medico">Médico Responsable</label>
                            <select id="medico">
                                <option value="Dr. Carlos Ruiz">Dr. Carlos Ruiz</option>
                                <option value="Dra. Ana Martínez">Dra. Ana Martínez</option>
                                <option value="Dr. Roberto Silva">Dr. Roberto Silva</option>
                                <option value="Dra. Elena Morales">Dra. Elena Morales</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="diagnostico">Diagnóstico *</label>
                        <textarea id="diagnostico" required placeholder="Describa el diagnóstico del paciente"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="medicamento">Medicamento *</label>
                            <select id="medicamento" required>
                                <option value="">Seleccionar medicamento</option>
                                <option value="Amoxicilina">Amoxicilina</option>
                                <option value="Losartán">Losartán</option>
                                <option value="Metformina">Metformina</option>
                                <option value="Ibuprofeno">Ibuprofeno</option>
                                <option value="Insulina">Insulina</option>
                                <option value="Atorvastatina">Atorvastatina</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dosis">Dosis *</label>
                            <input type="text" id="dosis" placeholder="Ej: 500mg" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="frecuencia">Frecuencia *</label>
                            <select id="frecuencia" required>
                                <option value="">Seleccione una frecuencia</option>
                                <option value="cada 6 horas">Cada 6 horas</option>
                                <option value="cada 8 horas">Cada 8 horas</option>
                                <option value="cada 12 horas">Cada 12 horas</option>
                                <option value="una vez al día">Una vez al día</option>
                                <option value="dos veces al día">Dos veces al día</option>
                                <option value="según necesidad">Según necesidad</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duracion">Duración (días) *</label>
                            <input type="number" id="duracion" min="1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado del Tratamiento</label>
                        <select id="estado">
                            <option value="activo">Activo</option>
                            <option value="completado">Completado</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="cancel-form">Cancelar</button>
                        <button type="submit" class="btn-primary">Guardar Tratamiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/js/ENFERMERA/script-tratamientos.js'])
@endsection
