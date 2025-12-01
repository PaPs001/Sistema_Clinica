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
use App\Http\Controllers\ControladoresPaciente\PacienteDashboardController;
use App\Http\Controllers\CorreoController;

//controladores del administrador
use App\Http\Controllers\Administrador\RolesPermisosController;
use App\Http\Controllers\Administrador\AdminReportsController;
use App\Http\Controllers\Administrador\AdminBackupController;

Route::get('/', function () {
    return view('LOGIN.login');
})->name('login');
Route::post('login', [LoginController::class, 'LoginRequest'])->name('login_Attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('/cambiar-password-primera-vez', function() {return view('LOGIN.cambiar-password');})->name('password.primeravez');
    Route::post('/cambiar-password-primera-vez', [passwordFirstLoginController::class, 'actualizarPasswordInicial'])->name('password.primeravez.update');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.count');
    Route::get('/notifications/recent', [App\Http\Controllers\NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/send-reminder', [App\Http\Controllers\NotificationController::class, 'sendManualReminder'])->name('notifications.sendReminder');
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
        return view('MEDICO.pagina-principal-medico');
    })->name('dashboardMedico');
    
    Route::get('/registro-expediente', function(){
        return view('MEDICO.registro-expediente');
    })->name('registro-expediente')->middleware('permission:crear_expedientes');
    
    Route::get('/filtrar-expedientes', function(){
        return view('MEDICO.filtrar-expedientes');
    })->name('filtrar-expedientes')->middleware('permission:ver_expedientes');
    
    Route::get('/registro-alergias', function(){
        return view('MEDICO.registro-alergias');
    })->name('registro-alergias')->middleware('permission:crear_notas');
    
    Route::post('newRecord', [ExpedienteMedicoController::class, 'storeRecord'])->name('save_medical_record')->middleware('permission:crear_expedientes');
    Route::get('/buscar-pacientes', [ExpedienteMedicoController::class, 'buscarPacientes'])->name('buscar.pacientes')->middleware('permission:ver_pacientes');
    Route::get('/consulta-historial', [historialMedicoController::class, 'listarPacientes'])->name('consulta-historial')->middleware('permission:ver_expedientes');
    Route::get('/buscar-pacientes-historial', [historialMedicoController::class, 'buscarPacientesHistorial'])->name('buscar.pacientes.historial')->middleware('permission:ver_pacientes');
    Route::get('/obtenerDatos/{id}', [historialMedicoController::class, 'getHistorial'])->name('obtenerDatosHistorial')->middleware('permission:ver_su_expediente');
    Route::get('/tipos-documentos', [archivosMedicosController::class, 'iniciarPaginaUploadFiles'])->name('iniciar-Upload-files')->middleware('permission:subir_archivos');
    Route::post('subir-archivos', [archivosMedicosController::class, 'subirArchivos'])->name('subir_archivos')->middleware('permission:subir_archivos');
    Route::get('/buscar-paciente-archivos', [buscadoresController::class, 'buscarPacienteArchivos'])->name('buscar.paciente.Archivos')->middleware('permission:ver_pacientes');
    Route::get('/buscar-diagnostico', [buscadoresController::class, 'autocompletarDiagnostico'])->name('buscar_diagnostico')->middleware('permission:crear_notas');
    Route::get('/buscar-medicamentos', [buscadoresController::class, 'autocompletarMedicamentos'])->name('buscar_medicamentos')->middleware('permission:crear_notas');
    Route::post('/filtrado-expedientes', [filtradoExpedientesController::class, 'filtradoExpedientes'])->name('filtro_Expedientes')->middleware('permission:ver_expedientes');
    Route::get('/buscar-alergenos', [buscadoresController::class, 'autocompletarAlergenos'])->name('autocompletar_Alergenos')->middleware('permission:crear_notas');
    Route::get('/buscar-alergias', [buscadoresController::class, 'autocompletarAlergias'])->name('autocompletar_Alergias')->middleware('permission:crear_notas');
    Route::post('agregar-Alergia', [antecedentesMedicosController::class, 'agregarAlergia'])->name('agregar_Alergia')->middleware('permission:crear_notas');
    
    // Rutas para citas semanales y datos de paciente
    Route::get('/dashboard/citas-semanales', [App\Http\Controllers\ControladoresMedico\MedicoController::class, 'getWeeklyAppointments'])->name('dashboard.citas.semanales')->middleware('permission:ver_expedientes');
    Route::get('/cita/{id}/datos-paciente', [App\Http\Controllers\ControladoresMedico\MedicoController::class, 'getAppointmentPatientData'])->name('cita.datos.paciente')->middleware('permission:ver_su_expediente');
});
//Rutas a paginas paciente ---------------------------------------------------------------
Route::middleware(['auth', 'role:patient'])->group(function (){
    Route::get('/listar-consultas-dashboard-paciente', [HistorialPacienteController::class, 'listarProximasConsultas'])->name('listado.consultas')->middleware('permission:ver_su_expediente');
    Route::get('/dashboard-paciente', [PacienteDashboardController::class, 'show'])->name('dashboard.paciente');
    Route::get('/tratamientos-activos-paciente', [HistorialPacienteController::class, 'tratamientosActivosPaciente'])->name('tratamientos.activos.paciente')->middleware('permission:ver_su_expediente');
    Route::get('/historial_Paciente', function(){
        return view('PACIENTE.mi-historial');
    })->name('historialPaciente')->middleware('permission:ver_su_expediente');
    
    Route::get('/citas-Paciente', function(){
        return view('PACIENTE.mis-citas');
    })->name('citasPaciente')->middleware('permission:ver_su_expediente');
    
    Route::get('alergias-Paciente', function(){
        return view('PACIENTE.mis-alergias');
    })->name('alergiasPaciente')->middleware('permission:ver_su_expediente');
    
    Route::get('/documentos-Paciente', function(){
        return view('PACIENTE.mis-documentos');
    })->name('documentosPaciente')->middleware('permission:ver_su_expediente');
    
    Route::get('/perfil-Paciente', function(){
        return view('PACIENTE.perfil-paciente');
    })->name('perfilPaciente');

    //logica Del modulo de paciente 
    
    Route::get('/datos-historial-consulta', [HistorialPacienteController::class, 'datosConsulta'])->name('datos.historial.consulta')->middleware(['auth', 'role:patient', 'permission:ver_su_expediente']);
    Route::get('/archivos-Historial-Medico', [HistorialPacienteController::class, 'archivosHistorialMedico'])->name('archivos.Historial.Medico')->middleware('permission:ver_su_expediente');
    Route::get('/datos-antecedentes-medicos', [HistorialPacienteController::class, 'datosAntecedentesMedicos'])->name('datos.Antecedentes.Medicos')->middleware('permission:ver_su_expediente');
    Route::get('/verArchivo/{id}', [HistorialPacienteController::class, 'verArchivo'])->name('ver.Archivo')->middleware('permission:descargar_archivos');
    Route::get('/archivos/descargar/{id}', [HistorialPacienteController::class, 'descargarArchivos'])->name('descargar.archivos')->middleware('permission:descargar_archivos');
    Route::get('/proximas-citas', [HistorialPacienteController::class, 'listarProximasConsultas'])->name('proximas.citas')->middleware('permission:ver_su_expediente');
});



