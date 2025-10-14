@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Paciente - Simon Feeligs')

@section('content')

<div class="dashboard-content">
    <!-- Patient Information Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Paciente</h3>
        </div>
        <div class="patient-info">
            <div class="info-item">
                <span class="info-label">ID</span>
                <span class="info-value">35444777223</span>
            </div>
            <div class="info-item">
                <span class="info-label">Edad</span>
                <span class="info-value">42</span>
            </div>
            <div class="info-item">
                <span class="info-label">Género</span>
                <span class="info-value">NON</span>
            </div>
            <div class="info-item">
                <span class="info-label">Hogar</span>
                <span class="info-value">CNAP</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contrato</span>
                <span class="info-value">No</span>
            </div>
            <div class="info-item">
                <span class="info-label">Último escaneo</span>
                <span class="info-value">28.12.24</span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="two-column-layout">
        <!-- Previous Visits -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Visitas Previas</h3>
            </div>
            <ul class="visits-list">
                <li class="visit-item">
                    <span class="visit-date">11.05.25</span>
                    <span class="visit-type">MRT Follow-up</span>
                </li>
                <li class="visit-item">
                    <span class="visit-date">25.10.24</span>
                    <span class="visit-type">Initial scan</span>
                </li>
                <li class="visit-item">
                    <span class="visit-date">08.09.24</span>
                    <span class="visit-type">Consultation</span>
                </li>
            </ul>
        </div>

        <!-- Schedule Next -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Programar Próxima</h3>
            </div>
            <div class="schedule-options">
                <div class="btn-group">
                    <button class="btn btn-primary">Programar cita</button>
                    <button class="btn btn-outline">Seguimiento en 3 meses</button>
                </div>
            </div>
            <div class="send-options" style="margin-top: 20px;">
                <h4 style="margin-bottom: 10px; font-size: 16px;">Enviar al paciente</h4>
                <button class="btn btn-outline">Enviar resultados por email</button>
            </div>
        </div>
    </div>

    <!-- Anamnesis and Actions -->
    <div class="two-column-layout">
        <!-- Anamnesis -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Anamnesis</h3>
            </div>
            <p>El escaneo MRT reciente muestra actividad cerebral normal.</p>
            <div class="btn-group">
                <button class="btn btn-outline">Abrir completo</button>
                <button class="btn btn-primary">OK</button>
            </div>
        </div>

        <!-- Create Report -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Reporte</h3>
            </div>
            <button class="btn btn-primary" style="width: 100%;">Nuevo seguimiento</button>
        </div>
    </div>
</div>

<style>
.two-column-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}

@media (max-width: 768px) {
    .two-column-layout {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection