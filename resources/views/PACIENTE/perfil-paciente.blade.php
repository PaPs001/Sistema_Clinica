@extends('plantillas.dashboard_paciente')
@section('title', 'Mi Perfil - Hospital Naval')
@section('content')
    @php
        $user = Auth::user();
        $patient = $user->patient;
        $lastVitals = $patient?->vitalSigns()->orderByDesc('created_at')->first();
        $birth = $user->birthdate ? \Carbon\Carbon::parse($user->birthdate) : null;
    @endphp
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
                                <p class="info-value">{{ $user->name }}</p>
                            </div>
                            <div class="info-group">
                                <label>Fecha de Nacimiento</label>
                                <p class="info-value">
                                    @if($birth)
                                        {{ $birth->format('d/m/Y') }} ({{ $birth->age }} años)
                                    @else
                                        No registrada
                                    @endif
                                </p>
                            </div>
                            <div class="info-group">
                                <label>Género</label>
                                <p class="info-value">
                                    @if($user->genre === 'M')
                                        Masculino
                                    @elseif($user->genre === 'F')
                                        Femenino
                                    @else
                                        No especificado
                                    @endif
                                </p>
                            </div>
                            <div class="info-group">
                                <label>DNI</label>
                                <p class="info-value">{{ $patient->DNI ?? 'No registrado' }}</p>
                            </div>
                            <div class="info-group">
                                <label>Teléfono</label>
                                <p class="info-value">{{ $user->phone ?? 'No registrado' }}</p>
                            </div>
                            <div class="info-group">
                                <label>Correo Electrónico</label>
                                <p class="info-value">{{ $user->email }}</p>
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
                                <p class="info-value">No registrado</p>
                            </div>
                            <div class="info-group">
                                <label>Peso</label>
                                <p class="info-value">
                                    @if($lastVitals && $lastVitals->weight)
                                        {{ $lastVitals->weight }} kg
                                    @else
                                        No registrado
                                    @endif
                                </p>
                            </div>
                            <div class="info-group">
                                <label>Altura</label>
                                <p class="info-value">
                                    @if($lastVitals && $lastVitals->height)
                                        {{ $lastVitals->height }} cm
                                    @else
                                        No registrada
                                    @endif
                                </p>
                            </div>
                            <div class="info-group">
                                <label>Alergias Conocidas</label>
                                <p class="info-value">No registradas en el sistema</p>
                            </div>
                            <div class="info-group">
                                <label>Condiciones Crónicas</label>
                                <p class="info-value">No registradas en el sistema</p>
                            </div>
                            <div class="info-group">
                                <label>Médico de Cabecera</label>
                                <p class="info-value">No asignado</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacto de Emergencia
                <div class="profile-section">
                    <div class="section-header">
                        <h2><i class="fas fa-phone-alt"></i> Contacto de Emergencia</h2>
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
                                    <h4>Contacto 1</h4>
                                    <p><strong>Parentesco:</strong> No registrado</p>
                                    <p><strong>Teléfono:</strong> No registrado</p>
                                    <p><strong>Correo:</strong> No registrado</p>
                                </div>
                            </div>
                            <div class="contact-card">
                                <div class="contact-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="contact-info">
                                    <h4>Contacto 2</h4>
                                    <p><strong>Parentesco:</strong> No registrado</p>
                                    <p><strong>Teléfono:</strong> No registrado</p>
                                    <p><strong>Correo:</strong> No registrado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

                <!-- Configuración de Cuenta -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2><i class="fas fa-cog"></i> Configuración de Cuenta</h2>
                    </div>
                    
                        <div class="account-actions">
                            <button class="btn-change-password">
                                <i class="fas fa-key"></i>
                                Cambiar Contraseña
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
