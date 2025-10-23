@extends('MEDICO.plantillas.dashboard_general')
@section('title', 'Subir Documentos - Hospital Naval')
@section('content')
    <!-- Main Content -->
        <div class="main-content">
            <header class="content-header">
                <h1>Subir Documentos Médicos</h1>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar paciente...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </header>

            <div class="content">
                <!-- Panel de Subida -->
                <div class="upload-section">
                    <div class="upload-card">
                        <div class="upload-header">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h3>Subir Nuevos Documentos</h3>
                            <p>Formatos permitidos: PDF, JPG, PNG, DICOM (Max. 10MB)</p>
                        </div>
                        
                        <form id="uploadForm" class="upload-form">
                            <div class="form-group">
                                <label for="patientSelect">Seleccionar Paciente *</label>
                                <select id="patientSelect" required>
                                    <option value="">Seleccionar paciente...</option>
                                    <option value="MG-001">María González (MG-001)</option>
                                    <option value="CL-002">Carlos López (CL-002)</option>
                                    <option value="AR-003">Ana Rodríguez (AR-003)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="documentType">Tipo de Documento *</label>
                                <select id="documentType" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="radiografia">Radiografía</option>
                                    <option value="analisis">Análisis de Laboratorio</option>
                                    <option value="ecografia">Ecografía</option>
                                    <option value="tomografia">Tomografía</option>
                                    <option value="resonancia">Resonancia Magnética</option>
                                    <option value="receta">Receta Médica</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="documentDate">Fecha del Estudio *</label>
                                <input type="date" id="documentDate" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="documentDescription">Descripción</label>
                                <textarea id="documentDescription" rows="3" placeholder="Descripción del documento o hallazgos relevantes..."></textarea>
                            </div>

                            <!-- Área de Dropzone -->
                            <div class="dropzone" id="dropzone">
                                <div class="dropzone-content">
                                    <i class="fas fa-file-upload"></i>
                                    <h4>Arrastra los archivos aquí o haz click para seleccionar</h4>
                                    <p>Puedes subir múltiples archivos</p>
                                    <input type="file" id="fileInput" multiple accept=".pdf,.jpg,.jpeg,.png,.dcm" style="display: none;">
                                    <button type="button" class="btn-secondary" onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-folder-open"></i> Seleccionar Archivos
                                    </button>
                                </div>
                            </div>

                            <!-- Archivos seleccionados -->
                            <div class="selected-files" id="selectedFiles">
                                <h4>Archivos seleccionados:</h4>
                                <div class="files-list" id="filesList"></div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-secondary" onclick="limpiarFormulario()">
                                    <i class="fas fa-eraser"></i> Limpiar
                                </button>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-upload"></i> Subir Documentos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Documentos Recientes -->
                <div class="recent-documents">
                    <h2>Documentos Subidos Recientemente</h2>
                    <div class="documents-grid">
                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="document-info">
                                <h4>Radiografía Torax.pdf</h4>
                                <p><strong>Paciente:</strong> María González</p>
                                <p><strong>Tipo:</strong> Radiografía</p>
                                <p><strong>Fecha:</strong> 15 Mar 2024</p>
                                <p><strong>Tamaño:</strong> 2.4 MB</p>
                            </div>
                            <div class="document-actions">
                                <button class="btn-view" onclick="verDocumento(1)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-edit" onclick="descargarDocumento(1)">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-danger" onclick="eliminarDocumento(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-file-image"></i>
                            </div>
                            <div class="document-info">
                                <h4>Analisis_Sangre.jpg</h4>
                                <p><strong>Paciente:</strong> Carlos López</p>
                                <p><strong>Tipo:</strong> Análisis Laboratorio</p>
                                <p><strong>Fecha:</strong> 14 Mar 2024</p>
                                <p><strong>Tamaño:</strong> 1.8 MB</p>
                            </div>
                            <div class="document-actions">
                                <button class="btn-view" onclick="verDocumento(2)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-edit" onclick="descargarDocumento(2)">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn-danger" onclick="eliminarDocumento(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        // Script específico para subir documentos
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const filesList = document.getElementById('filesList');
        const selectedFiles = document.getElementById('selectedFiles');

        let uploadedFiles = [];

        // Configurar dropzone
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        dropzone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            for (let file of files) {
                if (validateFile(file)) {
                    uploadedFiles.push(file);
                    displayFile(file);
                }
            }
            updateSelectedFilesVisibility();
        }

        function validateFile(file) {
            const validTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/dicom'];
            const maxSize = 10 * 1024 * 1024; // 10MB

            if (!validTypes.includes(file.type)) {
                alert('Tipo de archivo no permitido: ' + file.type);
                return false;
            }

            if (file.size > maxSize) {
                alert('El archivo es demasiado grande: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                return false;
            }

            return true;
        }

        function displayFile(file) {
            const fileElement = document.createElement('div');
            fileElement.className = 'file-item';
            fileElement.innerHTML = `
                <div class="file-info">
                    <i class="fas fa-file"></i>
                    <span>${file.name}</span>
                    <small>(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                </div>
                <button type="button" class="btn-danger" onclick="removeFile('${file.name}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            filesList.appendChild(fileElement);
        }

        function removeFile(fileName) {
            uploadedFiles = uploadedFiles.filter(file => file.name !== fileName);
            const fileElement = Array.from(filesList.children).find(child => 
                child.querySelector('span').textContent === fileName
            );
            if (fileElement) {
                fileElement.remove();
            }
            updateSelectedFilesVisibility();
        }

        function updateSelectedFilesVisibility() {
            if (uploadedFiles.length > 0) {
                selectedFiles.style.display = 'block';
            } else {
                selectedFiles.style.display = 'none';
            }
        }

        function limpiarFormulario() {
            document.getElementById('uploadForm').reset();
            uploadedFiles = [];
            filesList.innerHTML = '';
            updateSelectedFilesVisibility();
        }

        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (uploadedFiles.length === 0) {
                alert('Por favor, selecciona al menos un archivo.');
                return;
            }

            // Simular subida de archivos
            const formData = new FormData();
            uploadedFiles.forEach(file => {
                formData.append('documents', file);
            });

            // Mostrar progreso
            alert(`Subiendo ${uploadedFiles.length} archivo(s)...`);
            
            // Simular subida exitosa
            setTimeout(() => {
                alert('¡Documentos subidos exitosamente!');
                limpiarFormulario();
            }, 2000);
        });

        function verDocumento(id) {
            alert(`Viendo documento #${id}`);
        }

        function descargarDocumento(id) {
            alert(`Descargando documento #${id}`);
        }

        function eliminarDocumento(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este documento?')) {
                alert(`Documento #${id} eliminado`);
            }
        }

        // Ocultar sección de archivos seleccionados inicialmente
        updateSelectedFilesVisibility();
    </script>
@endsection