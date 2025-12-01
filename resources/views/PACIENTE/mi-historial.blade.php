@extends('plantillas.dashboard_paciente')
@section('title', 'Historial - Hospital Naval')
@section('content')
    <header class="content-header">
        <h1>Mi Historial Médico</h1>
        <div class="header-actions">
            @include('partials.header-notifications')
        </div>
    </header>

    <div class="content">
        <div class="history-tabs mb-4" style="margin-bottom: 20px;">
            <button class="tab-btn active" data-tab="tab-consultas">
                <i class="fas fa-stethoscope"></i> Consultas
            </button>
            <button class="tab-btn" data-tab="tab-examenes">
                <i class="fas fa-vial"></i> Exámenes
            </button>
            <button class="tab-btn" data-tab="tab-antecedentes">
                <i class="fas fa-notes-medical"></i> Alergias / Antecedentes
            </button>
        </div>

        <div class="tab-content active info-card" id="tab-consultas">
            <div>
                <h2><i class="fas fa-stethoscope"></i> Historial de Consultas</h2>
            </div>
            <!-- Template de las consultas para vision dinamica -->
            @include('plantillas.formularios.PACIENTE.template-consultas')
            <div id="lista-consultas" class="file-grid"></div>
            <div class="pagination-container mt-3 text-center" id="paginationContainer-consulta">
                <!-- Los controles de paginación se cargarán aquí -->
            </div>
        </div>

        <div class="tab-content info-card" id="tab-examenes">
            <div>
                <h2><i class="fas fa-vial"></i> Exámenes y Procedimientos</h2>
            </div>
            @include('plantillas.formularios.PACIENTE.template-archivos')
            <div id="lista-archivos" class="file-grid"></div>
            <div class="pagination-container mt-3 text-center" id="paginationContainer-archivos">
                <!-- Los controles de paginación se cargarán aquí -->
            </div>
        </div>

        <div class="tab-content info-card" id="tab-antecedentes">
            <div>
                <h2><i class="fas fa-notes-medical"></i> Alergias y Antecedentes Médicos</h2>
            </div>
            @include('plantillas.formularios.PACIENTE.template-antecedentes')
            <div id="lista-antecedentes" class="file-grid"></div>
            <div class="pagination-container mt-3 text-center" id="paginationContainer-antecedentes">
                <!-- Los controles de paginación se cargarán aquí -->
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
    .file-card.tipo-pdf {
        background-image: url("{{ asset('icons/pdf.png') }}");
    }
    .file-card.tipo-word {
        background-image: url("{{ asset('icons/word.png') }}");
    }
    .file-card.tipo-excel {
        background-image: url("{{ asset('icons/excel.png') }}");
    }
    .file-card.tipo-img {
        background-image: url("{{ asset('icons/jpg-file.png') }}");
    }
    </style>
@endsection
@section('scripts')
    @vite(['resources/js/PACIENTE/script-paciente.js'])
@endsection