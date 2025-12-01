<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\EnfermeraController;

// Medicamentos API Routes
Route::get('/medicamentos', [MedicationController::class, 'index'])->name('api.medicamentos.index');
Route::post('/medicamentos', [MedicationController::class, 'store'])->name('api.medicamentos.store');
Route::put('/medicamentos/{id}', [MedicationController::class, 'update'])->name('api.medicamentos.update');
Route::delete('/medicamentos/{id}', [MedicationController::class, 'destroy'])->name('api.medicamentos.delete');

// Rutas de Enfermera
// Signos Vitales
Route::get('/signos-vitales', [EnfermeraController::class, 'getSignos']);
Route::post('/signos-vitales', [EnfermeraController::class, 'storeSignos']);
Route::put('/signos-vitales/{id}', [EnfermeraController::class, 'updateSignos']);
Route::delete('/signos-vitales/{id}', [EnfermeraController::class, 'deleteSignos']);

// Tratamientos
Route::get('/tratamientos', [EnfermeraController::class, 'getTratamientos']);
Route::post('/tratamientos', [EnfermeraController::class, 'storeTratamiento']);
Route::put('/tratamientos/{id}', [EnfermeraController::class, 'updateTratamiento']);
Route::delete('/tratamientos/{id}', [EnfermeraController::class, 'deleteTratamiento']);

// Citas para Signos Vitales (vista enfermera)
Route::get('/citas-signos', [EnfermeraController::class, 'getCitasParaSignos']);

// Citas
Route::get('/citas', [EnfermeraController::class, 'getCitas']);
Route::post('/citas', [EnfermeraController::class, 'storeCita']);
Route::put('/citas/{id}', [EnfermeraController::class, 'updateCita']);
Route::delete('/citas/{id}', [EnfermeraController::class, 'deleteCita']);

// Pacientes y Médicos (Utilidades)
Route::get('/pacientes', [EnfermeraController::class, 'getPacientes']);
Route::get('/medicos', [EnfermeraController::class, 'getMedicos']);
Route::get('/servicios', [EnfermeraController::class, 'getServicios']);

// Dashboard
Route::get('/dashboard/alertas', [EnfermeraController::class, 'getAlertas']);
Route::get('/dashboard/tareas', [EnfermeraController::class, 'getTareas']);

// Reportes
Route::post('/reportes/generar', [EnfermeraController::class, 'generarReporte']);
Route::post('/reportes/exportar', [EnfermeraController::class, 'exportarDatos']);
