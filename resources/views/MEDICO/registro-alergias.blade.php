@extends('MEDICO.plantillas.dashboard_general')
@section('title', 'Registro alergias Médico - Hospital Naval')
@section('content')
<!-- Main Content -->
        <div class="main-content">
            <header class="content-header">
                <h1>Registro de Alergias</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" id="searchAllergies" placeholder="Buscar alergias...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Panel de Registro -->
                <div class="registration-section">
                    <div class="form-container">
                        <h3><i class="fas fa-plus-circle"></i> Registrar Nueva Alergia</h3>
                        <form id="alergiaForm" class="medical-form">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="patientSelect">Paciente *</label>
                                    <select id="patientSelect" required>
                                        <option value="">Seleccionar paciente...</option>
                                        <option value="MG-001">María González (MG-001)</option>
                                        <option value="CL-002">Carlos López (CL-002)</option>
                                        <option value="AR-003">Ana Rodríguez (AR-003)</option>
                                        <option value="PM-004">Pedro Martínez (PM-004)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="alergiaTipo">Tipo de Alergia *</label>
                                    <select id="alergiaTipo" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="medicamento">Medicamento</option>
                                        <option value="alimento">Alimento</option>
                                        <option value="ambiente">Ambiente</option>
                                        <option value="insecto">Insecto</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="alergiaNombre">Alergeno *</label>
                                    <input type="text" id="alergiaNombre" required placeholder="Ej: Penicilina, Mariscos, Polen...">
                                </div>

                                <div class="form-group">
                                    <label for="alergiaSeveridad">Severidad *</label>
                                    <select id="alergiaSeveridad" required>
                                        <option value="">Seleccionar severidad...</option>
                                        <option value="leve">Leve</option>
                                        <option value="moderada">Moderada</option>
                                        <option value="severa">Severa</option>
                                        <option value="anafilaxia">Anafilaxia</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="alergiaFecha">Fecha de Diagnóstico *</label>
                                    <input type="date" id="alergiaFecha" required>
                                </div>

                                <div class="form-group">
                                    <label for="alergiaEstado">Estado Actual</label>
                                    <select id="alergiaEstado">
                                        <option value="activa">Activa</option>
                                        <option value="inactiva">Inactiva</option>
                                        <option value="superada">Superada</option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="alergiaSintomas">Síntomas Presentados</label>
                                    <textarea id="alergiaSintomas" rows="3" placeholder="Describa los síntomas que presenta el paciente..."></textarea>
                                </div>

                                <div class="form-group full-width">
                                    <label for="alergiaTratamiento">Tratamiento/Medidas</label>
                                    <textarea id="alergiaTratamiento" rows="3" placeholder="Medicamentos o medidas para controlar la alergia..."></textarea>
                                </div>

                                <div class="form-group full-width">
                                    <label for="alergiaObservaciones">Observaciones</label>
                                    <textarea id="alergiaObservaciones" rows="2" placeholder="Observaciones adicionales..."></textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-secondary" onclick="limpiarFormulario()">
                                    <i class="fas fa-eraser"></i> Limpiar
                                </button>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save"></i> Registrar Alergia
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de Alergias Registradas -->
                <div class="allergies-list-section">
                    <h3><i class="fas fa-list"></i> Alergias Registradas</h3>
                    
                    <!-- Filtros Rápidos -->
                    <div class="quick-filters">
                        <div class="filter-tags">
                            <button class="filter-tag active" data-filter="todas">Todas</button>
                            <button class="filter-tag" data-filter="activa">Activas</button>
                            <button class="filter-tag" data-filter="medicamento">Medicamentos</button>
                            <button class="filter-tag" data-filter="alimento">Alimentos</button>
                            <button class="filter-tag" data-filter="severa">Severas</button>
                        </div>
                    </div>

                    <!-- Lista de Alergias -->
                    <div class="allergies-grid" id="allergiesGrid">
                        <!-- Las alergias se cargarán dinámicamente -->
                    </div>

                    <!-- Estadísticas -->
                    <div class="allergies-stats">
                        <div class="stat-item">
                            <div class="stat-icon severe">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-info">
                                <h4 id="statSevere">0</h4>
                                <p>Alergias Severas</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon active">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="stat-info">
                                <h4 id="statActive">0</h4>
                                <p>Alergias Activas</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon total">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="stat-info">
                                <h4 id="statTotal">0</h4>
                                <p>Total Registradas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
    <script src="script-medico.js"></script>
    <script>
        // Base de datos de alergias (simulada)
        let alergias = [
            {
                id: 1,
                pacienteId: 'MG-001',
                pacienteNombre: 'María González',
                tipo: 'medicamento',
                alergeno: 'Penicilina',
                severidad: 'severa',
                fechaDiagnostico: '2020-05-15',
                estado: 'activa',
                sintomas: 'Urticaria, dificultad respiratoria, edema facial',
                tratamiento: 'Evitar penicilinas, usar alternativas como macrólidos',
                observaciones: 'Reacción anafiláctica documentada en 2020'
            },
            {
                id: 2,
                pacienteId: 'CL-002',
                pacienteNombre: 'Carlos López',
                tipo: 'alimento',
                alergeno: 'Mariscos',
                severidad: 'moderada',
                fechaDiagnostico: '2019-08-22',
                estado: 'activa',
                sintomas: 'Urticaria, prurito, edema labial',
                tratamiento: 'Evitar crustáceos y moluscos, antihistamínicos orales',
                observaciones: 'Solo reacción a crustáceos, no a pescados'
            },
            {
                id: 3,
                pacienteId: 'AR-003',
                pacienteNombre: 'Ana Rodríguez',
                tipo: 'ambiente',
                alergeno: 'Polen de gramíneas',
                severidad: 'leve',
                fechaDiagnostico: '2021-03-10',
                estado: 'activa',
                sintomas: 'Rinitis alérgica, conjuntivitis, estornudos',
                tratamiento: 'Antihistamínicos estacionales, evitar exposición',
                observaciones: 'Sintomatología principalmente en primavera'
            }
        ];

        // Inicializar la página
        document.addEventListener('DOMContentLoaded', function() {
            mostrarAlergias(alergias);
            actualizarEstadisticas();
            configurarFiltros();
        });

        // Manejar envío del formulario
        document.getElementById('alergiaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validarFormulario()) {
                registrarAlergia();
            }
        });

        function validarFormulario() {
            const requiredFields = document.querySelectorAll('#alergiaForm [required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#ff4757';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e1e5e9';
                }
            });

            return isValid;
        }

        function registrarAlergia() {
            const nuevaAlergia = {
                id: Date.now(), // ID único basado en timestamp
                pacienteId: document.getElementById('patientSelect').value,
                pacienteNombre: document.getElementById('patientSelect').selectedOptions[0].text.split(' (')[0],
                tipo: document.getElementById('alergiaTipo').value,
                alergeno: document.getElementById('alergiaNombre').value,
                severidad: document.getElementById('alergiaSeveridad').value,
                fechaDiagnostico: document.getElementById('alergiaFecha').value,
                estado: document.getElementById('alergiaEstado').value,
                sintomas: document.getElementById('alergiaSintomas').value,
                tratamiento: document.getElementById('alergiaTratamiento').value,
                observaciones: document.getElementById('alergiaObservaciones').value
            };

            alergias.unshift(nuevaAlergia); // Agregar al inicio
            mostrarAlergias(alergias);
            actualizarEstadisticas();
            limpiarFormulario();
            
            alert('¡Alergia registrada exitosamente!');
        }

        function mostrarAlergias(listaAlergias) {
            const grid = document.getElementById('allergiesGrid');
            
            if (listaAlergias.length === 0) {
                grid.innerHTML = `
                    <div class="no-allergies">
                        <i class="fas fa-allergies"></i>
                        <h4>No hay alergias registradas</h4>
                        <p>Comienza registrando la primera alergia</p>
                    </div>
                `;
                return;
            }

            grid.innerHTML = listaAlergias.map(alergia => `
                <div class="allergy-card" data-tipo="${alergia.tipo}" data-estado="${alergia.estado}" data-severidad="${alergia.severidad}">
                    <div class="allergy-header">
                        <div class="allergy-icon ${alergia.severidad}">
                            <i class="fas ${obtenerIconoTipo(alergia.tipo)}"></i>
                        </div>
                        <div class="allergy-info">
                            <h4>${alergia.alergeno}</h4>
                            <span class="patient-name">${alergia.pacienteNombre}</span>
                            <span class="allergy-type">${obtenerNombreTipo(alergia.tipo)}</span>
                        </div>
                        <div class="allergy-severity ${alergia.severidad}">
                            ${obtenerNombreSeveridad(alergia.severidad)}
                        </div>
                    </div>
                    
                    <div class="allergy-details">
                        <div class="detail-item">
                            <strong>Diagnosticada:</strong> ${formatearFecha(alergia.fechaDiagnostico)}
                        </div>
                        <div class="detail-item">
                            <strong>Estado:</strong> 
                            <span class="status ${alergia.estado}">${alergia.estado.toUpperCase()}</span>
                        </div>
                        ${alergia.sintomas ? `
                        <div class="detail-item">
                            <strong>Síntomas:</strong> ${alergia.sintomas}
                        </div>
                        ` : ''}
                        ${alergia.tratamiento ? `
                        <div class="detail-item">
                            <strong>Tratamiento:</strong> ${alergia.tratamiento}
                        </div>
                        ` : ''}
                        ${alergia.observaciones ? `
                        <div class="detail-item">
                            <strong>Observaciones:</strong> ${alergia.observaciones}
                        </div>
                        ` : ''}
                    </div>
                    
                    <div class="allergy-actions">
                        <button class="btn-edit" onclick="editarAlergia(${alergia.id})">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn-danger" onclick="eliminarAlergia(${alergia.id})">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function obtenerIconoTipo(tipo) {
            const iconos = {
                'medicamento': 'fa-pills',
                'alimento': 'fa-utensils',
                'ambiente': 'fa-leaf',
                'insecto': 'fa-bug',
                'otro': 'fa-allergies'
            };
            return iconos[tipo] || 'fa-allergies';
        }

        function obtenerNombreTipo(tipo) {
            const nombres = {
                'medicamento': 'Medicamento',
                'alimento': 'Alimento',
                'ambiente': 'Ambiente',
                'insecto': 'Insecto',
                'otro': 'Otro'
            };
            return nombres[tipo] || tipo;
        }

        function obtenerNombreSeveridad(severidad) {
            const nombres = {
                'leve': 'Leve',
                'moderada': 'Moderada',
                'severa': 'Severa',
                'anafilaxia': 'Anafilaxia'
            };
            return nombres[severidad] || severidad;
        }

        function formatearFecha(fecha) {
            return new Date(fecha).toLocaleDateString('es-ES');
        }

        function configurarFiltros() {
            const filtros = document.querySelectorAll('.filter-tag');
            filtros.forEach(filtro => {
                filtro.addEventListener('click', function() {
                    // Remover activo de todos los filtros
                    filtros.forEach(f => f.classList.remove('active'));
                    // Activar el filtro clickeado
                    this.classList.add('active');
                    
                    const filtroSeleccionado = this.dataset.filter;
                    filtrarAlergias(filtroSeleccionado);
                });
            });
        }

        function filtrarAlergias(filtro) {
            let alergiasFiltradas = alergias;

            if (filtro !== 'todas') {
                alergiasFiltradas = alergias.filter(alergia => {
                    return alergia.estado === filtro || 
                           alergia.tipo === filtro || 
                           alergia.severidad === filtro;
                });
            }

            mostrarAlergias(alergiasFiltradas);
        }

        function actualizarEstadisticas() {
            const severas = alergias.filter(a => a.severidad === 'severa' || a.severidad === 'anafilaxia').length;
            const activas = alergias.filter(a => a.estado === 'activa').length;
            const total = alergias.length;

            document.getElementById('statSevere').textContent = severas;
            document.getElementById('statActive').textContent = activas;
            document.getElementById('statTotal').textContent = total;
        }

        function limpiarFormulario() {
            document.getElementById('alergiaForm').reset();
            const fields = document.querySelectorAll('#alergiaForm input, #alergiaForm select, #alergiaForm textarea');
            fields.forEach(field => {
                field.style.borderColor = '#e1e5e9';
            });
        }

        function editarAlergia(id) {
            const alergia = alergias.find(a => a.id === id);
            if (alergia) {
                // Llenar el formulario con los datos de la alergia
                document.getElementById('patientSelect').value = alergia.pacienteId;
                document.getElementById('alergiaTipo').value = alergia.tipo;
                document.getElementById('alergiaNombre').value = alergia.alergeno;
                document.getElementById('alergiaSeveridad').value = alergia.severidad;
                document.getElementById('alergiaFecha').value = alergia.fechaDiagnostico;
                document.getElementById('alergiaEstado').value = alergia.estado;
                document.getElementById('alergiaSintomas').value = alergia.sintomas;
                document.getElementById('alergiaTratamiento').value = alergia.tratamiento;
                document.getElementById('alergiaObservaciones').value = alergia.observaciones;
                
                alert('Formulario cargado para edición. Modifica y guarda los cambios.');
            }
        }

        function eliminarAlergia(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta alergia?')) {
                alergias = alergias.filter(a => a.id !== id);
                mostrarAlergias(alergias);
                actualizarEstadisticas();
                alert('Alergia eliminada correctamente.');
            }
        }

        // Búsqueda en tiempo real
        document.getElementById('searchAllergies').addEventListener('input', function(e) {
            const termino = e.target.value.toLowerCase();
            const alergiasFiltradas = alergias.filter(alergia => 
                alergia.alergeno.toLowerCase().includes(termino) ||
                alergia.pacienteNombre.toLowerCase().includes(termino) ||
                alergia.sintomas.toLowerCase().includes(termino)
            );
            mostrarAlergias(alergiasFiltradas);
        });
    </script>
@endsection