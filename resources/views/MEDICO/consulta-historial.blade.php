@extends('plantillas.dashboard_medico')
@section('title', 'Consulta Historial - Hospital Naval')
@section('styles')
    @vite('resources/css/medic/paginas/consulta_historial_medico.css')
    @vite('resources/css/PACIENTE/paginas/paginador.css')
@endsection
@section('content')
        <header class="content-header">
            <!--<h1>Consulta de Historial Médico</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" placeholder="Buscar paciente...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
            </div>-->
        </header>

        <div class="content">
            <!-- Resultados -->
            <div class="results-section">
                <h2>Resultados de Búsqueda</h2>
                
                <div class="patient-info-card" id="patientInfo" style="display: none;">
                    <div class="patient-header">
                        <div class="patient-avatar-large">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="patient-details">
                            <h3 id="patientName">Nombre del Paciente</h3>
                            <div class="patient-meta">
                                <span id="patientAge">Edad</span> • 
                                <span id="patientGender">Género</span> • 
                                <span id="patientId">ID</span>
                            </div>
                        </div>
                    </div>
                    <div class="patient-summary">
                        <div class="summary-item">
                            <strong>Alergias:</strong>
                            <span id="patientAllergies">Ninguna registrada</span>
                        </div>
                        <div class="summary-item">
                            <strong>Enfermedades Crónicas:</strong>
                            <span id="patientChronic">Ninguna registrada</span>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    
                    <!-- Panel de Búsqueda -->
                    <form method="GET" action="{{ route('consulta-historial') }}" class="search-filters">
                        <div class="search-box">
                            <div style="position: relative;">
                                <input type="text" name="buscar" id="searchPatient" placeholder="Buscar por nombre o ID..." value="{{ request('buscar') }}">
                                <div id="sugerencias-historial" class="sugerencias-lista"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </form>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Género</th>
                                <th>Teléfono</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody id="tablaPacientes">
                                @foreach($patientUser as $patient)
                                    @if($patient->userId != null)
                                        <tr>
                                            <td>{{ $patient->id }}</td>
                                            <td>{{ $patient->user->name }}</td>
                                            <td>{{ $patient->user->birthdate }}</td>
                                            <td>{{ $patient->user->genre }}</td>
                                            <td>{{ $patient->user->phone }}</td>
                                            <td>
                                                <button class="btn-view" onclick="verHistorial({{ $patient->id }})">
                                                    Ver historial
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $patientUser->onEachSide(1)->links('plantillas.pagination') }}
                    </div>
                </div>
                
                <div class="expedienteContainer" style="display: none;">
                    <div id="historialPaciente" class="patient-history" style="margin-top: 30px;">
                
                    </div>
                    <div class="medical-info-grid">
                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Alergias</h3>
                            </div>
                            <div class="medical-card-content">
                                <div id="alergias-content">
                                    <p class="no-data">No se han registrado alergias</p>
                                </div>
                            </div>
                        </div>

                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Enfermedades Crónicas</h3>
                            </div>
                            <div class="medical-card-content">
                                <div id="enfermedades-cronicas-content">
                                    <p class="no-data">No se han registrado enfermedades crónicas</p>
                                </div>
                            </div>
                        </div>

                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Medicamentos Actuales</h3>
                            </div>
                            <div class="medical-card-content">
                                <div id="medicamentos-content">
                                    <p class="no-data">No se han registrado medicamentos</p>
                                </div>
                            </div>
                        </div>
                        <div class="medical-card">
                            <div class="medical-card-header">
                                <h3>Documentos Adjuntos</h3>
                            </div>

                            <div class="medical-card-content" id="attached-documents">
                                <div id="archivos-content">
                                    <p class="no-data">No se han encontrado archivos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modalConsulta" style="
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        ">
            <div style="
                background: white;
                padding: 20px;
                border-radius: 10px;
                width: 80%;
                max-width: 600px;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            ">
                <button id="cerrarModal" style="
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: red;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    padding: 5px 10px;
                ">X</button>

                <div id="contenidoModal">
                </div>
            </div>
        </div>
@endsection

