<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicationController;

// Medicamentos API Routes
Route::get('/medicamentos', [MedicationController::class, 'index'])->name('api.medicamentos.index');
Route::post('/medicamentos', [MedicationController::class, 'store'])->name('api.medicamentos.store');
Route::put('/medicamentos/{id}', [MedicationController::class, 'update'])->name('api.medicamentos.update');
Route::delete('/medicamentos/{id}', [MedicationController::class, 'destroy'])->name('api.medicamentos.delete');
