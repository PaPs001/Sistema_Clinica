@extends('plantillas.dashboard_general')
@section('title', 'Filtrar Expedientes - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Filtrar Expedientes Médicos</h1>
                <div class="header-actions">
                    <button class="btn-primary" onclick="exportarResultados()">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                </div>
            </header>

            <div class="content">
                <!-- Panel de Filtros -->
                <div class="filters-panel">
                    <h3><i class="fas fa-sliders-h"></i> Filtros de Búsqueda</h3>
                    
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label for="filterDiagnosis">Diagnóstico</label>
                            <select id="filterDiagnosis">
                                <option value="">Todos los diagnósticos</option>
                                <option value="hipertension">Hipertensión</option>
                                <option value="diabetes">Diabetes</option>
                                <option value="infeccion">Infección Respiratoria</option>
                                <option value="gastritis">Gastritis</option>
                                <option value="artritis">Artritis</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filterAge">Rango de Edad</label>
                            <select id="filterAge">
                                <option value="">Todas las edades</option>
                                <option value="0-18">0-18 años</option>
                                <option value="19-35">19-35 años</option>
                                <option value="36-50">36-50 años</option>
                                <option value="51-65">51-65 años</option>
                                <option value="65+">65+ años</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filterGender">Género</label>
                            <select id="filterGender">
                                <option value="">Todos</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filterDateFrom">Fecha Desde</label>
                            <input type="date" id="filterDateFrom">
                        </div>

                        <div class="filter-group">
                            <label for="filterDateTo">Fecha Hasta</label>
                            <input type="date" id="filterDateTo">
                        </div>

                        <div class="filter-group">
                            <label for="filterStatus">Estado</label>
                            <select id="filterStatus">
                                <option value="">Todos</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="alta">Dado de Alta</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button class="btn-secondary" onclick="limpiarFiltros()">
                            <i class="fas fa-eraser"></i> Limpiar Filtros
                        </button>
                        <button class="btn-primary" onclick="aplicarFiltros()">
                            <i class="fas fa-search"></i> Aplicar Filtros
                        </button>
                    </div>
                </div>

                <!-- Resultados -->
                <div class="results-section">
                    <div class="results-header">
                        <h3>Resultados de la Búsqueda</h3>
                        <div class="results-count">
                            <span id="resultsCount">0</span> expedientes encontrados
                        </div>
                    </div>

                    <div class="patients-grid" id="patientsGrid">
                        <!-- Los resultados se cargarán aquí dinámicamente -->
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-cards">
                        <div class="stat-card-small">
                            <div class="stat-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="stat-info">
                                <h4 id="statDiagnosis">0</h4>
                                <p>Diagnósticos diferentes</p>
                            </div>
                        </div>
                        <div class="stat-card-small">
                            <div class="stat-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="stat-info">
                                <h4 id="statAgeAvg">0</h4>
                                <p>Edad promedio</p>
                            </div>
                        </div>
                        <div class="stat-card-small">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-info">
                                <h4 id="statRecent">0</h4>
                                <p>Últimos 30 días</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('scripts')
    <script src="script-medico.js"></script>
    <script>
        // Datos de ejemplo para filtrar
        const pacientes = [
            {
                id: 'MG-001',
                nombre: 'María González',
                edad: 35,
                genero: 'femenino',
                diagnostico: 'hipertension',
                fecha: '2024-03-15',
                estado: 'activo',
                ultimaVisita: '2024-03-15'
            },
            {
                id: 'CL-002',
                nombre: 'Carlos López',
                edad: 42,
                genero: 'masculino',
                diagnostico: 'diabetes',
                fecha: '2024-03-14',
                estado: 'activo',
                ultimaVisita: '2024-03-14'
            },
            {
                id: 'AR-003',
                nombre: 'Ana Rodríguez',
                edad: 28,
                genero: 'femenino',
                diagnostico: 'infeccion',
                fecha: '2024-03-10',
                estado: 'alta',
                ultimaVisita: '2024-03-10'
            },
            {
                id: 'PM-004',
                nombre: 'Pedro Martínez',
                edad: 55,
                genero: 'masculino',
                diagnostico: 'hipertension',
                fecha: '2024-03-08',
                estado: 'activo',
                ultimaVisita: '2024-03-08'
            }
        ];

        function aplicarFiltros() {
            const diagnosis = document.getElementById('filterDiagnosis').value;
            const age = document.getElementById('filterAge').value;
            const gender = document.getElementById('filterGender').value;
            const dateFrom = document.getElementById('filterDateFrom').value;
            const dateTo = document.getElementById('filterDateTo').value;
            const status = document.getElementById('filterStatus').value;

            let resultados = pacientes.filter(paciente => {
                let cumple = true;

                // Filtro por diagnóstico
                if (diagnosis && paciente.diagnostico !== diagnosis) {
                    cumple = false;
                }

                // Filtro por edad
                if (age) {
                    const [min, max] = age.split('-').map(Number);
                    if (max && (paciente.edad < min || paciente.edad > max)) {
                        cumple = false;
                    } else if (!max && paciente.edad < min) {
                        cumple = false;
                    }
                }

                // Filtro por género
                if (gender && paciente.genero !== gender) {
                    cumple = false;
                }

                // Filtro por fecha
                if (dateFrom && paciente.fecha < dateFrom) {
                    cumple = false;
                }
                if (dateTo && paciente.fecha > dateTo) {
                    cumple = false;
                }

                // Filtro por estado
                if (status && paciente.estado !== status) {
                    cumple = false;
                }

                return cumple;
            });

            mostrarResultados(resultados);
            actualizarEstadisticas(resultados);
        }

        function mostrarResultados(resultados) {
            const grid = document.getElementById('patientsGrid');
            const count = document.getElementById('resultsCount');
            
            count.textContent = resultados.length;

            if (resultados.length === 0) {
                grid.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h4>No se encontraron resultados</h4>
                        <p>Intenta ajustar los filtros de búsqueda</p>
                    </div>
                `;
                return;
            }

            grid.innerHTML = resultados.map(paciente => `
                <div class="patient-card">
                    <div class="patient-card-header">
                        <div class="patient-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="patient-info">
                            <h4>${paciente.nombre}</h4>
                            <span>ID: ${paciente.id}</span>
                        </div>
                        <div class="patient-status ${paciente.estado}">
                            ${paciente.estado.toUpperCase()}
                        </div>
                    </div>
                    <div class="patient-card-body">
                        <div class="patient-detail">
                            <strong>Edad:</strong> ${paciente.edad} años
                        </div>
                        <div class="patient-detail">
                            <strong>Género:</strong> ${paciente.genero === 'masculino' ? 'Masculino' : 'Femenino'}
                        </div>
                        <div class="patient-detail">
                            <strong>Diagnóstico:</strong> ${obtenerNombreDiagnostico(paciente.diagnostico)}
                        </div>
                        <div class="patient-detail">
                            <strong>Última visita:</strong> ${formatearFecha(paciente.ultimaVisita)}
                        </div>
                    </div>
                    <div class="patient-card-actions">
                        <button class="btn-view" onclick="verExpediente('${paciente.id}')">
                            <i class="fas fa-eye"></i> Ver
                        </button>
                        <button class="btn-edit" onclick="editarExpediente('${paciente.id}')">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function obtenerNombreDiagnostico(codigo) {
            const diagnosticos = {
                'hipertension': 'Hipertensión',
                'diabetes': 'Diabetes',
                'infeccion': 'Infección Respiratoria',
                'gastritis': 'Gastritis',
                'artritis': 'Artritis'
            };
            return diagnosticos[codigo] || codigo;
        }

        function formatearFecha(fecha) {
            return new Date(fecha).toLocaleDateString('es-ES');
        }

        function actualizarEstadisticas(resultados) {
            // Diagnósticos diferentes
            const diagnosticosUnicos = new Set(resultados.map(p => p.diagnostico));
            document.getElementById('statDiagnosis').textContent = diagnosticosUnicos.size;

            // Edad promedio
            const edadPromedio = resultados.length > 0 
                ? Math.round(resultados.reduce((sum, p) => sum + p.edad, 0) / resultados.length)
                : 0;
            document.getElementById('statAgeAvg').textContent = edadPromedio;

            // Pacientes últimos 30 días
            const hace30Dias = new Date();
            hace30Dias.setDate(hace30Dias.getDate() - 30);
            const recientes = resultados.filter(p => new Date(p.fecha) >= hace30Dias);
            document.getElementById('statRecent').textContent = recientes.length;
        }

        function limpiarFiltros() {
            document.getElementById('filterDiagnosis').value = '';
            document.getElementById('filterAge').value = '';
            document.getElementById('filterGender').value = '';
            document.getElementById('filterDateFrom').value = '';
            document.getElementById('filterDateTo').value = '';
            document.getElementById('filterStatus').value = '';
            
            mostrarResultados(pacientes);
            actualizarEstadisticas(pacientes);
        }

        function exportarResultados() {
            alert('Exportando resultados...');
            // Aquí iría la lógica para exportar a PDF/Excel
        }

        function verExpediente(id) {
            alert(`Viendo expediente: ${id}`);
            // window.location.href = `consulta-historial.html?patient=${id}`;
        }

        function editarExpediente(id) {
            alert(`Editando expediente: ${id}`);
            // window.location.href = `registro-expediente.html?edit=${id}`;
        }

        // Inicializar con todos los pacientes
        document.addEventListener('DOMContentLoaded', function() {
            mostrarResultados(pacientes);
            actualizarEstadisticas(pacientes);
        });
    </script>
@endsection