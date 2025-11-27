@extends('plantillas.dashboard_general')
@section('title', 'Subir Documentos - Hospital Naval')
<style>
/* ===== VARIABLES Y RESET ===== */
:root {
    --primary-color: #061175;
    --secondary-color: #0a1fa0;
    --accent-color: #667eea;
    --danger-color: #dc3545;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --text-color: #333;
    --light-bg: #f5f7fa;
    --card-bg: #ffffff;
    --border-color: #e1e5e9;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--light-bg);
    color: var(--text-color);
    line-height: 1.6;
}

/* ===== LAYOUT CON SIDEBAR ===== */
.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR FIJO (CON LAS OPCIONES QUE TE GUSTARON) ===== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
}

.clinic-info {
    padding: 30px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 20px;
    text-align: center;
}

.clinic-info h3 {
    font-size: 1.5rem;
    margin-bottom: 5px;
    font-weight: 600;
}

.clinic-info p {
    font-size: 0.9rem;
    opacity: 0.8;
}

.sidebar-menu {
    list-style: none;
    padding: 0 15px;
    flex: 1;
}

.sidebar-menu li {
    margin-bottom: 8px;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
}

.sidebar-menu a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.sidebar-menu a:hover::before {
    left: 100%;
}

.sidebar-menu a:hover {
    background: rgba(255, 255, 255, 0.15);
    border-left-color: #fff;
    transform: translateX(5px);
}

.sidebar-menu a.active {
    background: rgba(255, 255, 255, 0.2);
    border-left-color: #fff;
}

.sidebar-menu i {
    margin-right: 15px;
    width: 20px;
    text-align: center;
    font-size: 1.1rem;
}

.user-section {
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 1.2rem;
}

.user-info strong {
    display: block;
    font-size: 0.95rem;
    margin-bottom: 3px;
}

.user-info div:last-child div {
    font-size: 0.8rem;
    opacity: 0.8;
}

.weather-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.weather-info:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* ===== CONTENIDO PRINCIPAL ===== */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin-left: 280px;
    width: calc(100% - 280px);
    min-height: 100vh;
}

.content-header {
    background: white;
    padding: 20px 30px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 999;
}

.content-header h1 {
    color: var(--primary-color);
    font-size: 1.8rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* ===== CONTENIDO - OCUPANDO TODO EL ANCHO ===== */
.content {
    flex: 1;
    padding: 30px;
    overflow-y: auto;
    animation: contentFadeIn 0.8s ease-out;
}

/* ===== SECCIÓN DE SUBIDA - ANCHO COMPLETO ===== */
.upload-section {
    width: 100%;
    max-width: none;
    margin: 0;
}

.upload-card {
    background: var(--card-bg);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    height: calc(100vh - 180px);
    display: flex;
    flex-direction: column;
}

.upload-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 25px 30px;
    text-align: center;
    flex-shrink: 0;
}

.upload-header i {
    font-size: 2.8rem;
    margin-bottom: 15px;
    opacity: 0.9;
}

.upload-header h3 {
    font-size: 1.6rem;
    margin-bottom: 8px;
}

.upload-header p {
    opacity: 0.8;
    font-size: 1rem;
}

/* ===== FORMULARIO DE SUBIDA - ANCHO COMPLETO ===== */
.upload-form {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-color);
    font-size: 1rem;
}

.form-group label::after {
    content: " *";
    color: var(--danger-color);
    opacity: 0;
}