@section('scripts')
@vite('resources/js/medic/script-consulta-historial.js')
<script>
function renderPaginatedList(
    container, 
    items, 
    renderItem, 
    emptyMessage, 
    perPage = 3
) {
    if (!items || items.length === 0) {
        container.innerHTML = `<p class="no-data">${emptyMessage}</p>`;
        return;
    }

    let currentPage = 1;
    const totalPages = Math.ceil(items.length / perPage);

    function renderPage() {
        const start = (currentPage - 1) * perPage;
        const pageItems = items.slice(start, start + perPage);

        const listHtml = pageItems.map(renderItem).join('');

        const paginationHtml = `
            <ul class="myPagination">
                <li class="myPageItem ${currentPage === 1 ? 'disabled' : ''}">
                    <button class="myPageLink" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}>&laquo;</button>
                </li>
                ${Array.from({ length: totalPages }, (_, i) => i + 1).map(page => `
                    <li class="myPageItem ${page === currentPage ? 'active' : ''}">
                        <button class="myPageLink" data-page="${page}">${page}</button>
                    </li>
                `).join('')}
                <li class="myPageItem ${currentPage === totalPages ? 'disabled' : ''}">
                    <button class="myPageLink" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''}>&raquo;</button>
                </li>
            </ul>
        `;

        container.innerHTML = listHtml + paginationHtml;

        if (totalPages <= 1) return;
        container.querySelectorAll('.myPageLink').forEach(btn => {
            const page = parseInt(btn.dataset.page, 10);
            if (!isNaN(page) && page >= 1 && page <= totalPages) {
                btn.addEventListener('click', () => {
                    currentPage = page;
                    renderPage();
                });
            }
        });
    }

    renderPage();
}

