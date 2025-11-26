@extends('plantillas.dashboard_recepcionista')
@section('title', 'Registro de Pacientes - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Registrar Nuevo Paciente</h1>
                <div class="header-actions">
                    <!--<div class="search-box">
                        <input type="text" placeholder="Buscar paciente existente..." aria-label="Buscar pacientes">
                        <i class="fas fa-search"></i>
                    </div>-->
                    <button class="section-btn" id="quick-registration-btn">
                        <i class="fas fa-bolt"></i> Registro Rápido
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Formulario de Registro -->
                <div class="registration-form">
                    <div class="form-header">
                        <h2>
                            <i class="fas fa-id-card"></i> Información Personal
                            <span class="form-step">Paso 1 de 3</span>
                        </h2>
                    </div>
                    
                    <form id="patient-registration-form" action="{{ route('registrar.paciente.store') }}" method="POST">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient-name">
                                    <i class="fas fa-user"></i> Nombre Completo *
                                </label>
                                <input type="text" id="patient-name" name="patient-name" required placeholder="Ej: María González López">
                            </div>
                            
                            <div class="form-group">
                                <label for="patient-email">
                                    <i class="fas fa-envelope"></i> Correo Electrónico
                                </label>
                                <input type="email" id="patient-email" name="patient-email" placeholder="ejemplo@correo.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="patient-phone">
                                    <i class="fas fa-phone"></i> Teléfono *
                                </label>
                                <input type="tel" id="patient-phone" name="patient-phone" required placeholder="555-123-4567">
                            </div>
                            
                            <div class="form-group">
                                <label for="patient-dob">
                                    <i class="fas fa-calendar"></i> Fecha de Nacimiento *
                                </label>
                                <input type="date" id="patient-dob" name="patient-dob" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="patient-gender">
                                    <i class="fas fa-venus-mars"></i> Género *
                                </label>
                                <select id="patient-gender" name="patient-gender" required>
                                    <option value="">Seleccionar género</option>
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                    <option value="O">Otro</option>
                                    <option value="N">Prefiero no decir</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="patient-id">
                                    <i class="fas fa-id-card"></i> Identificación *
                                </label>
                                <input type="text" id="patient-id" name="patient-id" required placeholder="DNI, CURP, etc.">
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="form-section">
                            <h3>
                                <i class="fas fa-address-book"></i> Información de Contacto
                                <span class="form-step">Paso 2 de 3</span>
                            </h3>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="patient-address">
                                        <i class="fas fa-home"></i> Dirección *
                                    </label>
                                    <input type="text" id="patient-address" name="patient-address" required placeholder="Calle, número, colonia">
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient-city">
                                        <i class="fas fa-city"></i> Ciudad *
                                    </label>
                                    <input type="text" id="patient-city" name="patient-city" required placeholder="Ciudad">
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient-state">
                                        <i class="fas fa-map-marker-alt"></i> Estado *
                                    </label>
                                    <input type="text" id="patient-state" name="patient-state" required placeholder="Estado">
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient-zip">
                                        <i class="fas fa-mail-bulk"></i> Código Postal *
                                    </label>
                                    <input type="text" id="patient-zip" name="patient-zip" required placeholder="Código Postal">
                                </div>
                            </div>
                        </div>

                        <!-- Información Médica -->
                        <div class="form-section">
                            <h3>
                                <i class="fas fa-heartbeat"></i> Información Médica
                                <span class="form-step">Paso 3 de 3</span>
                            </h3>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="patient-blood-type">
                                        <i class="fas fa-tint"></i> Tipo de Sangre
                                    </label>
                                    <select id="patient-blood-type" name="patient-blood-type">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient-allergies">
                                        <i class="fas fa-allergies"></i> Alergias
                                    </label>
                                    <input type="text" id="patient-allergies" name="patient-allergies" placeholder="Lista de alergias conocidas">
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient-medications">
                                        <i class="fas fa-pills"></i> Medicamentos Actuales
                                    </label>
                                    <input type="text" id="patient-medications" name="patient-medications" placeholder="Medicamentos que toma regularmente">
                                </div>
                                
                                <div class="form-group">
                                    <label for="patient-conditions">
                                        <i class="fas fa-file-medical"></i> Condiciones Médicas
                                    </label>
                                    <input type="text" id="patient-conditions" name="patient-conditions" placeholder="Enfermedades crónicas o condiciones">
                                </div>
                            </div>
                            
                            <div class="form-group full-width">
                                <label for="patient-notes">
                                    <i class="fas fa-sticky-note"></i> Notas Adicionales
                                </label>
                                <textarea id="patient-notes" name="patient-notes" rows="4" placeholder="Observaciones adicionales sobre el paciente..."></textarea>
                            </div>
                            
                            <div class="form-group full-width">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="patient-consent" name="patient-consent" required>
                                    <span class="checkmark"></span>
                                    El paciente ha dado su consentimiento para el tratamiento de sus datos personales según la política de privacidad *
                                </label>
                            </div>
                        </div>

                        <!-- Acciones del Formulario -->
                        <div class="form-actions">
                            <button type="button" class="section-btn btn-cancel" id="clear-form">
                                <i class="fas fa-eraser"></i> Limpiar Formulario
                            </button>
                            <button type="submit" class="section-btn" id="submit-patient">
                                <i class="fas fa-save"></i> Registrar Paciente
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Registros Recientes -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-history"></i> Registros Recientes
                        <div class="section-actions">
                            <!--<button class="section-btn" id="export-patients">
                                <i class="fas fa-download"></i> Exportar
                            </button>-->
                            <button class="section-btn" id="refresh-patients">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    
                    <div class="recent-patients-grid">
                        <div class="recent-patient-card">
                            <div class="patient-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="patient-details">
                                <h4>Carlos Ruiz Hernández</h4>
                                <p><i class="fas fa-phone"></i> 555-123-4567</p>
                                <p><i class="fas fa-envelope"></i> carlos.ruiz@email.com</p>
                                <p><i class="fas fa-calendar"></i> Registrado hoy, 08:30 AM</p>
                            </div>
                            <div class="patient-actions">
                                <button class="btn-view" aria-label="Ver detalles de Carlos Ruiz">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-cancel" aria-label="Editar Carlos Ruiz">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="recent-patient-card">
                            <div class="patient-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="patient-details">
                                <h4>Ana López García</h4>
                                <p><i class="fas fa-phone"></i> 555-987-6543</p>
                                <p><i class="fas fa-envelope"></i> ana.lopez@email.com</p>
                                <p><i class="fas fa-calendar"></i> Registrado ayer, 02:15 PM</p>
                            </div>
                            <div class="patient-actions">
                                <button class="btn-view" aria-label="Ver detalles de Ana López">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-cancel" aria-label="Editar Ana López">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="recent-patient-card">
                            <div class="patient-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="patient-details">
                                <h4>Miguel Torres Ramírez</h4>
                                <p><i class="fas fa-phone"></i> 555-456-7890</p>
                                <p><i class="fas fa-envelope"></i> miguel.torres@email.com</p>
                                <p><i class="fas fa-calendar"></i> Registrado hace 2 días, 10:45 AM</p>
                            </div>
                            <div class="patient-actions">
                                <button class="btn-view" aria-label="Ver detalles de Miguel Torres">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-cancel" aria-label="Editar Miguel Torres">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Registrados Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>48</h3>
                            <p>Esta Semana</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-info">
                            <h3>189</h3>
                            <p>Este Mes</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="stat-info">
                            <h3>2,847</h3>
                            <p>Total Registrados</p>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal de Registro Rápido -->
    <div class="modal-overlay" id="quick-registration-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Registro Rápido de Paciente</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="quick-registration-form">
                    <div class="form-group">
                        <label for="quick-name">Nombre Completo *</label>
                        <input type="text" id="quick-name" name="quick-name" required>
                    </div>
                    <div class="form-group">
                        <label for="quick-phone">Teléfono *</label>
                        <input type="tel" id="quick-phone" name="quick-phone" required>
                    </div>
                    <div class="form-group">
                        <label for="quick-dob">Fecha de Nacimiento</label>
                        <input type="date" id="quick-dob" name="quick-dob">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="section-btn">
                            <i class="fas fa-bolt"></i> Registrar Rápidamente
                        </button>
                        <button type="button" class="section-btn btn-cancel" id="cancel-quick-registration">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/RECEPCIONISTA/script-registro-paciente.js'])
@endsection