@extends('plantillas.dashboard_administrador')
@section('title', 'Respaldo de Datos - Clínica "Última Asignatura"')

@section('scripts')
    <script src="{{ asset('js/ADMINISTRATOR/backup-manager.js') }}"></script>
    <style>
        .backup-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .backup-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .backup-card h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .backup-card p {
            color: #7f8c8d;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .backup-btn {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .backup-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .backup-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .backup-btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        
        .backup-btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(56, 239, 125, 0.4);
        }
        
        .backup-btn-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .backup-btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
        }
        
        .backups-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .backups-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .backups-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
        }
        
        .backups-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .backups-table tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-info {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .badge-success {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .action-btn {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #7f8c8d;
            transition: color 0.3s;
            font-size: 16px;
        }
        
        .action-btn:hover {
            color: #2c3e50;
        }
        
        .action-btn.delete-btn:hover {
            color: #e74c3c;
        }
        
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-header h3 {
            margin: 0;
            color: #2c3e50;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #7f8c8d;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(400px);
            transition: transform 0.3s;
            z-index: 10000;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification-success {
            border-left: 4px solid #27ae60;
        }
        
        .notification-error {
            border-left: 4px solid #e74c3c;
        }
        
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        
        .loading-content {
            text-align: center;
            color: white;
        }
        
        .spinner {
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <header class="content-header">
        <h1><i class="fas fa-database"></i> Respaldo de Datos</h1>
    </header>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(auth()->user() && auth()->user()->hasPermission('crear_reportes'))
            {{-- Acciones de Backup --}}
            <div class="backup-actions-grid">
                <div class="backup-card">
                    <h3><i class="fas fa-database"></i> Backup Solo Datos</h3>
                    <p>Crea un respaldo de los datos sin incluir la estructura de las tablas. Ideal para restauraciones rápidas.</p>
                    <button onclick="createDataBackup()" class="backup-btn backup-btn-primary">
                        <i class="fas fa-save"></i> Crear Backup de Datos
                    </button>
                </div>

                <div class="backup-card">
                    <h3><i class="fas fa-archive"></i> Backup Completo</h3>
                    <p>Crea un respaldo completo incluyendo estructura, datos y archivos de documentos.</p>
                    <button onclick="createFullBackup()" class="backup-btn backup-btn-success">
                        <i class="fas fa-box"></i> Crear Backup Completo
                    </button>
                </div>

                <div class="backup-card">
                    <h3><i class="fas fa-broom"></i> Limpiar Antiguos</h3>
                    <p>Elimina backups antiguos según la política de retención configurada.</p>
                    <button onclick="cleanOldBackups()" class="backup-btn backup-btn-warning">
                        <i class="fas fa-trash-alt"></i> Limpiar Backups
                    </button>
                </div>
            </div>

            {{-- Restaurar Backup --}}
            <div class="backup-card" style="margin-bottom: 30px;">
                <h3><i class="fas fa-undo"></i> Restaurar desde Backup</h3>
                <p>Sube un archivo <code>.zip</code> de backup para restaurar la base de datos y archivos.</p>
                <form method="POST" action="{{ route('admin.restoreBackup') }}" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; gap: 15px; align-items: end;">
                        <div style="flex: 1;">
                            <label for="backup_file" style="display: block; margin-bottom: 5px; font-weight: 600;">Archivo de backup (.zip):</label>
                            <input type="file" id="backup_file" name="backup_file" accept=".zip" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <button type="submit" class="backup-btn backup-btn-warning" style="width: auto; padding: 10px 30px;">
                            <i class="fas fa-upload"></i> Restaurar
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Lista de Backups --}}
        <div class="recent-section">
            <h2>
                <i class="fas fa-history"></i> Historial de Backups
                <div class="section-actions">
                    <button class="section-btn" onclick="loadBackupsList()">
                        <i class="fas fa-sync-alt"></i> Actualizar
                    </button>
                </div>
            </h2>
            
            <div class="backups-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre del Archivo</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Tamaño</th>
                            <!--<th>Acciones</th>-->
                        </tr>
                    </thead>
                    <tbody id="backupsTableBody">
                        <tr>
                            <td colspan="5" style="text-align: center;">Cargando backups...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Eliminar Base de Datos (Desarrollo) --}}
        @if(app()->environment('local'))
            <div class="backup-card" style="margin-top: 30px; border: 2px solid #e74c3c;">
                <h3 style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> Zona de Peligro</h3>
                <p style="color: #c0392b;">
                    <strong>ADVERTENCIA:</strong> Esta acción eliminará TODA la base de datos. Solo disponible en entorno local.
                </p>
                <form method="POST" action="{{ route('admin.wipeDatabase') }}" 
                    onsubmit="return confirm('¿Seguro que quieres eliminar TODA la base de datos? Esta acción no se puede deshacer.');">
                    @csrf
                    <button type="submit" class="backup-btn" style="background: #e74c3c; color: white;">
                        <i class="fas fa-skull-crossbones"></i> Eliminar Base de Datos
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
