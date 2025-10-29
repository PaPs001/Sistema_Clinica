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
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="reminder-type">Tipo:</label>
                            <select id="reminder-type">
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
                            <select id="reminder-status">
                                <option value="">Todos los estados</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="enviado">Enviado</option>
                                <option value="fallido">Fallido</option>
                                <option value="programado">Programado</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="reminder-channel">Canal:</label>
                            <select id="reminder-channel">
                                <option value="">Todos los canales</option>
                                <option value="sms">SMS</option>
                                <option value="email">Email</option>
                                <option value="llamada">Llamada</option>
                                <option value="push">Notificación Push</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="date-range">Rango de Fecha:</label>
                            <select id="date-range">
                                <option value="hoy">Hoy</option>
                                <option value="manana">Mañana</option>
                                <option value="semana">Esta Semana</option>
                                <option value="mes">Este Mes</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                        
                        <button class="section-btn" id="apply-filters">
                            <i class="fas fa-filter"></i> Aplicar
                        </button>
                        <button class="section-btn btn-cancel" id="reset-filters">
                            <i class="fas fa-redo"></i> Limpiar
                        </button>
                    </div>
                    
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
                        <!-- Recordatorio 1 -->
                        <div class="reminder-card" data-type="cita" data-status="pendiente" data-channel="sms">
                            <div class="reminder-checkbox">
                                <input type="checkbox" class="reminder-select">
                            </div>
                            <div class="reminder-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="reminder-content">
                                <div class="reminder-header">
                                    <h4>Recordatorio de Cita - Carlos Ruiz</h4>
                                    <span class="reminder-badge type-cita">Cita</span>
                                </div>
                                <div class="reminder-details">
                                    <p><i class="fas fa-user-md"></i> <strong>Médico:</strong> Dra. Elena Morales</p>
                                    <p><i class="fas fa-clock"></i> <strong>Fecha y Hora:</strong> 16 Nov 2023, 08:30 AM</p>
                                    <p><i class="fas fa-comment"></i> <strong>Mensaje:</strong> Recordatorio de su cita médica programada para mañana a las 08:30 AM con la Dra. Elena Morales. Favor presentarse 15 minutos antes.</p>
                                </div>
                                <div class="reminder-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-mobile-alt"></i> SMS
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i> Programado para: Hoy, 06:00 PM
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user"></i> +1 555-123-4567
                                    </span>
                                </div>
                            </div>
                            <div class="reminder-actions">
                                <span class="status-badge pending">Pendiente</span>
                                <div class="action-buttons">
                                    <button class="btn-send" title="Enviar ahora">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    <button class="btn-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-cancel" title="Cancelar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Recordatorio 2 -->
                        <div class="reminder-card" data-type="pago" data-status="programado" data-channel="email">
                            <div class="reminder-checkbox">
                                <input type="checkbox" class="reminder-select">
                            </div>
                            <div class="reminder-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="reminder-content">
                                <div class="reminder-header">
                                    <h4>Recordatorio de Pago - Ana López</h4>
                                    <span class="reminder-badge type-pago">Pago</span>
                                </div>
                                <div class="reminder-details">
                                    <p><i class="fas fa-receipt"></i> <strong>Concepto:</strong> Consulta del 14/11/2023</p>
                                    <p><i class="fas fa-dollar-sign"></i> <strong>Monto:</strong> $150.00</p>
                                    <p><i class="fas fa-comment"></i> <strong>Mensaje:</strong> Estimada Ana, le recordamos que tiene un pago pendiente por su consulta médica. Puede realizar el pago en línea o en nuestra sucursal.</p>
                                </div>
                                <div class="reminder-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-envelope"></i> Email
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i> Programado para: 17 Nov, 09:00 AM
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user"></i> ana.lopez@email.com
                                    </span>
                                </div>
                            </div>
                            <div class="reminder-actions">
                                <span class="status-badge scheduled">Programado</span>
                                <div class="action-buttons">
                                    <button class="btn-send" title="Enviar ahora">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    <button class="btn-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-cancel" title="Cancelar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Recordatorio 3 -->
                        <div class="reminder-card" data-type="resultado" data-status="enviado" data-channel="llamada">
                            <div class="reminder-checkbox">
                                <input type="checkbox" class="reminder-select">
                            </div>
                            <div class="reminder-icon">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <div class="reminder-content">
                                <div class="reminder-header">
                                    <h4>Resultados Disponibles - Miguel Torres</h4>
                                    <span class="reminder-badge type-resultado">Resultados</span>
                                </div>
                                <div class="reminder-details">
                                    <p><i class="fas fa-flask"></i> <strong>Exámenes:</strong> Hemograma completo, Perfil lipídico</p>
                                    <p><i class="fas fa-calendar"></i> <strong>Fecha de toma:</strong> 10 Nov 2023</p>
                                    <p><i class="fas fa-comment"></i> <strong>Mensaje:</strong> Buen día Miguel, sus resultados de laboratorio ya están disponibles. Puede recogerlos en recepción o acceder a ellos través de nuestro portal en línea.</p>
                                </div>
                                <div class="reminder-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-phone"></i> Llamada
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-check-circle"></i> Enviado: Hoy, 10:30 AM
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user"></i> +1 555-456-7890
                                    </span>
                                </div>
                            </div>
                            <div class="reminder-actions">
                                <span class="status-badge sent">Enviado</span>
                                <div class="action-buttons">
                                    <button class="btn-view" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-resend" title="Reenviar">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Recordatorio 4 -->
                        <div class="reminder-card" data-type="medicamento" data-status="fallido" data-channel="sms">
                            <div class="reminder-checkbox">
                                <input type="checkbox" class="reminder-select">
                            </div>
                            <div class="reminder-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div class="reminder-content">
                                <div class="reminder-header">
                                    <h4>Recordatorio de Medicamento - Laura García</h4>
                                    <span class="reminder-badge type-medicamento">Medicamento</span>
                                </div>
                                <div class="reminder-details">
                                    <p><i class="fas fa-prescription-bottle"></i> <strong>Medicamento:</strong> Metformina 500mg</p>
                                    <p><i class="fas fa-clock"></i> <strong>Frecuencia:</strong> Cada 12 horas</p>
                                    <p><i class="fas fa-comment"></i> <strong>Mensaje:</strong> Recordatorio: Es hora de tomar su medicamento (Metformina 500mg). No olvide seguir las indicaciones de su médico.</p>
                                </div>
                                <div class="reminder-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-mobile-alt"></i> SMS
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-exclamation-triangle"></i> Fallido: Hoy, 02:00 PM
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user"></i> +1 555-321-0987
                                    </span>
                                </div>
                            </div>
                            <div class="reminder-actions">
                                <span class="status-badge failed">Fallido</span>
                                <div class="action-buttons">
                                    <button class="btn-retry" title="Reintentar">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                    <button class="btn-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-cancel" title="Cancelar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Recordatorio 5 -->
                        <div class="reminder-card" data-type="general" data-status="pendiente" data-channel="push">
                            <div class="reminder-checkbox">
                                <input type="checkbox" class="reminder-select">
                            </div>
                            <div class="reminder-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="reminder-content">
                                <div class="reminder-header">
                                    <h4>Recordatorio General - Campaña de Vacunación</h4>
                                    <span class="reminder-badge type-general">General</span>
                                </div>
                                <div class="reminder-details">
                                    <p><i class="fas fa-syringe"></i> <strong>Tema:</strong> Vacuna contra la influenza</p>
                                    <p><i class="fas fa-users"></i> <strong>Destinatarios:</strong> Pacientes mayores de 60 años</p>
                                    <p><i class="fas fa-comment"></i> <strong>Mensaje:</strong> La campaña de vacunación contra la influenza está disponible. Proteja su salud esta temporada. Agenda su cita hoy mismo.</p>
                                </div>
                                <div class="reminder-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-bell"></i> Notificación Push
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i> Programado para: 20 Nov, 08:00 AM
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-user-friends"></i> 125 destinatarios
                                    </span>
                                </div>
                            </div>
                            <div class="reminder-actions">
                                <span class="status-badge pending">Pendiente</span>
                                <div class="action-buttons">
                                    <button class="btn-send" title="Enviar ahora">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    <button class="btn-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-cancel" title="Cancelar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="pagination">
                        <button class="pagination-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <span class="pagination-ellipsis">...</span>
                        <button class="pagination-btn">5</button>
                        <button class="pagination-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
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
