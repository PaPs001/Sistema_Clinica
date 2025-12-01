@extends('plantillas.dashboard_recepcionista')
@section('title', 'Agendar Cita - Clinica Ultima Asignatura')
@section('content')
            <header class="content-header">
                <h1>Agendar Nueva Cita</h1>
            </header>

            <div class="content">
                <div class="registration-form">
                    <div class="form-header">
                        <h2>
                            <i class="fas fa-calendar-plus"></i> Datos de la Cita
                        </h2>
                    </div>

                    <form id="appointment-form">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient_name">
                                    <i class="fas fa-user"></i> Nombre del Paciente
                                </label>
                                <input type="text" id="patient_name" autocomplete="off" placeholder="Buscar por nombre...">
                                <div id="sugerencias-pacientes" class="sugerencias-lista"></div>
                                <input type="hidden" id="patient_id">
                            </div>

                            <div class="form-group">
                                <label for="patient_age">
                                    <i class="fas fa-birthday-cake"></i> Edad
                                </label>
                                <input type="text" id="patient_age" readonly placeholder="Se completará al seleccionar paciente">
                            </div>

                            <div class="form-group">
                                <label for="patient_phone">
                                    <i class="fas fa-phone"></i> Teléfono
                                </label>
                                <input type="tel" id="patient_phone" name="phone" placeholder="Teléfono del paciente">
                            </div>

                            <div class="form-group">
                                <label for="patient_email">
                                    <i class="fas fa-envelope"></i> Correo electrónico
                                </label>
                                  <input type="email" id="patient_email" name="email" placeholder="ejemplo@correo.com"
                                         value="{{ request('email') }}">
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">
                                    <i class="fas fa-user-md"></i> Médico
                                </label>
                                <select id="doctor_id" name="doctor_id" required>
                                    <option value="">Seleccionar médico</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="date">
                                    <i class="fas fa-calendar"></i> Fecha de la cita
                                </label>
                                <input type="date" id="date" name="date" required>
                            </div>

                            <div class="form-group">
                                <label for="time">
                                    <i class="fas fa-clock"></i> Hora de la cita
                                </label>
                                <input type="time" id="time" name="time" required>
                            </div>

                            <div class="form-group">
                                <label for="type">
                                    <i class="fas fa-stethoscope"></i> Tipo de cita
                                </label>
                                <select id="type" name="type" required>
                                    <option value="consulta">Consulta</option>
                                    <option value="control">Control</option>
                                    <option value="emergencia">Urgencia</option>
                                    <option value="seguimiento">Seguimiento</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="notes">
                                    <i class="fas fa-sticky-note"></i> Notas adicionales
                                </label>
                                <textarea id="notes" name="notes" rows="3" placeholder="Observaciones sobre la cita..."></textarea>
                            </div>
                        </div>

                        <input type="hidden" id="is_new" name="is_new" value="false">

                        <div class="form-actions">
                            <a href="{{ route('gestionCitas') }}" class="section-btn btn-cancel" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-arrow-left"></i> Volver a gestión de citas
                            </a>
                            @hasPermission('gestionar_citas')
                            <button type="submit" class="section-btn">
                                <i class="fas fa-save"></i> Agendar Cita
                            </button>
                            @endhasPermission
                        </div>
                    </form>
                </div>
            </div>
@endsection
@section('scripts')
    @vite(['resources/js/RECEPCIONISTA/script-agendar-cita.js'])
@endsection
