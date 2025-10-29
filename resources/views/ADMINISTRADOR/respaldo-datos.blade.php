@extends('plantillas.dashboard_administrador')
@section('title', 'Respaldo de Datos - Clínica "Última Asignatura"')
@section('content')
            <header class="content-header">
                <h1><i class="fas fa-database"></i> Respaldo de Datos</h1>
                <!--<div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchBackups" placeholder="Buscar respaldos..." onkeyup="searchBackups()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>--->
            </header>

            <div class="content">
                <!-- Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-hdd"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalBackups">0</h3>
                            <p>Total de Respaldos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-file-archive"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalSize">0 GB</h3>
                            <p>Espacio Utilizado</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="successfulBackups">0</h3>
                            <p>Respaldos Exitosos</p>
                        </div>
                    </div>
                    <!--<div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="nextBackup">-</h3>
                            <p>Próximo Respaldo</p>
                        </div>
                    </div>-->
                </div>

                <!-- Acciones Principales -->
                <div class="health-info">
                    <div class="info-card">
                        <h3><i class="fas fa-plus-circle"></i> Crear Respaldo Manual</h3>
                        <div class="backup-options">
                            <div class="option-group">
                                <label>Tipo de Respaldo:</label>
                                <select id="backupType" class="setting-select">
                                    <option value="full">Completo</option>
                                    <option value="incremental">Incremental</option>
                                    <option value="differential">Diferencial</option>
                                </select>
                            </div>
                            <div class="option-group">
                                <label>Base de Datos:</label>
                                <select id="databaseSelect" class="setting-select">
                                    <option value="all">Todas las Bases de Datos</option>
                                    <option value="principal">Base de Datos Principal</option>
                                    <option value="logs">Base de Logs</option>
                                    <option value="config">Base de Configuración</option>
                                </select>
                            </div>
                            <div class="option-group">
                                <label>Destino:</label>
                                <select id="backupDestination" class="setting-select">
                                    <option value="local">Almacenamiento Local</option>
                                    <option value="cloud">Nube (AWS S3)</option>
                                    <option value="external">Disco Externo</option>
                                </select>
                            </div>
                            <div class="option-group">
                                <label>Compresión:</label>
                                <select id="compressionLevel" class="setting-select">
                                    <option value="none">Sin Compresión</option>
                                    <option value="fast" selected>Rápida</option>
                                    <option value="high">Alta Compresión</option>
                                </select>
                            </div>
                            <button class="section-btn btn-success" onclick="createManualBackup()">
                                <i class="fas fa-play"></i> Iniciar Respaldo
                            </button>
                        </div>
                    </div>
                </div>
<!--
                    <div class="info-card">
                        <h3><i class="fas fa-history"></i> Estado del Sistema</h3>
                        <div class="system-status">
                            <div class="status-item">
                                <span class="status-label">Espacio en Disco:</span>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="diskSpaceProgress" style="width: 65%"></div>
                                </div>
                                <span class="status-value">65% (32.5/50 GB)</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Última Verificación:</span>
                                <span class="status-value" id="lastVerification">Hace 2 horas</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Integridad de Respaldos:</span>
                                <span class="status-badge success" id="integrityStatus">Óptima</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Tiempo de Retención:</span>
                                <span class="status-value" id="retentionPeriod">30 días</span>
                            </div>
                        </div>
                        <div class="maintenance-actions">
                            <button class="section-btn" onclick="verifyBackups()">
                                <i class="fas fa-check-double"></i> Verificar Integridad
                            </button>
                            <button class="section-btn btn-warning" onclick="cleanOldBackups()">
                                <i class="fas fa-broom"></i> Limpiar Antiguos
                            </button>
                        </div>
                    </div>
                </div>
