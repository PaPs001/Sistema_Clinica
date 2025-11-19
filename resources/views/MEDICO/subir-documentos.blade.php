@extends('plantillas.dashboard_general')
@section('title', 'Subir Documentos - Hospital Naval')
@section('content')
            <header class="content-header">
                <h1>Subir Documentos Médicos</h1>
                <!--<div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar paciente...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>-->
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
                        
                        <form id="uploadForm" class="upload-form" method="post" action="{{ route('subir_archivos') }}" enctype="multipart/form-data">
                            @csrf
                                <label for="nombre">Nombre Paciente *</label>
                                <input type="text" id="nombre" name="nombre" required autocomplete="off">
                                <div id="sugerencias-pacientes" class="sugerencias-lista"></div>
                                <input type="hidden" id="paciente_id" name="paciente_id">
                            </div>

                            <div class="form-group">
                                <label for="documentType">Tipo de Documento *</label>
                                <select id="documentType" name="tipoDocumento" required>
                                    <option value="">-- Seleccione un tipo de documento --</option>
                                    @foreach($tiposDocumentos as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="documentDescription">Descripción</label>
                                <textarea name="descripcionDoc" id="documentDescription" rows="3" placeholder="Descripción del documento o hallazgos relevantes..."></textarea>
                            </div>

                            <!-- Área de Dropzone -->
                            <div class="dropzone" id="dropzone">
                                <div class="dropzone-content">
                                    <i class="fas fa-file-upload"></i>
                                    <h4>Arrastra los archivos aquí o haz click para seleccionar</h4>
                                    <p>Puedes subir múltiples archivos</p>
                                    <input name="archivo[]" type="file" id="fileInput" multiple accept=".pdf,.jpg,.jpeg,.png,.dcm" required hidden>
                                    <!--<button type="button" class="btn-secondary" onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-folder-open"></i> Seleccionar Archivos
                                    </button>-->
                                </div>
                            </div>
                            <ul id="fileList"></ul>

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
});
</script>
@endsection