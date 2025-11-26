<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

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
        ///Borar el disabled de ssl-mode una vez se tenga certificado en vps
        $command = sprintf(
            '/usr/bin/mysqldump --no-tablespaces --user=%s --password=%s --host=%s --port=%d %s > %s 2>&1',
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

        Log::info('Comando restore', ['cmd' => $command]);
        $exitCode = null;
        $output = [];
        exec($command, $output, $exitCode);
        Log::info('Restore output', ['exitCode' => $exitCode, 'output' => $output]);

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