//Rutas a paginas administrador --------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])->group(function (){
    Route::get('/dashboard-admin', function(){
        return view('ADMINISTRADOR.dashboard-admin');
    })->name('dashboardAdmin');

    Route::get('/auditoria', function(){
        return view('ADMINISTRADOR.auditoria');
    })->name('auditoria')->middleware('admin.permission:ver_usuarios');

    Route::get('/configuracion', function(){
        return view('ADMINISTRADOR.configuracion');
    })->name('configuracion')->middleware('admin.permission:administrar_roles');

    Route::get('/control-accesos', function(){
        return view('ADMINISTRADOR.control-accesos');
    })->name('controlAccesos')->middleware('admin.permission:ver_usuarios');

    Route::get('/gestion-roles', [RolesPermisosController::class, 'gestionRolesPage'])
        ->name('gestionRoles')
        ->middleware('admin.permission:administrar_roles');

    Route::get('/respaldo-datos', function(){
        return view('ADMINISTRADOR.respaldo-datos');
    })->name('respaldoDatos')->middleware('admin.permission:crear_reportes');

    Route::get('/reportes/pacientes-atendidos', [AdminReportsController::class, 'pacientesAtendidos'])
        ->name('reportes.pacientesAtendidos')
        ->middleware('admin.permission:ver_reportes');
    Route::get('/reportes/pacientes-atendidos/export', [AdminReportsController::class, 'exportPacientesAtendidos'])
        ->name('reportes.pacientesAtendidos.export')
        ->middleware('admin.permission:descargar_reportes,ver_reportes');

    Route::post('/admin/backup/data', [AdminBackupController::class, 'createDataBackup'])
        ->name('admin.createDataBackup')
        ->middleware('admin.permission:crear_reportes');
    
    Route::post('/admin/backup/full', [AdminBackupController::class, 'createFullBackup'])
        ->name('admin.createFullBackup')
        ->middleware('admin.permission:crear_reportes');
    
    Route::get('/admin/backup/list', [AdminBackupController::class, 'listBackups'])
        ->name('admin.listBackups')
        ->middleware('admin.permission:crear_reportes');
    
    Route::get('/admin/backup/download/{filename}', [AdminBackupController::class, 'downloadBackup'])
        ->name('admin.downloadBackup')
        ->middleware('admin.permission:crear_reportes');
    
    Route::delete('/admin/backup/delete/{filename}', [AdminBackupController::class, 'deleteBackup'])
        ->name('admin.deleteBackup')
        ->middleware('admin.permission:crear_reportes');
    
    Route::post('/admin/backup/restore', [AdminBackupController::class, 'restoreBackup'])
        ->name('admin.restoreBackup')
        ->middleware('admin.permission:crear_reportes');
    
    Route::post('/admin/backup/clean', [AdminBackupController::class, 'cleanOldBackups'])
        ->name('admin.cleanBackups')
        ->middleware('admin.permission:crear_reportes');
    
    Route::post('/admin/backup/wipe', [AdminBackupController::class, 'wipeDatabase'])
        ->name('admin.wipeDatabase')
        ->middleware('admin.permission:crear_reportes');

    Route::get('/cargarDatos/Roles-permisos', [RolesPermisosController::class, 'cargarRolesPermisos'])
        ->name('cargar.Roles.Permisos')
        ->middleware('admin.permission:administrar_roles');
    Route::get('/cargarDatos/Usuarios-por-rol/{roleId}', [RolesPermisosController::class, 'getUserByRole'])
        ->name('cargar.Usuarios.por.Rol')
        ->middleware('admin.permission:ver_usuarios');
    Route::get('/cargarDatos/permisos/{roleId}', [RolesPermisosController::class, 'cargarPermisosPerRol'])
        ->name('cargar.Permisos.por.Rol')
        ->middleware('admin.permission:administrar_roles');
    Route::post('/permisos/{currentRoleId}/guardar-permisos', [RolesPermisosController::class, 'cambiarPermisosPerRol'])
        ->name('guardar.Permisos.por.Rol')
        ->middleware('admin.permission:asignar_permisos');
});

