<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminBackupController extends Controller
{
    public function backupDatabase(Request $request)
    {
        $connection = config('database.default');
        $config = config("database.connections.$connection");

        if (($config['driver'] ?? null) !== 'mysql') {
            return back()->with('error', 'El respaldo automático solo está configurado para MySQL.');
        }

        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? 3306;

        $fileName = 'backup_' . $database . '_' . now()->format('Ymd_His') . '.sql';
        $directory = storage_path('app/backups');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;
        $command = sprintf(
            '/usr/bin/mysqldump --no-tablespaces --add-drop-table --user=%s --password=%s --host=%s --port=%d %s > %s 2>&1',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            $port,
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        Log::info('Comando backup', ['cmd' => $command]);
        $exitCode = null;
        $output = [];
        exec($command, $output, $exitCode);
        Log::info('Backup output', ['exitCode' => $exitCode, 'output' => $output]);
        if ($exitCode !== 0 || !file_exists($filePath)) {
            return back()->with('error', 'No se pudo generar el respaldo. Verifica que mysqldump esté instalado y accesible.');
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function restoreDatabase(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt',
        ]);

        $connection = config('database.default');
        $config = config("database.connections.$connection");

        if (($config['driver'] ?? null) !== 'mysql') {
            return back()->with('error', 'La restauración automática solo está configurada para MySQL.');
        }

        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? 3306;

        $file = $request->file('backup_file');
        $originalName = $file->getClientOriginalName();

        if (!Str::startsWith($originalName, 'backup_' . $database . '_') || !Str::endsWith($originalName, '.sql')) {
            return back()->with('error', 'Solo se pueden restaurar respaldos generados por el sistema (backup_' . $database . '_YYYYMMDD_HHMMSS.sql).');
        }

        $storedPath = $file->storeAs(
            'backups/restores',
            'restore_' . now()->format('Ymd_His') . '.sql'
        );
        $fullPath = storage_path('app/' . $storedPath);

        $command = sprintf(
            "/usr/bin/mysql --user=%s --password=%s --host=%s --port=%d %s < %s 2>&1",
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            $port,
            escapeshellarg($database),
            escapeshellarg($fullPath)
        );

        Log::warning('Comando restore', [
            'cmd' => $command,
            'user_id' => Auth::id(),
            'user_email' => optional(Auth::user())->email,
            'original_file' => $originalName,
            'stored_path' => $storedPath,
        ]);
        $exitCode = null;
        $output = [];
        exec($command, $output, $exitCode);
        Log::warning('Restore output', [
            'exitCode' => $exitCode,
            'output' => $output,
            'user_id' => Auth::id(),
        ]);

        if ($exitCode !== 0) {
            return back()->with('error', 'No se pudo restaurar la base de datos. Revisa el archivo y los logs para más detalles.');
        }

        return back()->with('success', 'Base de datos restaurada correctamente desde el respaldo seleccionado.');
    }

    public function wipeDatabase(Request $request)
    {
        if (!app()->environment('local')) {
            return back()->with('error', 'Por seguridad, solo se puede eliminar la base de datos en entorno local.');
        }

        Artisan::call('db:wipe', ['--force' => true]);

        return back()->with('success', 'Base de datos eliminada (db:wipe ejecutado correctamente).');
    }
}
