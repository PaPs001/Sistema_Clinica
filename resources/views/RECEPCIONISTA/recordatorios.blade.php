@extends('plantillas.dashboard_recepcionista')
@section('title', 'Gestión de Recordatorios - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Gestión de Recordatorios</h1>
                <div class="header-actions">
                    <!--<div class="search-box">
                        <input type="text" placeholder="Buscar recordatorios..." aria-label="Buscar recordatorios">
                        <i class="fas fa-search"></i>
                    </div>-->
                    <button class="section-btn" id="new-reminder-btn">
                        <i class="fas fa-plus"></i> Nuevo Recordatorio
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="stat-info">
                            <h3>24</h3>
                            <p>Pendientes Hoy</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>156</h3>
                            <p>Enviados Esta Semana</p>
                        </div>
                    </div>
                    <!--<div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>8</h3>
                            <p>Fallidos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-info">
                            <h3>89%</h3>
                            <p>Tasa de Éxito</p>
                        </div>
                    </div>-->
                </div>

                <!-- Filtros y Controles -->
                <div class="reminders-controls">
                    <form action="{{ route('recordatorios') }}" method="GET" class="filters-container">
                        <div class="filter-group">
                            <label for="reminder-type">Tipo:</label>
                            <select id="reminder-type" name="type">
                                <option value="">Todos los tipos</option>
                                <option value="cita">Recordatorio de Cita</option>
                                <option value="pago">Recordatorio de Pago</option>
                                <option value="medicamento">Recordatorio de Medicamento</option>
                                <option value="resultado">Resultados Disponibles</option>
                                <option value="general">Recordatorio General</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="reminder-status">Estado:</label>
                            <select id="reminder-status" name="status">
                                <option value="">Todos los estados</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="enviado">Enviado</option>
                                <option value="fallido">Fallido</option>
                                <option value="programado">Programado</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="reminder-channel">Canal:</label>
                            <select id="reminder-channel" name="channel">
                                <option value="">Todos los canales</option>
                                <option value="sms">SMS</option>
                                <option value="email">Email</option>
                                <option value="llamada">Llamada</option>
                                <option value="push">Notificación Push</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="date-range">Fecha:</label>
                            <input type="date" id="date-range" name="date" value="{{ request('date') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        
                        <button type="submit" class="section-btn" id="apply-filters">
                            <i class="fas fa-filter"></i> Aplicar
                        </button>
                        <a href="{{ route('recordatorios') }}" class="section-btn btn-cancel" id="reset-filters" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-redo"></i> Limpiar
                        </a>
                    </form>
                    
                    <div class="bulk-actions">
                        <button class="section-btn" id="send-bulk-reminders">
                            <i class="fas fa-paper-plane"></i> Enviar Lote
                        </button>
                        <button class="section-btn" id="schedule-reminders">
                            <i class="fas fa-clock"></i> Programar
                        </button>
                        <button class="section-btn btn-cancel" id="delete-reminders">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>

                <!-- Lista de Recordatorios -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Recordatorios Programados
                        <div class="section-actions">
                            <button class="section-btn" id="export-reminders">
                                <i class="fas fa-download"></i> Exportar
                            </button>
                            <button class="section-btn" id="refresh-reminders">
                                <i class="fas fa-sync"></i> Actualizar
                            </button>
                        </div>
                    </h2>
                    
                    <div class="reminders-list">
                        <div class="appointments-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Fecha y Hora</th>
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Tipo</th>
                                        <th>Estado Cita</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        @php
                                            $patientName = 'Desconocido';
                                            if ($appointment->patient) {
                                                if ($appointment->patient->is_Temporary) {
                                                    $patientName = $appointment->patient->temporary_name;
                                                } elseif ($appointment->patient->user) {
                                                    $patientName = $appointment->patient->user->name;
                                                }
                                            }

                                            $doctorName = 'Por asignar';
                                            if ($appointment->doctor && $appointment->doctor->user) {
                                                $doctorName = $appointment->doctor->user->name;
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="time-slot">
                                                    <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time)->format('d M, H:i') }}</strong>
                                                    <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->isToday() ? 'Hoy' : (\Carbon\Carbon::parse($appointment->appointment_date)->isTomorrow() ? 'Mañana' : 'Próxima') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="patient-info">
                                                    <div class="patient-avatar">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $patientName }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $doctorName }}</td>
                                            <td><span class="type-badge {{ strtolower($appointment->reason) }}">{{ ucfirst($appointment->reason) }}</span></td>
                                            <td><span class="status-badge {{ $appointment->status == 'agendada' ? 'pending' : ($appointment->status == 'Confirmada' ? 'confirmed' : 'completed') }}">{{ ucfirst($appointment->status) }}</span></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-send" title="Enviar Recordatorio">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                    <button class="btn-edit" title="Programar">
                                                        <i class="fas fa-clock"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" style="text-align: center; padding: 20px;">No hay citas próximas para mostrar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="pagination">
                        @if ($appointments->onFirstPage())
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @else
                            <a href="{{ $appointments->previousPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($appointments->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span class="pagination-ellipsis">{{ $element }}</span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $appointments->currentPage())
                                        <button class="pagination-btn active">{{ $page }}</button>
                                    @else
                                        <a href="{{ $url }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($appointments->hasMorePages())
                            <a href="{{ $appointments->nextPageUrl() }}" class="pagination-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="pagination-btn" disabled>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Plantillas de Recordatorios -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-layer-group"></i> Plantillas de Recordatorios
                    </h2>
                    
                    <div class="templates-grid">
                        <div class="template-card">
                            <div class="template-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="template-content">
                                <h4>Confirmación de Cita</h4>
                                <p>Plantilla estándar para confirmar citas médicas programadas.</p>
                                <div class="template-stats">
                                    <!--<span><i class="fas fa-chart-bar"></i> 85% tasa de apertura</span>-->
                                    <span><i class="fas fa-clock"></i> Usada 234 veces</span>
                                </div>
                            </div>
                            <button class="section-btn btn-use-template">
                                <i class="fas fa-plus"></i> Usar
                            </button>
                        </div>
                        
                        <div class="template-card">
                            <div class="template-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="template-content">
                                <h4>Recordatorio de Pago</h4>
                                <p>Plantilla para recordatorios de pagos pendientes y facturas.</p>
                                <div class="template-stats">
                                    <!--<span><i class="fas fa-chart-bar"></i> 72% tasa de apertura</span>-->
                                    <span><i class="fas fa-clock"></i> Usada 156 veces</span>
                                </div>
                            </div>
                            <button class="section-btn btn-use-template">
                                <i class="fas fa-plus"></i> Usar
                            </button>
                        </div>
                        
                        <div class="template-card">
                            <div class="template-icon">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <div class="template-content">
                                <h4>Resultados Disponibles</h4>
                                <p>Notificación cuando los resultados de laboratorio están listos.</p>
                                <div class="template-stats">
                                    <!--<span><i class="fas fa-chart-bar"></i> 91% tasa de apertura</span>-->
                                    <span><i class="fas fa-clock"></i> Usada 89 veces</span>
                                </div>
                            </div>
                            <button class="section-btn btn-use-template">
                                <i class="fas fa-plus"></i> Usar
                            </button>
                        </div>
                        
                        <!--<div class="template-card">
                            <div class="template-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="template-content">
                                <h4>Crear Nueva Plantilla</h4>
                                <p>Diseña una plantilla personalizada para tus recordatorios.</p>
                            </div>
                            <button class="section-btn">
                                <i class="fas fa-plus"></i> Crear
                            </button>
                        </div>-->
                    </div>
                </div>
            </div>

    <!-- Modal de Nuevo Recordatorio -->
    <div class="modal-overlay" id="new-reminder-modal">
        <div class="modal large-modal">
            <div class="modal-header">
                <h3>Crear Nuevo Recordatorio</h3>
                <button class="close-modal" aria-label="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-reminder-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="reminder-type-select">Tipo de Recordatorio *</label>
                            <select id="reminder-type-select" required>
                                <option value="">Seleccionar tipo</option>
                                <option value="cita">Recordatorio de Cita</option>
                                <option value="pago">Recordatorio de Pago</option>
                                <option value="medicamento">Recordatorio de Medicamento</option>
                                <option value="resultado">Resultados Disponibles</option>
                                <option value="general">Recordatorio General</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="reminder-channel-select">Canal de Envío *</label>
                            <select id="reminder-channel-select" required>
                                <option value="">Seleccionar canal</option>
                                <option value="sms">SMS</option>
                                <option value="email">Email</option>
                                <option value="llamada">Llamada Telefónica</option>
                                <option value="push">Notificación Push</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="reminder-patient">Paciente o Grupo</label>
                            <select id="reminder-patient">
                                <option value="">Seleccionar paciente/grupo</option>
                                <option value="individual">Paciente individual</option>
                                <option value="grupo">Grupo de pacientes</option>
                                <option value="todos">Todos los pacientes</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="reminder-schedule">Programación *</label>
                            <select id="reminder-schedule" required>
                                <option value="">Seleccionar programación</option>
                                <option value="inmediato">Enviar inmediatamente</option>
                                <option value="programado">Programar para después</option>
                                <option value="recurrente">Recurrente</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="reminder-message">Mensaje *</label>
                        <textarea id="reminder-message" rows="6" required placeholder="Escriba el mensaje del recordatorio..."></textarea>
                        <div class="message-counter">
                            <span id="char-count">0</span> caracteres
                            <span class="sms-warning" id="sms-warning">(SMS: 160 caracteres máximo)</span>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="reminder-notes">Notas Adicionales</label>
                        <textarea id="reminder-notes" rows="3" placeholder="Observaciones adicionales..."></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="section-btn btn-cancel" id="cancel-reminder">
                            Cancelar
                        </button>
                        <button type="submit" class="section-btn">
                            <i class="fas fa-save"></i> Guardar Recordatorio
                        </button>
                        <button type="button" class="section-btn" id="send-now-btn">
                            <i class="fas fa-paper-plane"></i> Enviar Ahora
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@vite('resources/js/RECEPCIONISTA/script-recordatorios.js')
@endsection
