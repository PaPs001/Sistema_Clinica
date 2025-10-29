@extends('plantillas.dashboard_paciente')
@section('title', 'Mi Perfil - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Mi Perfil</h1>
                <div class="header-actions">
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Información Personal -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2><i class="fas fa-user-circle"></i> Información Personal</h2>
                        <button class="btn-edit" id="edit-personal">
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                    </div>
                    <div class="profile-content">
                        <div class="avatar-section">
                            <div class="avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <button class="btn-change-avatar">Cambiar Foto</button>
                        </div>
                        <div class="info-grid">
                            <div class="info-group">
                                <label>Nombre Completo</label>
                                <p class="info-value">María González Rodríguez</p>
                            </div>
                            <div class="info-group">
                                <label>Fecha de Nacimiento</label>
                                <p class="info-value">15 de Agosto de 1985</p>
                            </div>
                            <div class="info-group">
                                <label>Género</label>
                                <p class="info-value">Femenino</p>
                            </div>
                            <div class="info-group">
                                <label>DNI</label>
                                <p class="info-value">12345678A</p>
                            </div>
                            <div class="info-group">
                                <label>Teléfono</label>
                                <p class="info-value">+34 612 345 678</p>
                            </div>
                            <div class="info-group">
                                <label>Correo Electrónico</label>
                                <p class="info-value">maria.gonzalez@email.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Médica -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2><i class="fas fa-heartbeat"></i> Información Médica</h2>
                        <button class="btn-edit" id="edit-medical">
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                    </div>
                    <div class="profile-content">
                        <div class="info-grid medical-info">
                            <div class="info-group">
                                <label>Grupo Sanguíneo</label>
                                <p class="info-value">O+</p>
                            </div>
                            <div class="info-group">
                                <label>Peso</label>
                                <p class="info-value">65 kg</p>
                            </div>
                            <div class="info-group">
                                <label>Altura</label>
                                <p class="info-value">165 cm</p>
                            </div>
                            <div class="info-group">
                                <label>Alergias Conocidas</label>
                                <p class="info-value">Penicilina, Mariscos</p>
                            </div>
                            <div class="info-group">
                                <label>Condiciones Crónicas</label>
                                <p class="info-value">Hipertensión, Hipercolesterolemia</p>
                            </div>
                            <div class="info-group">
                                <label>Médico de Cabecera</label>
                                <p class="info-value">Dra. Ana Martínez</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacto de Emergencia -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2><i class="fas fa-address-book"></i> Contacto de Emergencia</h2>
                        <button class="btn-edit" id="edit-emergency">
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                    </div>
                    <div class="profile-content">
                        <div class="emergency-contacts">
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div class="contact-info">
                                    <h4>Juan González</h4>
                                    <p><strong>Parentesco:</strong> Esposo</p>
                                    <p><strong>Teléfono:</strong> +34 623 456 789</p>
                                    <p><strong>Correo:</strong> juan.gonzalez@email.com</p>
                                </div>
                            </div>
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="contact-info">
                                    <h4>Laura González</h4>
                                    <p><strong>Parentesco:</strong> Hija</p>
                                    <p><strong>Teléfono:</strong> +34 634 567 890</p>
                                    <p><strong>Correo:</strong> laura.gonzalez@email.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración de Cuenta -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2><i class="fas fa-cog"></i> Configuración de Cuenta</h2>
                    </div>
                    <div class="profile-content">
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Notificaciones por Correo</h4>
                                    <p>Recibir recordatorios de citas y resultados</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Notificaciones por SMS</h4>
                                    <p>Recibir alertas importantes por mensaje de texto</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Compartir Datos con Médicos</h4>
                                    <p>Permitir acceso a mi historial médico completo</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="account-actions">
                            <button class="btn-change-password">
                                <i class="fas fa-key"></i>
                                Cambiar Contraseña
                            </button>
                            <button class="btn-delete-account">
                                <i class="fas fa-trash"></i>
                                Eliminar Cuenta
                            </button>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal Editar Información -->
    <div class="modal-overlay" id="edit-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modal-title">Editar Información</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <!-- Los campos del formulario se cargarán dinámicamente -->
                    <div id="form-fields"></div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel">Cancelar</button>
                        <button type="submit" class="btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/PACIENTE/script-perfil.js'])
@endsection