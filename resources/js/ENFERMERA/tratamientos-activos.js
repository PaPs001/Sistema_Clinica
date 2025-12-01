// tratamientos-activos.js - Gestión de tratamientos activos

// Filtros en tabla (estado + medicamento)
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status-filter');
    const medicationInput = document.getElementById('medication-filter');
    const clearBtn = document.getElementById('btn-clear-filters');

    function applyFilters() {
        const status = statusSelect ? statusSelect.value : 'todos';
        const medText = medicationInput ? medicationInput.value.trim().toLowerCase() : '';

        document.querySelectorAll('.treatment-row').forEach(row => {
            const rowStatus = row.dataset.status || 'En seguimiento';
            const medsCell = row.querySelector('.treatment-medications');
            const medsText = medsCell ? medsCell.textContent.toLowerCase() : '';

            const statusMatch = status === 'todos' || rowStatus === status;
            const medMatch = !medText || medsText.includes(medText);

            row.style.display = statusMatch && medMatch ? '' : 'none';
        });
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', applyFilters);
    }

    let medTimeout = null;
    if (medicationInput) {
        medicationInput.addEventListener('input', () => {
            clearTimeout(medTimeout);
            medTimeout = setTimeout(applyFilters, 300);
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (statusSelect) statusSelect.value = 'todos';
            if (medicationInput) medicationInput.value = '';
            applyFilters();
        });
    }

    applyFilters();
});

// Abrir modal de edición y cargar datos del tratamiento
// Variables globales para medicamentos
let currentMedications = [];
let consultDiseaseId = null;

// Abrir modal de edición y cargar datos del tratamiento
window.openEditModal = async function (treatmentId) {
    const modal = document.getElementById('modal-edit-treatment');
    const form = document.getElementById('form-edit-treatment');

    try {
        showLoading();

        // Resetear variables
        currentMedications = [];
        consultDiseaseId = null;
        document.getElementById('medications-list').innerHTML = '';
        document.getElementById('medication-search').value = '';

        const response = await fetch(`/tratamientos/${treatmentId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            const treatment = data.treatment;

            document.getElementById('treatment-id').value = treatment.id;
            document.getElementById('patient-name').value = treatment.patient_name;
            document.getElementById('treatment-description').value = treatment.treatment_description;
            document.getElementById('start-date').value = treatment.start_date;
            document.getElementById('prescribed-by').value = treatment.prescribed_by;
            document.getElementById('status').value = treatment.status;
            document.getElementById('end-date').value = treatment.end_date || '';
            document.getElementById('notes').value = treatment.notes || '';

            consultDiseaseId = treatment.consult_disease_id;

            // Cargar medicamentos
            if (treatment.medications) {
                currentMedications = treatment.medications;
                renderMedications();
            }

            modal.classList.add('active');
            hideLoading();
        } else {
            hideLoading();
            showNotification('Error al cargar el tratamiento', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        hideLoading();
        showNotification('Error de conexión', 'error');
    }
};

// Cerrar modal de edición
window.closeEditModal = function () {
    const modal = document.getElementById('modal-edit-treatment');
    const form = document.getElementById('form-edit-treatment');

    if (modal) {
        modal.classList.remove('active');
    }

    if (form) {
        form.reset();
    }

    const medsList = document.getElementById('medications-list');
    const medSearch = document.getElementById('medication-search');
    const resultsContainer = document.getElementById('med-search-results');

    if (medsList) medsList.innerHTML = '';
    if (medSearch) medSearch.value = '';
    if (resultsContainer) resultsContainer.style.display = 'none';

    currentMedications = [];
    consultDiseaseId = null;
};

// Renderizar lista de medicamentos
function renderMedications() {
    const container = document.getElementById('medications-list');
    container.innerHTML = '';

    currentMedications.forEach((med, index) => {
        const item = document.createElement('div');
        item.className = 'medication-item';
        item.innerHTML = `
            <span>${med.name} ${med.presentation ? `(${med.presentation})` : ''}</span>
            <button type="button" class="btn-remove-med" onclick="removeMedication(${index})">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(item);
    });
}

// Remover medicamento
window.removeMedication = function (index) {
    currentMedications.splice(index, 1);
    renderMedications();
};

// Agregar medicamento
function addMedication(med) {
    if (!currentMedications.find(m => m.id === med.id)) {
        currentMedications.push(med);
        renderMedications();
    }
    document.getElementById('medication-search').value = '';
    document.getElementById('med-search-results').style.display = 'none';
}

// Buscador de medicamentos
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('medication-search');
    const resultsContainer = document.getElementById('med-search-results');
    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                resultsContainer.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`/enfermeria/buscar-medicamentos?query=${encodeURIComponent(query)}`);
                    const meds = await response.json();

                    resultsContainer.innerHTML = '';
                    if (meds.length > 0) {
                        meds.forEach(med => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            div.textContent = `${med.name} - ${med.presentation || ''}`;
                            div.onclick = () => addMedication(med);
                            resultsContainer.appendChild(div);
                        });
                        resultsContainer.style.display = 'block';
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error searching medications:', error);
                }
            }, 300);
        });

        // Cerrar resultados al hacer clic fuera
        document.addEventListener('click', function (e) {
            if (e.target !== searchInput && e.target !== resultsContainer) {
                resultsContainer.style.display = 'none';
            }
        });
    }
});

// Manejar envío del formulario
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-edit-treatment');

    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const treatmentId = document.getElementById('treatment-id').value;
            const status = document.getElementById('status').value;
            const endDate = document.getElementById('end-date').value;
            const notes = document.getElementById('notes').value;
            const startDate = document.getElementById('start-date').value;
            const treatmentDescription = document.getElementById('treatment-description').value;

            if (endDate && new Date(endDate) < new Date(startDate)) {
                showNotification('La fecha de finalización debe ser posterior a la fecha de inicio', 'error');
                return;
            }

            try {
                showLoading();

                const response = await fetch(`/tratamientos/${treatmentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        status: status,
                        end_date: endDate || null,
                        notes: notes,
                        start_date: startDate,
                        treatment_description: treatmentDescription,
                        medications: currentMedications.map(m => m.id),
                        consult_disease_id: consultDiseaseId
                    })
                });

                const data = await response.json();

                hideLoading();

                if (data.success) {
                    showNotification(data.message || 'Tratamiento actualizado exitosamente', 'success');
                    closeEditModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Error al actualizar el tratamiento', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                hideLoading();
                showNotification('Error de conexión al actualizar', 'error');
            }
        });
    }

    // Cerrar modal al hacer clic fuera
    const modal = document.getElementById('modal-edit-treatment');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeEditModal();
            }
        });
    }
});

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => notification.classList.add('show'), 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Loading
function showLoading() {
    let loader = document.getElementById('loading-overlay');
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'loading-overlay';
        loader.innerHTML = '<div class="spinner"></div>';
        document.body.appendChild(loader);
    }
    loader.classList.add('active');
}

function hideLoading() {
    const loader = document.getElementById('loading-overlay');
    if (loader) {
        loader.classList.remove('active');
    }
}

