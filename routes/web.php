<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ControladoresMedico\mediController;
use App\Http\Controllers\ControladoresMedico\antecedentesMedicosController;
use App\Http\Controllers\ControladoresMedico\archivosMedicosController;
use App\Http\Controllers\ControladoresMedico\buscadoresController;
use App\Http\Controllers\ControladoresMedico\ExpedienteMedicoController;
use App\Http\Controllers\ControladoresMedico\historialMedicoController;
use App\Http\Controllers\ControladoresMedico\filtradoExpedientesController;
use App\Http\Controllers\passwordFirstLoginController;
use App\Http\Controllers\ControladoresPaciente\HistorialPacienteController;
use App\Http\Controllers\CorreoController;

//Administrador
use App\Http\Controllers\Administrador\RolesPermisosController;

Route::get('/', function () {
    return view('LOGIN.login');
})->name('login');
Route::post('login', [LoginController::class, 'LoginRequest'])->name('login_Attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('/cambiar-password-primera-vez', function() {return view('LOGIN.cambiar-password');})->name('password.primeravez');
    Route::post('/cambiar-password-primera-vez', [passwordFirstLoginController::class, 'actualizarPasswordInicial'])->name('password.primeravez.update');
});

Route::get('/correo-prueba', [CorreoController::class, 'pruebaCorreo']);
Route::get('/probar-recordatorio', function () {
    Artisan::call('app:recordatorios-citas');

    return "Recordatorio ejecutado (si existen citas para mañana).";
});
Route::get('/prueba-mail', function (){
    return view('PACIENTE.temporal');
});
//Rutas de paginas medico --------------------------------------------------------------
Route::middleware(['auth', 'role:medic'])->group(function (){
    Route::get('/dashboard', function(){
        return view('MEDICO.dashboard-medico');
    })->name('dashboardMedico');
    
    Route::get('/registro-expediente', function(){
        return view('MEDICO.registro-expediente');
    })->name('registro-expediente');
    
    Route::get('/filtrar-expedientes', function(){
        return view('MEDICO.filtrar-expedientes');
    })->name('filtrar-expedientes');
    
    Route::get('/registro-alergias', function(){
        return view('MEDICO.registro-alergias');
    })->name('registro-alergias');
    
    Route::post('newRecord', [ExpedienteMedicoController::class, 'storeRecord'])->name('save_medical_record');
    Route::get('/buscar-pacientes', [ExpedienteMedicoController::class, 'buscarPacientes'])->name('buscar.pacientes');
    Route::get('/consulta-historial', [historialMedicoController::class, 'listarPacientes'])->name('consulta-historial');
    Route::get('/obtenerDatos/{id}', [historialMedicoController::class, 'getHistorial'])->name('obtenerDatosHistorial');
    Route::get('/tipos-documentos', [archivosMedicosController::class, 'iniciarPaginaUploadFiles'])->name('iniciar-Upload-files');
    Route::post('subir-archivos', [archivosMedicosController::class, 'subirArchivos'])->name('subir_archivos');
    Route::get('/buscar-paciente-archivos', [buscadoresController::class, 'buscarPacienteArchivos'])->name('buscar.paciente.Archivos');
    Route::get('/buscar-diagnostico', [buscadoresController::class, 'autocompletarDiagnostico'])->name('buscar_diagnostico');
    Route::post('/filtrado-expedientes', [filtradoExpedientesController::class, 'filtradoExpedientes'])->name('filtro_Expedientes');
    Route::get('/buscar-alergenos', [buscadoresController::class, 'autocompletarAlergenos'])->name('autocompletar_Alergenos');
    Route::get('/buscar-alergias', [buscadoresController::class, 'autocompletarAlergias'])->name('autocompletar_Alergias');
    Route::post('agregar-Alergia', [antecedentesMedicosController::class, 'agregarAlergia'])->name('agregar_Alergia');
});
//Rutas a paginas paciente ---------------------------------------------------------------
Route::middleware(['auth', 'role:patient'])->group(function (){
    Route::get('/listar-consultas-dashboard-paciente', [HistorialPacienteController::class, 'listarProximasConsultas'])->name('listado.consultas');
    Route::get('/dashboard-paciente', [HistorialPacienteController::class, 'dashboard'])->name('dashboard.paciente');
    Route::get('/historial_Paciente', function(){
        return view('PACIENTE.mi-historial');
    })->name('historialPaciente');
    
    Route::get('/citas-Paciente', function(){
        return view('PACIENTE.mis-citas');
    })->name('citasPaciente');
    
    Route::get('alergias-Paciente', function(){
        return view('PACIENTE.mis-alergias');
    })->name('alergiasPaciente');
    
    Route::get('/documentos-Paciente', function(){
        return view('PACIENTE.mis-documentos');
    })->name('documentosPaciente');
    
    Route::get('/perfil-Paciente', function(){
        return view('PACIENTE.perfil-paciente');
    })->name('perfilPaciente');

    //logica Del modulo de paciente 
    
    Route::get('/datos-historial-consulta', [HistorialPacienteController::class, 'datosConsulta'])->name('datos.historial.consulta')->middleware(['auth', 'role:patient']);
    Route::get('/archivos-Historial-Medico', [HistorialPacienteController::class, 'archivosHistorialMedico'])->name('archivos.Historial.Medico');
    Route::get('/datos-antecedentes-medicos', [HistorialPacienteController::class, 'datosAntecedentesMedicos'])->name('datos.Antecedentes.Medicos');
    Route::get('/verArchivo/{id}', [HistorialPacienteController::class, 'verArchivo'])->name('ver.Archivo');
    Route::get('/archivos/descargar/{id}', [HistorialPacienteController::class, 'descargarArchivos'])->name('descargar.archivos');
    Route::get('/proximas-citas', [HistorialPacienteController::class, 'listarProximasConsultas'])->name('proximas.citas');
});



