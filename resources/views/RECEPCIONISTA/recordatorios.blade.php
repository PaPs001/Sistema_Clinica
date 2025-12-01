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
                    
                </div>
            </header>

            <div class="content">
                <!-- Estadísticas Rápidas -->
                <div class="stats-grid">
                    
                    
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
                            <label for="date-range">Fecha:</label>
                            <input type="date" id="date-range" name="date" value="{{ request('date') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>

                        <!-- Buscador por nombre de paciente -->
                        <div class="filter-group" style="position: relative;">
                            <label for="reminder-search">Paciente:</label>
                            <div class="search-box" style="display: flex; align-items: center; background: #f0f2f5; border-radius: 20px; padding: 5px 15px; border: 1px solid #ddd;">
                                <input
                                    type="text"
                                    id="reminder-search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Buscar por nombre..."
                                    autocomplete="off"
                                    style="border: none; background: transparent; outline: none; padding: 5px; width: 230px;"
                                >
                                <button type="submit" style="border: none; background: none; cursor: pointer; color: #666;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div id="sugerencias-recordatorios" class="sugerencias-lista"></div>
                        </div>

                        <button type="submit" class="section-btn" id="apply-filters">
                            <i class="fas fa-filter"></i> Aplicar
                        </button>
                        <a href="{{ route('recordatorios') }}" class="section-btn btn-cancel" id="reset-filters" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-redo"></i> Limpiar
                        </a>
                    </form>
                </div>

                <!-- Lista de Recordatorios -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-list"></i> Recordatorios Programados
                        <div class="section-actions">
                            
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
                                                    @hasPermission('editar_citas')
                                                    <button class="btn-send" title="Enviar Recordatorio" onclick="sendReminder({{ $appointment->id }})">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                    @endhasPermission
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
                        @hasPermission('gestionar_citas')
                        <button type="submit" class="section-btn">
                            <i class="fas fa-save"></i> Guardar Recordatorio
                        </button>
                        <button type="button" class="section-btn" id="send-now-btn">
                            <i class="fas fa-paper-plane"></i> Enviar Ahora
                        </button>
                        @endhasPermission
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@vite('resources/js/RECEPCIONISTA/script-recordatorios.js')
<script>
    function sendReminder(appointmentId) {
        Swal.fire({
            title: '¿Enviar Recordatorio?',
            text: "¿Estás seguro de enviar un recordatorio al médico?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Enviando...',
                    text: 'Por favor espere',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('{{ route("notifications.sendReminder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ appointment_id: appointmentId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Enviado!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al enviar el recordatorio.'
                    });
                });
            }
        });
    }
</script>
@endsection
