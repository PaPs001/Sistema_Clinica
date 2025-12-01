<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminBackupController extends Controller
{
    public function createDataBackup(){
        try {
            // Set dump options at runtime instead of modifying files
            // We target the database config as per Spatie docs
            config(['database.connections.mysql.dump.add_extra_option' => '--no-create-info --skip-triggers --skip-add-locks']);
            
            // Ensure the backups directory exists
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }
            
            Artisan::call('config:clear');
            
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--filename' => 'data-only-' . now()->format('Y-m-d_H-i-s') . '.zip',
                '--disable-notifications' => true,
            ]);
            
            $output = Artisan::output();
            Log::info('Data-only backup created', ['output' => $output]);
            
            $latestBackup = $this->getLatestBackup();
            
            if ($latestBackup) {
                return response()->download($latestBackup['path'])
                    ->deleteFileAfterSend(false);
            }
            
            if (request()->expectsJson()) {
                 return response()->json(['message' => 'Backup creado pero no se encontró el archivo.'], 500);
            }
            return back()->with('success', 'Backup de datos creado exitosamente.');
            
        } catch (\Exception $e) {
            Log::error('Data backup failed', ['error' => $e->getMessage()]);
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Error al crear backup: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Error al crear backup: ' . $e->getMessage());
        }
    }
    
    public function createFullBackup(){
        try {
            config(['backup.backup.source.databases.mysql.dump.add_extra_option' => '']);
            
            Artisan::call('backup:run', [
                '--filename' => 'full-' . now()->format('Y-m-d_H-i-s') . '.zip',
            ]);
            
            $output = Artisan::output();
            Log::info('Full backup created', ['output' => $output]);
            
            $latestBackup = $this->getLatestBackup();
            
            if ($latestBackup) {
                return response()->download($latestBackup['path'])
                    ->deleteFileAfterSend(false);
            }
            
            return back()->with('success', 'Backup completo creado exitosamente.');
            
        } catch (\Exception $e) {
            Log::error('Full backup failed', ['error' => $e->getMessage()]);
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Error al crear backup: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Error al crear backup: ' . $e->getMessage());
        }
    }
    
    public function listBackups(){
        $backups = [];
        // Use allFiles to find files in subdirectories (e.g. <APP_NAME>/file.zip)
        $files = Storage::disk('backups')->allFiles();
        
        foreach ($files as $file) {
            if (str_ends_with($file, '.zip')) {
                $backups[] = [
                    'name' => $file, // Return full relative path (e.g. "Laravel/backup.zip")
                    'path' => Storage::disk('backups')->path($file),
                    'size' => $this->formatBytes(Storage::disk('backups')->size($file)),
                    'size_bytes' => Storage::disk('backups')->size($file),
                    'date' => date('Y-m-d H:i:s', Storage::disk('backups')->lastModified($file)),
                    'timestamp' => Storage::disk('backups')->lastModified($file),
                    'type' => str_contains(basename($file), 'data-only') ? 'Solo Datos' : 'Completo',
                ];
            }
        }
        usort($backups, fn($a, $b) => $b['timestamp'] - $a['timestamp']);
        
        return response()->json($backups);
    }
    
    public function downloadBackup($filename){
        // $filename might contain slashes (e.g. Laravel/backup.zip), which is fine for Storage::disk()->path()
        // But we need to ensure we don't allow directory traversal if we were using local FS directly.
        // Storage::disk handles this safely usually.
        
        if (!Storage::disk('backups')->exists($filename)) {
             // Return 404 so the fetch client knows it failed, instead of a redirect
            abort(404, 'Backup no encontrado.');
        }

        $path = Storage::disk('backups')->path($filename);
        
        return response()->download($path);
    }
    
    public function deleteBackup($filename){
        try {
            if (Storage::disk('backups')->exists($filename)) {
                Storage::disk('backups')->delete($filename);
                Log::info('Backup deleted', ['filename' => $filename]);
                return response()->json(['success' => true, 'message' => 'Backup eliminado correctamente.']);
            }
            
            return response()->json(['success' => false, 'message' => 'Backup no encontrado.'], 404);
            
        } catch (\Exception $e) {
            Log::error('Delete backup failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function restoreBackup(Request $request){
        $request->validate([
            'backup_file' => 'required|file|mimes:zip|max:512000',
        ]);
        
        $uploadedFile = $request->file('backup_file');
        $tmpPath = storage_path('app/tmp_restore/' . uniqid());
        
        try {
            Log::info('Starting backup restoration', [
                'filename' => $uploadedFile->getClientOriginalName(),
                'size' => $uploadedFile->getSize(),
            ]);
            
            File::makeDirectory($tmpPath, 0755, true);
            
            $zip = new ZipArchive;
            if ($zip->open($uploadedFile->getRealPath()) !== TRUE) {
                throw new \Exception('No se pudo abrir el archivo ZIP.');
            }
            
            $zip->extractTo($tmpPath);
            $zip->close();
            
            Log::info('Backup extracted', ['path' => $tmpPath]);
            
            $this->restoreDatabaseIntelligent($tmpPath);
            
            $this->restoreFiles($tmpPath);
            
            File::deleteDirectory($tmpPath);
            
            Log::info('Backup restored successfully');
            
            return back()->with('success', 'Backup restaurado exitosamente.');
            
        } catch (\Exception $e) {
            if (File::exists($tmpPath)) {
                File::deleteDirectory($tmpPath);
            }
            
            Log::error('Restore failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->with('error', 'Error al restaurar: ' . $e->getMessage());
        }
    }

    private function restoreDatabaseIntelligent($tmpPath){
        $sqlFiles = File::glob($tmpPath . '/db-dumps/*.sql');
        
        if (empty($sqlFiles)) {
            throw new \Exception('No se encontró archivo SQL en el backup.');
        }
        
        $sqlFile = $sqlFiles[0];
        $fileSize = filesize($sqlFile);
        $fileSizeMB = round($fileSize / 1024 / 1024, 2);
        
        Log::info('Restoring database', [
            'file' => basename($sqlFile),
            'size' => $fileSizeMB . ' MB',
        ]);
        
        $threshold = 50 * 1024 * 1024; 
        
        if ($fileSize < $threshold) {
            Log::info('Using DB::unprepared() method (file < 50MB)');
            $this->restoreWithUnprepared($sqlFile);
        } else {
            Log::info('Using mysql CLI method (file >= 50MB)');
            $this->restoreWithMysqlCLI($sqlFile);
        }
        
        Log::info('Database restored successfully');
    }
    
    private function restoreWithUnprepared($sqlFile){
        try {
            $sql = file_get_contents($sqlFile);
            
            $statements = array_filter(
                array_map('trim', explode(';', $sql)),
                fn($stmt) => !empty($stmt)
            );
            
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    DB::unprepared($statement . ';');
                }
            }
            
            Log::info('Restore completed using DB::unprepared()', [
                'statements' => count($statements),
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception('Error al restaurar con DB::unprepared: ' . $e->getMessage());
        }
    }
    
    private function restoreWithMysqlCLI($sqlFile){
        try {
            $config = config('database.connections.mysql');
            
            $command = [
                env('MYSQL_BIN_PATH', '/usr/bin/mysql'),
                '--user=' . $config['username'],
                '--password=' . $config['password'],
                '--host=' . ($config['host'] ?? '127.0.0.1'),
                '--port=' . ($config['port'] ?? 3306),
                $config['database'],
            ];
            
            $process = new Process($command);
            $process->setInput(file_get_contents($sqlFile));
            $process->setTimeout(600);
            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            
            Log::info('Restore completed using mysql CLI', [
                'exit_code' => $process->getExitCode(),
            ]);
            
        } catch (ProcessFailedException $e) {
            throw new \Exception('Error al restaurar con mysql CLI: ' . $e->getMessage());
        }
    }

    private function restoreFiles($tmpPath){
        $filesPath = $tmpPath . '/files';
        
        if (!File::exists($filesPath)) {
            Log::info('No files to restore');
            return;
        }
        
        $sourceDocumentos = $filesPath . '/storage/app/public/documentos';
        $destDocumentos = storage_path('app/public/documentos');
        
        if (File::exists($sourceDocumentos)) {
            if (!File::exists($destDocumentos)) {
                File::makeDirectory($destDocumentos, 0755, true);
            }
            
            File::copyDirectory($sourceDocumentos, $destDocumentos);
            Log::info('Documentos files restored', [
                'from' => $sourceDocumentos,
                'to' => $destDocumentos,
            ]);
        }
    }
    
    private function getLatestBackup(){
        $files = Storage::disk('backups')->allFiles();
        $backups = [];
        
        foreach ($files as $file) {
            if (str_ends_with($file, '.zip')) {
                $backups[] = [
                    'name' => $file,
                    'path' => Storage::disk('backups')->path($file),
                    'time' => Storage::disk('backups')->lastModified($file),
                ];
            }
        }
        
        if (empty($backups)) {
            return null;
        }
        
        usort($backups, fn($a, $b) => $b['time'] - $a['time']);
        
        return $backups[0];
    }
    
    private function formatBytes($bytes, $precision = 2){
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
 
    public function cleanOldBackups(){
        try {
            Artisan::call('backup:clean');
            Log::info('Old backups cleaned');
            return back()->with('success', 'Backups antiguos eliminados correctamente.');
        } catch (\Exception $e) {
            Log::error('Clean backups failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al limpiar: ' . $e->getMessage());
        }
    }

    public function wipeDatabase(Request $request){
        if (!app()->environment('local')) {
            return back()->with('error', 'Por seguridad, solo se puede eliminar la base de datos en entorno local.');
        }

        Artisan::call('db:wipe', ['--force' => true]);
        Log::warning('Database wiped', ['user_id' => auth()->id()]);

        return back()->with('success', 'Base de datos eliminada (db:wipe ejecutado correctamente).');
    }
}