function verHistorial(id) {
    const container = document.querySelector('.expedienteContainer');
    if (container) container.style.display = 'none';

    fetch(`/obtenerDatos/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Error al obtener el historial del paciente');
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data); 

            const div = document.getElementById('historialPaciente');
            const divAlergias = document.getElementById('alergias-content');
            const divEnfermedades = document.getElementById('enfermedades-cronicas-content');
            const divMedicamentos = document.getElementById('medicamentos-content');
            const divArchivos = document.getElementById('attached-documents');
            const vitalSigns = data.vital_signs ?? [];
            const user = data.user ?? {};
            const allergies = data.medical_records?.flatMap(r => r.allergies ?? []) ?? [];
            const chronicDiseases = data.medical_records?.flatMap(r => r.disease_records ?? []) ?? [];
            const medicines = data.medical_records?.flatMap(r => r.medicines ?? []) ?? [];
            const medicalRecords = data.medical_records ?? [];
            window.vitalSignsData = vitalSigns;
            window.medicalRecordsData = medicalRecords;
            if (vitalSigns.length) {
            const cardsHtml = vitalSigns.map((vs, i) => `
                <div class="history-card">
                    <div class="history-card-header">
                        <span> fecha de consulta ${vs.appointment?.appointment_date ?? 'N/A'}</span>
                        <span>Consulta #${i + 1}</span>
                    </div>
                    <div class="history-card-body">
                        <p><strong>Paciente:</strong> ${user.name ?? 'Sin nombre'}</p>
                        <p><strong>Edad:</strong> ${user.birthdate ?? 'N/A'}</p>
                        <p><strong>Género:</strong> ${user.genre ?? 'N/A'}</p>
                        <p><strong>Teléfono:</strong> ${user.phone ?? 'N/A'}</p>

                        <div class="history-vitals">
                            <div><strong>Temp:</strong> ${vs.temperature ?? 'N/A'} °C</div>
                            <div><strong>FC:</strong> ${vs.heart_rate ?? 'N/A'} lpm</div>
                            <div><strong>Peso:</strong> ${vs.weight ?? 'N/A'} kg</div>
                            <div><strong>Altura:</strong> ${vs.height ?? 'N/A'} cm</div>
                        </div>
                    </div>
                    <div class="history-card-footer">
                        <button class="btnVerMas" onclick="abrirModal(${i})">Ver detalles</button>
                    </div>
                </div>
            `).join('');

            div.innerHTML = `
                <h3 class="history-title">
                    Historial de <strong>${user.name ?? 'Sin nombre'}</strong>
                </h3>
                <div class="history-cards-container">
                    ${cardsHtml}
                </div>
            `;
        } else {
            div.innerHTML = '<p class="no-data">No hay consultas registradas.</p>';
        }

            renderPaginatedList(divAlergias, allergies, (a) => `
                <div class="medical-item">
                    ${a.allergie_allergene?.allergie?.name ?? 'Desconocida'} 
                    - ${a.allergie_allergene?.allergene?.name ?? 'Desconocido'}
                    <span class="detail">Registrada: ${a.created_at?.slice(0,10) ?? 'N/A'}</span>
                </div>
            `, 'No se han registrado alergias');
        
            renderPaginatedList(divEnfermedades, chronicDiseases, (e) => `
                <div class="medical-item">
                    ${e.disease?.name ?? 'Desconocida'}
                    <span class="detail">Registrada: ${e.created_at?.slice(0,10) ?? 'N/A'}</span>
                </div>
            `, 'No se han registrado enfermedades crónicas');
        
            renderPaginatedList(divMedicamentos, medicines, (m) => `
                <div class="medical-item">
                    <strong>${m.medicine_name ?? 'Medicamento'}</strong>
                    <span class="detail">Dosis: ${m.dose ?? 'N/A'} - Frecuencia: ${m.frequency ?? 'N/A'}</span>
                </div>
            `, 'No se han registrado medicamentos');
        
            const archivos = (medicalRecords ?? []).flatMap(r => r.files ?? []);
            renderPaginatedList(divArchivos, archivos, (file) => `
                <div class="document-item">
                    <strong>${file.document_type?.name ?? 'Documento'}</strong>
                    <p>Subido el: ${file.upload_date ?? 'N/A'}</p>
                    <a href="/storage/${file.route}" target="_blank" class="btnVerMas">Ver documento</a>
                </div>
            `, 'No se han encontrado archivos');

            if (container) container.style.display = 'block';
        })
        .catch(error => {
            console.error('Error cargando historial:', error);
            document.getElementById('historialPaciente').innerHTML =
                '<p style="color:red;">Error al cargar el historial del paciente.</p>';
        });
}

function abrirModal(index) {
    const consulta = window.vitalSignsData[index];
    const consultDiseases = window.medicalRecordsData.flatMap(mr => mr.consult_diseases);
    const diagnosticosPerConsulta = consultDiseases.find(cd => 
        cd.appointment_id === consulta.appointment.id
    ) || {};
    const modal = document.getElementById('modalConsulta');
    const contenidoModal = document.getElementById('contenidoModal');
    const cerrarModal = document.getElementById('cerrarModal');
    const enfermedad = diagnosticosPerConsulta.disease?.name ?? 'Sin diagnóstico';
    contenidoModal.innerHTML = `
        <h3>Consulta del ${consulta.appointment?.appointment_date ?? 'N/A'}</h3>
        <p><strong>Temperatura:</strong> ${consulta.temperature ?? 'N/A'} °C</p>
        <p><strong>Frecuencia cardiaca:</strong> ${consulta.heart_rate ?? 'N/A'} lpm</p>
        <p><strong>Peso:</strong> ${consulta.weight ?? 'N/A'} kg</p>
        <p><strong>Altura:</strong> ${consulta.height ?? 'N/A'} cm</p>
        <hr>
        <p><strong>Razon de consulta: </strong> ${diagnosticosPerConsulta.reason ?? 'Sin notas adicionales'}</p>
        <p><strong>Sintomas descritos: </strong> ${diagnosticosPerConsulta.symptoms ?? 'Sin notas adicionales'}</p>
        <p><strong>Revision: </strong> ${diagnosticosPerConsulta.findings ?? 'Sin notas adicionales'}</p>
        <p><strong>Diagnóstico: </strong>  ${enfermedad}</p>
        <p><strong>Tratamiento: </strong> ${diagnosticosPerConsulta.treatment_diagnosis ?? 'Sin notas adicionales'}</p>
    `;

    modal.style.display = 'flex';

    cerrarModal.onclick = () => modal.style.display = 'none';
    modal.onclick = e => {
        if (e.target === modal) modal.style.display = 'none';
    };
}
</script>
@endsection
