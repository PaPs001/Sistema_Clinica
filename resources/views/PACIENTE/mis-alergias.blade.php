@extends('plantillas.dashboard_paciente')
@section('title', 'Mis Alergias - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Mis Alergias y Condiciones</h1>
                <div class="header-actions">
                    <button class="btn-primary" id="nueva-alergia">
                        <i class="fas fa-plus"></i>
                        Agregar Alergia
                    </button>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Resumen de Alergias -->
                <div class="allergy-summary">
                    <div class="summary-card critical">
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="summary-info">
                            <h3>1</h3>
                            <p>Alergias Críticas</p>
                        </div>
                    </div>
                    <div class="summary-card moderate">
                        <div class="summary-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="summary-info">
                            <h3>2</h3>
                            <p>Alergias Moderadas</p>
                        </div>
                    </div>
                    <div class="summary-card mild">
                        <div class="summary-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="summary-info">
                            <h3>1</h3>
                            <p>Alergias Leves</p>
                        </div>
                    </div>
                </div>

                <!-- Lista de Alergias -->
                <div class="allergies-section">
                    <h2><i class="fas fa-list"></i> Mis Alergias Registradas</h2>
                    <div class="allergies-list">
                        <div class="allergy-card critical">
                            <div class="allergy-header">
                                <h3>Penicilina</h3>
                                <span class="severity-badge critical">Crítica</span>
                            </div>
                            <div class="allergy-details">
                                <p><strong>Tipo:</strong> Medicamento</p>
                                <p><strong>Diagnosticada:</strong> 2018</p>
                                <p><strong>Reacción:</strong> Anafilaxia</p>
                                <p><strong>Síntomas:</strong> Dificultad respiratoria, hinchazón, urticaria</p>
                                <p><strong>Tratamiento:</strong> Evitar completamente, epinefrina en emergencias</p>
                            </div>
                            <div class="allergy-actions">
                                <button class="btn-edit"><i class="fas fa-edit"></i> Editar</button>
                                <button class="btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                            </div>
                        </div>

                        <div class="allergy-card moderate">
                            <div class="allergy-header">
                                <h3>Mariscos</h3>
                                <span class="severity-badge moderate">Moderada</span>
                            </div>
                            <div class="allergy-details">
                                <p><strong>Tipo:</strong> Alimento</p>
                                <p><strong>Diagnosticada:</strong> 2015</p>
                                <p><strong>Reacción:</strong> Digestiva y cutánea</p>
                                <p><strong>Síntomas:</strong> Náuseas, vómitos, erupción cutánea</p>
                                <p><strong>Tratamiento:</strong> Antihistamínicos, evitar consumo</p>
                            </div>
                            <div class="allergy-actions">
                                <button class="btn-edit"><i class="fas fa-edit"></i> Editar</button>
                                <button class="btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                            </div>
                        </div>

                        <div class="allergy-card moderate">
                            <div class="allergy-header">
                                <h3>Polvo Doméstico</h3>
                                <span class="severity-badge moderate">Moderada</span>
                            </div>
                            <div class="allergy-details">
                                <p><strong>Tipo:</strong> Ambiental</p>
                                <p><strong>Diagnosticada:</strong> 2010</p>
                                <p><strong>Reacción:</strong> Respiratoria</p>
                                <p><strong>Síntomas:</strong> Estornudos, congestión nasal, picor ocular</p>
                                <p><strong>Tratamiento:</strong> Antihistamínicos, limpieza frecuente</p>
                            </div>
                            <div class="allergy-actions">
                                <button class="btn-edit"><i class="fas fa-edit"></i> Editar</button>
                                <button class="btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                            </div>
                        </div>

                        <div class="allergy-card mild">
                            <div class="allergy-header">
                                <h3>Látex</h3>
                                <span class="severity-badge mild">Leve</span>
                            </div>
                            <div class="allergy-details">
                                <p><strong>Tipo:</strong> Material</p>
                                <p><strong>Diagnosticada:</strong> 2019</p>
                                <p><strong>Reacción:</strong> Dermatitis de contacto</p>
                                <p><strong>Síntomas:</strong> Enrojecimiento, picor localizado</p>
                                <p><strong>Tratamiento:</strong> Evitar contacto, cremas tópicas</p>
                            </div>
                            <div class="allergy-actions">
                                <button class="btn-edit"><i class="fas fa-edit"></i> Editar</button>
                                <button class="btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Condiciones Médicas -->
                <div class="conditions-section">
                    <h2><i class="fas fa-heartbeat"></i> Condiciones Médicas</h2>
                    <div class="conditions-list">
                        <div class="condition-card">
                            <div class="condition-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="condition-info">
                                <h4>Hipertensión Arterial</h4>
                                <p><strong>Diagnosticada:</strong> 2020</p>
                                <p><strong>Tratamiento:</strong> Losartán 50mg diario</p>
                                <p><strong>Control:</strong> Estable con medicación</p>
                            </div>
                            <div class="condition-status">
                                <span class="status active">Activa</span>
                            </div>
                        </div>

                        <div class="condition-card">
                            <div class="condition-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="condition-info">
                                <h4>Hipercolesterolemia</h4>
                                <p><strong>Diagnosticada:</strong> 2019</p>
                                <p><strong>Tratamiento:</strong> Atorvastatina 20mg diario</p>
                                <p><strong>Control:</strong> Bien controlada</p>
                            </div>
                            <div class="condition-status">
                                <span class="status active">Activa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal Nueva Alergia -->
    <div class="modal-overlay" id="nueva-alergia-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Registrar Nueva Alergia</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="nueva-alergia-form">
                    <div class="form-group">
                        <label>Alergeno:</label>
                        <input type="text" placeholder="Ej: Penicilina, Mariscos, Polvo..." required>
                    </div>
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select required>
                            <option value="">Seleccionar tipo</option>
                            <option value="medication">Medicamento</option>
                            <option value="food">Alimento</option>
                            <option value="environmental">Ambiental</option>
                            <option value="material">Material</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gravedad:</label>
                        <select required>
                            <option value="">Seleccionar gravedad</option>
                            <option value="critical">Crítica</option>
                            <option value="moderate">Moderada</option>
                            <option value="mild">Leve</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha de diagnóstico:</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Síntomas:</label>
                        <textarea rows="3" placeholder="Describa los síntomas que experimenta..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tratamiento/Recomendaciones:</label>
                        <textarea rows="3" placeholder="Describa el tratamiento o medidas a tomar..."></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel">Cancelar</button>
                        <button type="submit" class="btn-primary">Guardar Alergia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts') 
    @vite(['resources/js/PACIENTE/script-alergias.js'])
@endsection