.form-group input:required + label::after,
.form-group select:required + label::after,
.form-group textarea:required + label::after {
    opacity: 1;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 14px 16px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    width: 100%;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

/* ===== DROPZONE GRANDE ===== */
.dropzone {
    border: 3px dashed var(--border-color);
    border-radius: 12px;
    padding: 50px 30px;
    text-align: center;
    transition: all 0.3s ease;
    background: #f8f9fa;
    cursor: pointer;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dropzone:hover,
.dropzone.dragover {
    border-color: var(--accent-color);
    background: #f0f4ff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.dropzone-content i {
    font-size: 3.5rem;
    color: var(--accent-color);
    margin-bottom: 20px;
}

.dropzone-content h4 {
    color: var(--primary-color);
    margin-bottom: 12px;
    font-size: 1.3rem;
}

.dropzone-content p {
    color: #666;
    margin-bottom: 0;
    font-size: 1rem;
}

/* ===== BOTONES ===== */
.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #050d5c 0%, #08188a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(6, 17, 117, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #545b62;
    transform: translateY(-2px);
}

/* ===== ARCHIVOS SELECCIONADOS ===== */
.selected-files {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid var(--border-color);
}

.selected-files h4 {
    color: var(--primary-color);
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.files-list {
    max-height: 200px;
    overflow-y: auto;
}

#fileList {
    list-style: none;
}

#fileList li {
    padding: 12px 16px;
    background: white;
    border-radius: 6px;
    margin-bottom: 8px;
    border-left: 4px solid var(--success-color);
    font-size: 0.95rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

#fileList li:last-child {
    margin-bottom: 0;
}

/* ===== SUGERENCIAS ===== */
.sugerencias-lista {
    position: absolute;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    margin-top: 4px;
}

.sugerencia-item {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.2s ease;
    font-size: 1rem;
}

.sugerencia-item:hover {
    background-color: #f8f9fa;
}

.sugerencia-item:last-child {
    border-bottom: none;
}

.text-muted {
    color: #666;
    font-style: italic;
}

/* ===== ACCIONES DEL FORMULARIO ===== */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    border-top: 1px solid var(--border-color);
    padding-top: 25px;
    margin-top: 0;
    flex-shrink: 0;
}

/* ===== ANIMACIONES ===== */
@keyframes contentFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .upload-card {
        height: auto;
        min-height: calc(100vh - 180px);
    }
}

@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
    
    .main-content {
        margin-left: 0;
        width: 100%;
    }
    
    .content {
        padding: 20px 15px;
    }
    
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .upload-header {
        padding: 20px;
    }
    
    .upload-form {
        padding: 20px;
        gap: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
    
    .dropzone {
        padding: 30px 20px;
    }
    
    .dropzone-content i {
        font-size: 2.5rem;
    }
    
    .dropzone-content h4 {
        font-size: 1.1rem;
    }
}

@media (max-width: 480px) {
    .content-header h1 {
        font-size: 1.5rem;
    }
    
    .upload-header h3 {
        font-size: 1.3rem;
    }
    
    .upload-header i {
        font-size: 2.2rem;
    }
}

/* ===== MEJORAS DE ACCESIBILIDAD ===== */
button:focus,
input:focus,
select:focus,
textarea:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}

/* ===== ESTILOS PARA CAMPOS REQUERIDOS ===== */
.form-group input:required,
.form-group select:required,
.form-group textarea:required {
    border-left: 4px solid var(--accent-color);
}
</style>