//Rutas a paginas administrador --------------------------------------------------------------
Route::get('/dashboard-admin', function(){
    return view('ADMINISTRADOR.dashboard-admin');
})->name('dashboardAdmin');

Route::get('/auditoria', function(){
    return view('ADMINISTRADOR.auditoria');
})->name('auditoria');

Route::get('/configuracion', function(){
    return view('ADMINISTRADOR.configuracion');
})->name('configuracion');

Route::get('/control-accesos', function(){
    return view('ADMINISTRADOR.control-accesos');
})->name('controlAccesos');

Route::get('/gestion-roles', [RolesPermisosController::class, 'gestionRolesPage'])->name('gestionRoles');

Route::get('/respaldo-datos', function(){
    return view('ADMINISTRADOR.respaldo-datos');
})->name('respaldoDatos');

Route::get('/cargarDatos/Roles-permisos', [RolesPermisosController::class, 'cargarRolesPermisos'])->name('cargar.Roles.Permisos');
Route::get('/cargarDatos/Usuarios-por-rol/{roleId}', [RolesPermisosController::class, 'getUserByRole'])->name('cargar.Usuarios.por.Rol');
//Rutas a paginas recepcionista --------------------------------------------------------------
Route::get('/dasboard-recepcionista', [App\Http\Controllers\ReceptionistController::class, 'dashboard'])->name('dashboardRecepcionista');

Route::get('/agenda', function(){
    return view('RECEPCIONISTA.agenda');
})->name('agenda');

Route::get('/gestion-citas', function(){
    return view('RECEPCIONISTA.gestion-citas');
})->name('gestionCitas');

Route::get('/pacientes-recepcionista', function(){
    return view('RECEPCIONISTA.pacientes-recepcion');
})->name('pacientesRecepcionista');

Route::get('/recordatorios', function(){
    return view('RECEPCIONISTA.recordatorios');
})->name('recordatorios');

Route::get('/registro-paciente', [App\Http\Controllers\PatientController::class, 'create'])->name('registroPaciente');

Route::post('/recepcionista/registrar-paciente', [App\Http\Controllers\PatientController::class, 'store'])->name('registrar.paciente.store');
Route::post('/recepcionista/check-patient', [App\Http\Controllers\AppointmentController::class, 'checkPatient'])->name('check.patient');
Route::post('/recepcionista/store-appointment', [App\Http\Controllers\AppointmentController::class, 'store'])->name('store.appointment');
Route::get('/recepcionista/get-doctors', [App\Http\Controllers\AppointmentController::class, 'getDoctors'])->name('get.doctors');
Route::get('/recepcionista/get-appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('get.appointments');
Route::post('/recepcionista/cancel-appointment/{id}', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('cancel.appointment');
Route::post('/recepcionista/update-appointment-status/{id}', [App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('update.appointment.status');


//Rutas a paginas enfermera --------------------------------------------------------------
Route::get('/dashboard-enfermera', function(){
    return view('ENFERMERA.dashboard-enfermera');
})->name('dashboardEnfermera');

Route::get('/citas-enfermera', function(){
    return view('ENFERMERA.citas-enfermera');
})->name('citasEnfermera');

Route::get('/medicamentos', function(){
    return view('ENFERMERA.medicamentos');
})->name('medicamentos');

Route::get('/pacientes-enfermera', function(){
    return view('ENFERMERA.pacientes-enfermera');
})->name('pacientesEnfermera');

Route::get('/reportes-enfermera', function(){
    return view('ENFERMERA.reportes-enfermera');
})->name('reportesEnfermera');

Route::get('/signos-vitales', function(){
    return view('ENFERMERA.signos-vitales');
})->name('signosVitales');

Route::get('/tratamientos', function(){
    return view('ENFERMERA.tratamientos');
})->name('tratamientos');