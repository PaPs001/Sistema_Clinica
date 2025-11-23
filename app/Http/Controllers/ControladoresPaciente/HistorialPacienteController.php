<?php

namespace App\Http\Controllers\ControladoresPaciente;
use Illuminate\Support\Facades\Auth;
use App\Models\patientUser;
use App\Models\fileRecord;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HistorialPacienteController extends Controller
{
    //
    public function datosConsulta(){
        $user = Auth::user();

        $consultas = $user->patient->appointments()
            ->with([
                'doctor.user',
                'consultDiseases'
            ])->get()
            ->map(function($cita){
                return [
                    'servicio' => $cita->services->name ?? 'Sin servicio',
                    'fecha' => $cita->appointment_date,
                    'doctor' => $cita->doctor->user->name ?? 'No asignado',
                    'diagnostico' => $cita->consultDiseases->first()->disease->name ?? 'Sin diagnóstico',
                    'tratamiento' => $cita->consultDiseases->first()->treatment_diagnosis ?? 'Sin tratamiento',
                    'sintomas' => $cita->consultDiseases->first()->symptoms ?? '',
                    'razon' => $cita->consultDiseases->first()->reason ?? '',
                    'revision' => $cita->consultDiseases->first()->findings ?? '',
                ];
            });
        return response()->json($consultas);
    }  

    public function archivosHistorialMedico(){
        $user = Auth::user();

        $expediente = $user->patient->medicalRecords()->first();
        if (!$expediente) {
            return response()->json([
                "data" => [],
                "current_page" => 1,
                "last_page" => 1,
                "total" => 0
            ]);
        }
        $fileRecord = $expediente->files()->paginate(1);

        return response()->json([
            "data" => $fileRecord->items(),
            "pagination" => (string) $fileRecord->onEachSide(1)->links('plantillas.pagination'),
            "current_page" => $fileRecord->currentPage(),
            "last_page" => $fileRecord->lastPage(),
            "total" => $fileRecord->total(),
        ]);
    }

    public function datosAntecedentesMedicos(){
        $user = Auth::user();

        $expediente = $user->patient->medicalRecords()->first();

        if (!$expediente) {
            return response()->json([
                "data" => [],
                "pagination" => "",
                "current_page" => 1,
                "last_page" => 1,
                "total" => 0
            ]);
        }

        $alergias = $expediente->allergies()
            ->with([
                'allergieAllergene.allergene',
                'allergieAllergene.allergie'
            ])
            ->paginate(2);

        return response()->json([
            "data" => $alergias->items(),
            "pagination" => (string) $alergias->onEachSide(1)->links('plantillas.pagination'),
            "current_page" => $alergias->currentPage(),
            "last_page" => $alergias->lastPage(),
            "total" => $alergias->total(),
        ]);
    }

    public function verArchivo($id)
    {
        $fileRecord = fileRecord::findOrFail($id);
        $ruta = storage_path('app/public/' . $fileRecord->route);

        if (!file_exists($ruta)) {
            abort(404);
        }

        $mimeType = mime_content_type($ruta);
        return response()->file($ruta, [
            'Content-Type' => $mimeType,
        ]);
    }

    public function descargarArchivos($id)
    {
        $fileRecord = fileRecord::findOrFail($id);
        $ruta = storage_path('app/public/' . $fileRecord->route);

        if (!file_exists($ruta)) {
            abort(404);
        }

        return response()->download($ruta, $fileRecord->file_name);
    }
}