-->


                <!-- Historial de Respaldos -->
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-history"></i> Historial de Respaldos
                        <div class="section-actions">
                            <button class="section-btn" onclick="refreshBackups()">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                            <button class="section-btn" onclick="exportBackupReport()">
                                <i class="fas fa-download"></i> Exportar Reporte
                            </button>
                        </div>
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre del Respaldo</th>
                                    <th>Fecha y Hora</th>
                                    <th>Tipo</th>
                                    <th>Tamaño</th>
                                    <th>Estado</th>
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="backupsTableBody">
                                <!-- Los respaldos se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Programación Automática
                <div class="recent-section">
                    <h2>
                        <i class="fas fa-clock"></i> Programación Automática
                        <div class="section-actions">
                            <button class="section-btn" onclick="addNewSchedule()">
                                <i class="fas fa-plus"></i> Nueva Programación
                            </button>
                        </div>
                    </h2>
                    
                    <div class="appointments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Frecuencia</th>
                                    <th>Próxima Ejecución</th>
                                    <th>Tipo</th>
                                    <th>Destino</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="schedulesTableBody">
                                Las programaciones se cargarán dinámicamente
                            </tbody>
                        </table>
                    </div>
                </div>
                 -->

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2><i class="fas fa-bolt"></i> Acciones Rápidas</h2>
                    <div class="actions-grid">
                        <a href="#" class="action-card" onclick="createQuickBackup()">
                            <i class="fas fa-bolt"></i>
                            <span>Respaldo Rápido</span>
                        </a>
                        <a href="#" class="action-card" onclick="showRestoreOptions()">
                            <i class="fas fa-undo"></i>
                            <span>Restaurar Datos</span>
                        </a>
                        <!--<a href="#" class="action-card" onclick="manageStorage()">
                            <i class="fas fa-hdd"></i>
                            <span>Gestionar Almacenamiento</span>
                        </a>-->
                        <!--<a href="#" class="action-card" onclick="showBackupLogs()">
                            <i class="fas fa-list-alt"></i>
                            <span>Ver Logs</span>
                        </a>-->
                    </div>
                </div>
            </div>

    <!-- Modal para Restaurar -->
    <div class="modal-overlay" id="restoreModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Restaurar desde Respaldo</h3>
                <button class="close-modal" onclick="closeRestoreModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="restore-options">
                    <div class="option-group">
                        <label>Seleccionar Respaldo:</label>
                        <select id="restoreBackupSelect" class="setting-select">
                            <!-- Opciones se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="option-group">
                        <label>Tipo de Restauración:</label>
                        <select id="restoreType" class="setting-select">
                            <option value="complete">Restauración Completa</option>
                            <option value="partial">Restauración Parcial</option>
                            <option value="tables">Solo Tablas Específicas</option>
                        </select>
                    </div>
                    <div class="option-group">
                        <label>Verificación:</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="verifyBeforeRestore" checked>
                            <label for="verifyBeforeRestore">Verificar integridad antes de restaurar</label>
                        </div>
                    </div>
                    <div class="warning-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Advertencia:</strong> Esta acción sobrescribirá los datos actuales.
                    </div>
                    <div class="form-actions">
                        <button type="button" class="section-btn" style="background: #95a5a6;" onclick="closeRestoreModal()">Cancelar</button>
                        <button type="button" class="section-btn btn-danger" onclick="executeRestore()">Iniciar Restauración</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nueva Programación -->
    <div class="modal-overlay" id="scheduleModal">
        <div class="modal">
            <div class="modal-header">
                <h3 id="scheduleModalTitle">Nueva Programación de Respaldo</h3>
                <button class="close-modal" onclick="closeScheduleModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm">
                    <div class="form-group">
                        <label for="scheduleName">Nombre de la Programación:</label>
                        <input type="text" id="scheduleName" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="scheduleFrequency">Frecuencia:</label>
                            <select id="scheduleFrequency" required>
                                <option value="daily">Diario</option>
                                <option value="weekly">Semanal</option>
                                <option value="monthly">Mensual</option>
                                <option value="custom">Personalizado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="scheduleTime">Hora de Ejecución:</label>
                            <input type="time" id="scheduleTime" value="02:00" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="scheduleType">Tipo de Respaldo:</label>
                        <select id="scheduleType" required>
                            <option value="full">Completo</option>
                            <option value="incremental">Incremental</option>
                            <option value="differential">Diferencial</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="scheduleDestination">Destino:</label>
                        <select id="scheduleDestination" required>
                            <option value="local">Almacenamiento Local</option>
                            <option value="cloud">Nube (AWS S3)</option>
                            <option value="external">Disco Externo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" id="scheduleEnabled" checked>
                            <span>Programación activa</span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="section-btn" style="background: #95a5a6;" onclick="closeScheduleModal()">Cancelar</button>
                        <button type="submit" class="section-btn">Guardar Programación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@vite('resources/js/ADMINISTRATOR/respaldo-datos.js')
@endsection
