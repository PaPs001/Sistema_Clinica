@extends('plantillas.dashboard_paciente')
@section('title', 'Historial - Hospital Naval')
@section('content')
    <header class="content-header">
        <h1>Mi Historial Médico</h1>
        <div class="header-actions">
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">2</span>
            </div>
        </div>
    </header>
    <div class="history-tabs">
        <button class="tab-btn active" data-tab="tab-consultas">
            <i class="fas fa-stethoscope"></i> Consultas
        </button>
        <button class="tab-btn" data-tab="tab-examenes">
            <i class="fas fa-vial"></i> Exámenes
        </button>
        <!--<button class="tab-btn" data-tab="tab-consultas">
            <i class="fas fa-pills"></i> Consultas
        </button>-->
        <button class="tab-btn" data-tab="tab-antecedentes">
            <i class="fas fa-notes-medical"></i> Alergias / Antecedentes
        </button>
    </div>  
    <div class="tab-content active" id="tab-consultas">
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
    <div class="tab-content" id="tab-examenes">
        <div>
            <h2><i class="fas fa-vial"></i> Exámenes y Procedimientos</h2>
        </div>
        @include('plantillas.formularios.PACIENTE.template-archivos')
        <div id="lista-archivos" class="file-grid"></div>
        <div class="pagination-container mt-3 text-center" id="paginationContainer-archivos">
                        <!-- Los controles de paginación se cargarán aquí -->
        </div>
    </div>
    <!--<div class="tab-content" id="tab-medicamentos">
        <h2><i class="fas fa-pills"></i> Consultas pasadas</h2>
        <div class="accordion">
            <div class="accordion-item">
                <button class="accordion-header">
                    <span>Losartán 50mg — Mar 2024 - Actual</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="accordion-body">
                    <p><strong>Dosis:</strong> 1 diaria</p>
                    <p><strong>Para:</strong> Hipertensión</p>
                    <p><strong>Estado:</strong> Activo</p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-header">
                    <span>Atorvastatina 20mg — Feb 2023 - Actual</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="accordion-body">
                    <p><strong>Dosis:</strong> 1 diaria</p>
                    <p><strong>Para:</strong> Colesterol</p>
                    <p><strong>Estado:</strong> Activo</p>
                </div>
            </div>
        </div>
    </div>-->
    <div class="tab-content" id="tab-antecedentes">
        <div>
            <h2><i class="fas fa-notes-medical"></i> Alergias y Antecedentes Médicos</h2>
        </div>
        @include('plantillas.formularios.PACIENTE.template-antecedentes');
        <div id="lista-antecedentes" class="file-grid"></div>
        <div class="pagination-container mt-3 text-center" id="paginationContainer-antecedentes">
                        <!-- Los controles de paginación se cargarán aquí -->
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