@section('content')
<div class="dashboard-container">
    <!-- Sidebar CON LAS OPCIONES QUE TE GUSTARON -->
    <aside class="sidebar">
        <div class="clinic-info">
            <h3>Hospital Naval</h3>
            <p>Sistema Médico</p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboardMedico') }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registro-expediente') }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Nuevo Expediente</span>
                </a>
            </li>
            <li>
                <a href="{{ route('consulta-historial') }}">
                    <i class="fas fa-history"></i>
                    <span>Historial Médico</span>
                </a>
            </li>
            <li>
                <a href="{{ route('iniciar-Upload-files') }}" class="active">
                    <i class="fas fa-upload"></i>
                    <span>Subir Documentos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('filtrar-expedientes') }}">
                    <i class="fas fa-filter"></i>
                    <span>Filtrar Expedientes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('registro-alergias') }}">
                    <i class="fas fa-allergies"></i>
                    <span>Antecedentes Medicos</span>
                </a>
            </li>
        </ul>
        
        <div class="user-section">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <strong>Dr. {{ Auth::user()->name }}</strong>
                    <div>Médico General</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: inherit;">
                <div class="weather-info">
                    <span>Cerrar Sesión</span>
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="main-content">
        <header class="content-header">
            <h1>Subir Documentos Médicos</h1>
        </header>

        <div class="content">
            <div class="upload-section">
                <div class="upload-card">
                    <div class="upload-header">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h3>Subir Nuevos Documentos</h3>
                        <p>Formatos permitidos: PDF, JPG, PNG, DICOM (Max. 10MB)</p>
                    </div>
                    
                    <form id="uploadForm" class="upload-form" method="post" action="{{ route('subir_archivos') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre">Nombre Paciente *</label>
                                <input type="text" id="nombre" name="nombre" required autocomplete="off">
                                <div id="sugerencias-pacientes" class="sugerencias-lista"></div>
                                <input type="hidden" id="paciente_id" name="paciente_id">
                            </div>

                            <div class="form-group">
                                <label for="documentType">Tipo de Documento *</label>
                                <select id="documentType" name="tipoDocumento" required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach($tiposDocumentos as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="documentDescription">Descripción</label>
                            <textarea name="descripcionDoc" id="documentDescription" rows="3" placeholder="Descripción del documento o hallazgos relevantes..."></textarea>
                        </div>

                        <div class="dropzone" id="dropzone">
                            <div class="dropzone-content">
                                <i class="fas fa-file-upload"></i>
                                <h4>Arrastra los archivos aquí o haz click para seleccionar</h4>
                                <p>Puedes subir múltiples archivos</p>
                                <input name="archivo[]" type="file" id="fileInput" multiple accept=".pdf,.jpg,.jpeg,.png,.dcm" required hidden>
                            </div>
                        </div>
                        
                        <div class="selected-files" id="selectedFiles">
                            <h4>Archivos seleccionados:</h4>
                            <div class="files-list">
                                <ul id="fileList"></ul>
                            </div>
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
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputNombre = document.getElementById('nombre');
    const sugerenciasDiv = document.getElementById('sugerencias-pacientes');
    const inputId = document.getElementById('paciente_id');
    
    let timeout = null;

    inputNombre.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(timeout);
        sugerenciasDiv.innerHTML = '';

        if (query.length < 2) return;

        timeout = setTimeout(() => {
            console.log("Buscando pacientes con:", query);

            fetch(`/buscar-paciente-archivos?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data);
                    sugerenciasDiv.innerHTML = '';

                    if (!Array.isArray(data)) {
                        console.error("El servidor no devolvió un array:", data);
                        return;
                    }

                    if (data.length === 0) {
                        const item = document.createElement('div');
                        item.classList.add('sugerencia-item', 'text-muted');
                        item.textContent = 'Sin resultados';
                        sugerenciasDiv.appendChild(item);
                        return;
                    }

                    data.forEach(paciente => {
                        const item = document.createElement('div');
                        item.classList.add('sugerencia-item');
                        item.textContent = paciente.user?.name ?? 'Nombre no disponible';

                        item.addEventListener('click', () => {
                            inputNombre.value = paciente.user?.name ?? '';
                            inputId.value = paciente.id;
                            sugerenciasDiv.innerHTML = '';
                        });

                        sugerenciasDiv.appendChild(item);
                    });
                })
                .catch(err => {
                    console.error("Error al buscar pacientes:", err);
                });
        }, 400);
    });

    document.addEventListener('click', (e) => {
        if (!sugerenciasDiv.contains(e.target) && e.target !== inputNombre) {
            sugerenciasDiv.innerHTML = '';
        }
    });

    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    dropzone.addEventListener('click', () => fileInput.click());

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

        const files = e.dataTransfer.files;
        fileInput.files = files; 
        mostrarArchivos(files);
    });

    fileInput.addEventListener('change', () => {
        mostrarArchivos(fileInput.files);
    });

    function mostrarArchivos(files) {
        if (files.length > 20) {
            alert("Máximo 20 archivos permitidos");
            return;
        }
        fileList.innerHTML = '';
        for (const file of files) {
            const li = document.createElement('li');
            let displaySize;

            if (file.size < 1048576) {
                displaySize = (file.size / 1024).toFixed(2) + ' KB';
            } else {
                displaySize = (file.size / 1048576).toFixed(2) + ' MB';
            }

            li.textContent = `${file.name} — ${displaySize}`;
            fileList.appendChild(li);
        }
    }

    // Función para limpiar formulario
    function limpiarFormulario() {
        document.getElementById('uploadForm').reset();
        fileList.innerHTML = '';
        inputId.value = '';
    }
});
</script>
@endsection