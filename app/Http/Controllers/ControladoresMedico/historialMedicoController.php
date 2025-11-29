<?php

namespace App\Http\Controllers\ControladoresMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\medical_Records;
use App\Models\UserModel;
use App\Models\patientUser;
use App\Models\vital_sign;
use App\Models\allergyRecord;
use App\Models\diseaseRecord;
use App\Models\consult_disease;
use App\Models\treatment_record;
use App\Models\appointment;
use App\Models\allergies_allergenes;
use App\Models\disease;
use App\Models\documentType;
use App\Models\allergie;
use App\Models\allergene;
use App\Models\MedicPatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\fileRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class historialMedicoController extends Controller
{
    //

    public function listarPacientes(Request $request)
    {
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        $search = $request->input('buscar');

        $patientQuery = patientUser::with('user')
            ->whereHas('medicPatient', function ($query) use ($doctorId) {
                $query->where('medic_id', $doctorId);
            });

        if (!empty($search)) {
            $patientQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', '%' . $search . '%');
                })->orWhere('id', $search);
            });
        }

        $patientUser = $patientQuery
            ->orderBy('id')
            ->paginate(5)
            ->withQueryString();

        return view('MEDICO.consulta-historial', compact('patientUser'));
    }

    public function buscarPacientesHistorial(Request $request)
    {
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        $query = $request->input('query');

        if (!$doctorId || empty($query)) {
            return response()->json([]);
        }

        $patients = patientUser::with('user')
            ->whereHas('medicPatient', function ($q) use ($doctorId) {
                $q->where('medic_id', $doctorId);
            })
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->user->name,
                    'phone' => $p->user->phone,
                    'email' => $p->user->email,
                ];
            });

        return response()->json($patients);
    }
    public function getHistorial($id){
        $patientUser = patientUser::with([
            'appointments' => function($query) {
                $query->where('status', 'completada')
                      ->orderBy('appointment_date', 'desc')
                      ->orderBy('appointment_time', 'desc');
            },
            'appointments.vitalSigns',
            'medicalRecords.allergies.allergieAllergene.allergie',
            'medicalRecords.allergies.allergieAllergene.allergene',
            'medicalRecords.consultDiseases.disease',
            'medicalRecords.consultDiseases.medications',
            'medicalRecords.diseaseRecords.disease',
            'medicalRecords.currentMedications',
            'user',
            'medicalRecords.files.documentType',
        ])->findOrFail($id);
            return response()->json($patientUser);
        //return view('MEDICO.consulta-historial', compact('patientUser'));
    }  
}
