@extends('plantillas.dashboard_paciente')
@section('title', 'Mis Documentos - Hospital Naval')
@section('content')
        <div class="main-content">
            <header class="content-header">
                <h1>Mis Documentos Médicos</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar documentos...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Filtros y Estadísticas -->
                <div class="documents-header">
                    <div class="stats-cards">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="stat-info">
                                <h3>24</h3>
                                <p>Documentos Totales</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <div class="stat-info">
                                <h3>8</h3>
                                <p>Descargados</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <h3>5</h3>
                                <p>Nuevos</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="filters">
                        <select id="filter-type">
                            <option value="all">Todos los tipos</option>
                            <option value="results">Resultados</option>
                            <option value="reports">Reportes</option>
                            <option value="prescriptions">Recetas</option>
                            <option value="images">Imágenes</option>
                        </select>
                        <select id="filter-date">
                            <option value="all">Cualquier fecha</option>
                            <option value="week">Última semana</option>
                            <option value="month">Último mes</option>
                            <option value="year">Último año</option>
                        </select>
                    </div>
                </div>

                <!-- Documentos Recientes -->
                <div class="documents-section">
                    <h2><i class="fas fa-history"></i> Documentos Recientes</h2>
                    <div class="documents-grid">
                        <div class="document-card">
                            <div class="document-icon pdf">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="document-info">
                                <h4>Resultados Laboratorio Completo</h4>
                                <p><strong>Tipo:</strong> Resultados de Análisis</p>
                                <p><strong>Fecha:</strong> 15 Mar 2024</p>
                                <p><strong>Tamaño:</strong> 2.4 MB</p>
                            </div>
                            <div class="document-actions">
                                <button class="btn-view"><i class="fas fa-eye"></i> Ver</button>
                                <button class="btn-download"><i class="fas fa-download"></i> Descargar</button>
                                <button class="btn-share"><i class="fas fa-share"></i> Compartir</button>
                            </div>
                        </div>

                        <div class="document-card">
                            <div class="document-icon image">
                                <i class="fas fa-file-image"></i>
                            </div>
                            <div class="document-info">
                                <h4>Radiografía Torácica</h4>
                                <p><strong>Tipo:</strong> Imagen Médica</p>
                                <p><strong>Fecha:</strong> 10 Mar 2024</p>
                                <p><strong>Tamaño:</strong> 5.7 MB</p>
                            </div>
                            <div class="document-actions">
                                <button class="btn-view"><i class="fas fa-eye"></i> Ver</button>
                                <button class="btn-download"><i class="fas fa-download"></i> Descargar</button>
                                <button class="btn-share"><i class="fas fa-share"></i> Compartir</button>
                            </div>
                        </div>

                        <div class="document-card">
                            <div class="document-icon prescription">
                                <i class="fas fa-prescription"></i>
                            </div>
                            <div class="document-info">
                                <h4>Receta Médica - Losartán</h4>
                                <p><strong>Tipo:</strong> Receta</p>
                                <p><strong>Fecha:</strong> 15 Mar 2024</p>
                                <p><strong>Tamaño:</strong> 1.1 MB</p>
                            </div>
                            <div class="document-actions">
                                <button class="btn-view"><i class="fas fa-eye"></i> Ver</button>
                                <button class="btn-download"><i class="fas fa-download"></i> Descargar</button>
                                <button class="btn-share"><i class="fas fa-share"></i> Compartir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Todos los Documentos -->
                <div class="documents-section">
                    <h2><i class="fas fa-folder-open"></i> Todos los Documentos</h2>
                    <div class="documents-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th>Tamaño</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="document-info-table">
                                            <div class="doc-icon pdf">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div>
                                                <strong>Electrocardiograma</strong>
                                                <span>Estudio cardíaco completo</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Resultado</td>
                                    <td>10 Mar 2024</td>
                                    <td>3.2 MB</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view-sm"><i class="fas fa-eye"></i></button>
                                            <button class="btn-download-sm"><i class="fas fa-download"></i></button>
                                            <button class="btn-share-sm"><i class="fas fa-share"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="document-info-table">
                                            <div class="doc-icon report">
                                                <i class="fas fa-file-medical"></i>
                                            </div>
                                            <div>
                                                <strong>Informe Consulta Cardiología</strong>
                                                <span>Dr. Carlos Ruiz</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Reporte</td>
                                    <td>15 Mar 2024</td>
                                    <td>1.8 MB</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view-sm"><i class="fas fa-eye"></i></button>
                                            <button class="btn-download-sm"><i class="fas fa-download"></i></button>
                                            <button class="btn-share-sm"><i class="fas fa-share"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="document-info-table">
                                            <div class="doc-icon image">
                                                <i class="fas fa-file-image"></i>
                                            </div>
                                            <div>
                                                <strong>Ecografía Abdominal</strong>
                                                <span>Estudio completo</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Imagen</td>
                                    <td>28 Feb 2024</td>
                                    <td>8.5 MB</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view-sm"><i class="fas fa-eye"></i></button>
                                            <button class="btn-download-sm"><i class="fas fa-download"></i></button>
                                            <button class="btn-share-sm"><i class="fas fa-share"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    <!-- Modal Compartir -->
    <div class="modal-overlay" id="share-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Compartir Documento</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="share-options">
                    <div class="share-option">
                        <i class="fas fa-envelope"></i>
                        <span>Correo Electrónico</span>
                    </div>
                    <div class="share-option">
                        <i class="fas fa-print"></i>
                        <span>Imprimir</span>
                    </div>
                    <div class="share-option">
                        <i class="fas fa-link"></i>
                        <span>Copiar Enlace</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-cancel">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts') 
    @vite(['resources/js/PACIENTE/script-documentos.js'])
@endsection