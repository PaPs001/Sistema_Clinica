// script-signos.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página Signos Vitales cargada');
    
    // Botón nuevo registro
    const nuevoRegistroBtn = document.getElementById('nuevo-registro');
    if (nuevoRegistroBtn) {
        nuevoRegistroBtn.addEventListener('click', showNewVitalSignsForm);
    }
    
    // Filtros
    const filterPatient = document.getElementById('filter-patient');
    const filterDate = document.getElementById('filter-date');
    
    if (filterPatient) {
        filterPatient.addEventListener('change', filterVitalSigns);
    }
    
    if (filterDate) {
        filterDate.addEventListener('change', filterVitalSigns);
    }
    
    // Botones de acción en la tabla
    setupTableActions();
    
    // Navegación activa
    const currentPage = window.location.pathname.split('/').pop();
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        if (item.getAttribute('href') === currentPage) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
});

function showNewVitalSignsForm() {
    const formHTML = `
        <div class="modal-overlay active">
            <div class="modal">
                <div class="modal-header">
                    <h3>Nuevo Registro de Signos Vitales</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="new-vitals-form">
                        <div class="form-group">
                            <label>Paciente</label>
                            <select required>
                                <option value="">Seleccionar paciente</option>
                                <option value="1">Carlos Ruiz - Hab. 304</option>
                                <option value="2">Ana López - Hab. 205</option>
                                <option value="3">Miguel Torres - Hab. 102</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Presión Arterial (mmHg)</label>
                            <input type="text" placeholder="Ej: 120/80" required>
                        </div>
                        <div class="form-group">
                            <label>Frecuencia Cardíaca (lpm)</label>
                            <input type="number" placeholder="Ej: 75" required>
                        </div>
                        <div class="form-group">
                            <label>Temperatura (°C)</label>
                            <input type="number" step="0.1" placeholder="Ej: 36.8" required>
                        </div>
                        <div class="form-group">
                            <label>Frecuencia Respiratoria (rpm)</label>
                            <input type="number" placeholder="Ej: 16" required>
                        </div>
                        <div class="form-group">
                            <label>Sat. Oxígeno (%)</label>
                            <input type="number" placeholder="Ej: 98" required>
                        </div>
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea rows="3" placeholder="Notas adicionales..."></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel">Cancelar</button>
                            <button type="submit" class="btn-primary">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', formHTML);
    setupVitalsModal();
}

function setupVitalsModal() {
    const modal = document.querySelector('.modal-overlay');
    const closeBtn = modal.querySelector('.close-modal');
    const cancelBtn = modal.querySelector('.btn-cancel');
    const form = document.getElementById('new-vitals-form');
    
    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Obtener datos del formulario
        const formData = new FormData(form);
        const patientSelect = form.querySelector('select');
        const patientText = patientSelect.options[patientSelect.selectedIndex].text;
        
        alert(`Signos vitales registrados exitosamente para: ${patientText}`);
        modal.remove();
        
        // Aquí se agregaría el nuevo registro a la tabla
        addNewVitalSignsRecord(formData, patientText);
    });
}

function setupTableActions() {
    // Botones editar
    const editButtons = document.querySelectorAll('.btn-view');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            editVitalSigns(patientName, row);
        });
    });
    
    // Botones eliminar
    const deleteButtons = document.querySelectorAll('.btn-cancel');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const patientName = row.querySelector('.patient-info strong').textContent;
            deleteVitalSigns(patientName, row);
        });
    });
}

function editVitalSigns(patientName, row) {
    alert(`Editando signos vitales de: ${patientName}\n\nEsta funcionalidad abriría el formulario con los datos actuales.`);
}

function deleteVitalSigns(patientName, row) {
    if (confirm(`¿Estás seguro de eliminar el registro de signos vitales de ${patientName}?`)) {
        row.style.opacity = '0.5';
        setTimeout(() => {
            row.remove();
            alert('Registro eliminado exitosamente.');
        }, 500);
    }
}

function filterVitalSigns() {
    const patientFilter = document.getElementById('filter-patient').value;
    const dateFilter = document.getElementById('filter-date').value;
    
    const rows = document.querySelectorAll('.vitals-table tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        let showRow = true;
        
        // Filtrar por paciente
        if (patientFilter) {
            const patientSelect = row.querySelector('.patient-info strong').textContent.toLowerCase();
            const filterPatientName = document.getElementById('filter-patient').options[document.getElementById('filter-patient').selectedIndex].text.toLowerCase();
            showRow = showRow && patientSelect.includes(filterPatientName.split(' ')[0].toLowerCase());
        }
        
        // Filtrar por fecha (simulado)
        if (dateFilter && showRow) {
            // En una implementación real, aquí se compararían las fechas
            showRow = showRow && true; // Simulación
        }
        
        row.style.display = showRow ? '' : 'none';
        if (showRow) visibleCount++;
    });
    
    console.log(`Mostrando ${visibleCount} registros de signos vitales`);
}

function addNewVitalSignsRecord(formData, patientText) {
    // Esta función agregaría el nuevo registro a la tabla
    // Por ahora, solo mostramos un mensaje
    console.log('Agregando nuevo registro:', formData, patientText);
    
    // En una implementación real, aquí se agregaría la nueva fila a la tabla
    // con los datos del formulario
}