//Rutas a paginas recepcionista --------------------------------------------------------------
Route::middleware(['auth', 'role:receptionist'])->group(function (){
    Route::get('/dasboard-recepcionista', [App\Http\Controllers\ReceptionistController::class, 'dashboard'])->name('dashboardRecepcionista');

    Route::get('/agenda', function(){
        return view('RECEPCIONISTA.agenda');
    })->name('agenda')->middleware('permission:ver_pacientes');

    Route::get('/gestion-citas', [App\Http\Controllers\AppointmentController::class, 'indexView'])->name('gestionCitas')->middleware('permission:ver_pacientes');
    Route::get('/nueva-cita', [App\Http\Controllers\AppointmentController::class, 'createForm'])->name('crearCita')->middleware('permission:crear_citas');

    Route::get('/registro-paciente', [App\Http\Controllers\PatientController::class, 'create'])->name('registroPaciente')->middleware('permission:ver_pacientes');
    Route::get('/pacientes-recepcionista', [App\Http\Controllers\PatientController::class, 'index'])->name('pacientesRecepcionista')->middleware('permission:ver_pacientes');

    Route::get('/recordatorios', [App\Http\Controllers\AppointmentController::class, 'reminders'])->name('recordatorios')->middleware('permission:ver_pacientes');

    Route::post('/recepcionista/registrar-paciente', [App\Http\Controllers\PatientController::class, 'store'])->name('registrar.paciente.store')->middleware('permission:ver_pacientes');
    Route::post('/recepcionista/update-paciente/{id}', [App\Http\Controllers\PatientController::class, 'update'])->name('update.paciente')->middleware('permission:ver_pacientes');
    Route::post('/recepcionista/check-patient', [App\Http\Controllers\AppointmentController::class, 'checkPatient'])->name('check.patient')->middleware('permission:ver_pacientes');
    Route::post('/recepcionista/store-appointment', [App\Http\Controllers\AppointmentController::class, 'store'])->name('store.appointment')->middleware('permission:crear_citas');
    Route::get('/recepcionista/get-doctors', [App\Http\Controllers\AppointmentController::class, 'getDoctors'])->name('get.doctors')->middleware('permission:crear_citas');
    Route::get('/recepcionista/get-appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('get.appointments')->middleware('permission:ver_pacientes');
    Route::post('/recepcionista/cancel-appointment/{id}', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('cancel.appointment')->middleware('permission:editar_citas');
    Route::post('/recepcionista/update-appointment-status/{id}', [App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('update.appointment.status')->middleware('permission:editar_citas');
    Route::get('/recepcionista/search-appointments-autocomplete', [App\Http\Controllers\AppointmentController::class, 'searchPatients'])->name('search.appointments.autocomplete')->middleware('permission:ver_pacientes');
    Route::get('/recepcionista/buscar-pacientes', [App\Http\Controllers\AppointmentController::class, 'searchPatientsByName'])->name('search.patients.receptionist')->middleware('permission:ver_pacientes');
});

//Rutas a paginas enfermera --------------------------------------------------------------
Route::middleware(['auth', 'role:nurse'])->group(function (){
    Route::get('/dashboard-enfermera', function(){
        return view('ENFERMERA.dashboard-enfermera');
    })->name('dashboardEnfermera');

    Route::get('/citas-enfermera', function(){
        return view('ENFERMERA.citas-enfermera');
    })->name('citasEnfermera')->middleware('permission:ver_expedientes');

    Route::get('/medicamentos', function(){
        return view('ENFERMERA.medicamentos');
    })->name('medicamentos')->middleware('permission:ver_expedientes');

    Route::get('/pacientes-enfermera', function(){
        return view('ENFERMERA.pacientes-enfermera');
    })->name('pacientesEnfermera')->middleware('permission:ver_pacientes');

    Route::get('/reportes-enfermera', function(){
        return view('ENFERMERA.reportes-enfermera');
    })->name('reportesEnfermera')->middleware('permission:ver_expedientes');

    Route::get('/signos-vitales', function(){
        return view('ENFERMERA.signos-vitales');
    })->name('signosVitales')->middleware('permission:crear_notas');

    Route::get('/tratamientos-activos', [App\Http\Controllers\TreatmentController::class, 'activeTreatments'])->name('tratamientosActivos')->middleware('permission:editar_expedientes');
    
    // Rutas AJAX para gestión de tratamientos
    Route::get('/tratamientos/{id}', [App\Http\Controllers\TreatmentController::class, 'getTreatment'])->name('tratamientos.get')->middleware('permission:ver_expedientes');
    Route::put('/tratamientos/{id}', [App\Http\Controllers\TreatmentController::class, 'updateTreatment'])->name('tratamientos.update')->middleware('permission:editar_expedientes');

    Route::get('/tratamientos', function(){
        return view('ENFERMERA.tratamientos');
    })->name('tratamientos')->middleware('permission:editar_expedientes');
});
