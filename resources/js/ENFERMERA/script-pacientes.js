// script-pacientes.js - Versión mejorada para gestión de pacientes
console.log('Script pacientes mejorado cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado - Módulo Pacientes');
    
    try {
        // Navegación activa
        const navItems = document.querySelectorAll('.nav-item');
        if (navItems.length === 0) {
            console.error('No se encontraron elementos .nav-item');
            return;
        }
        
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                
                // Redirigir a la página correspondiente
                const href = this.getAttribute('href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });
        });

        // Buscador de pacientes
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterPatients(searchTerm);
            });
        }

        // Notificaciones con modal
        const notificationBell = document.querySelector('.notifications');
        const notificationsModal = document.getElementById('notifications-modal');
        
        if (notificationBell) {
            notificationBell.addEventListener('click', function() {
                // En una implementación real, esto abriría el modal de notificaciones
                alert('Funcionalidad de notificaciones - Se abriría el modal con las notificaciones del sistema.');
            });
        }

        // Modal de nuevo paciente
        const nuevoPacienteBtn = document.getElementById('nuevo-paciente');
        const nuevoPacienteModal = document.getElementById('nuevo-paciente-modal');
        const closeModal = document.querySelector('.close-modal');
        const cancelForm = document.getElementById('cancel-form');
        
        if (nuevoPacienteBtn && nuevoPacienteModal) {
            nuevoPacienteBtn.addEventListener('click', function() {
                nuevoPacienteModal.classList.add('active');
            });
            
            closeModal.addEventListener('click', function() {
                nuevoPacienteModal.classList.remove('active');
            });
            
            if (cancelForm) {
                cancelForm.addEventListener('click', function() {
                    nuevoPacienteModal.classList.remove('active');
                });
            }
            
            // Cerrar modal al hacer clic fuera
            nuevoPacienteModal.addEventListener('click', function(e) {
                if (e.target === nuevoPacienteModal) {
                    nuevoPacienteModal.classList.remove('active');
                }
            });
        }

        // Formulario de nuevo paciente
        const nuevoPacienteForm = document.getElementById('nuevo-paciente-form');
        if (nuevoPacienteForm) {
            nuevoPacienteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                registerNewPatient();
            });
        }

        // Selección de pacientes
        setupPatientSelection();

        // Filtros
        setupFilters();

        // Botones de acción
        setupActionButtons();

        // Logout
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                    logout();
                }
            });
        }

        console.log('Todos los event listeners configurados correctamente para pacientes');
        
    } catch (error) {
        console.error('Error al configurar la gestión de pacientes:', error);
    }
});

function setupPatientSelection() {
    const patientRows = document.querySelectorAll('.patient-row');
    
    patientRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remover selección anterior
            patientRows.forEach(r => r.classList.remove('selected'));
            
            // Agregar selección actual
            this.classList.add('selected');
            
            // Cargar detalles del paciente
            const patientId = this.getAttribute('data-patient');
            loadPatientDetails(patientId);
        });
    });
    
    // Seleccionar el primer paciente por defecto
    if (patientRows.length > 0) {
        patientRows[0].click();
    }
}

function setupFilters() {
    const filterStatus = document.getElementById('filter-status');
    const filterWard = document.getElementById('filter-ward');
    const filterDoctor = document.getElementById('filter-doctor');
    const resetFilters = document.getElementById('reset-filters');
    
    if (filterStatus) {
        filterStatus.addEventListener('change', applyFilters);
    }
    
    if (filterWard) {
        filterWard.addEventListener('change', applyFilters);
    }
    
    if (filterDoctor) {
        filterDoctor.addEventListener('change', applyFilters);
    }
    
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            filterStatus.value = '';
            filterWard.value = '';
            filterDoctor.value = '';
            applyFilters();
        });
    }
}

function setupActionButtons() {
    // Botones de exportar y actualizar
    const exportBtn = document.getElementById('export-patients');
    const refreshBtn = document.getElementById('refresh-list');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', exportPatientList);
    }
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshPatientList);
    }
    
    // Botones de acción en la tabla
    const viewButtons = document.querySelectorAll('.btn-view');
    const actionButtons = document.querySelectorAll('.btn-action');
    const editButtons = document.querySelectorAll('.btn-edit');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const row = this.closest('.patient-row');
            const patientName = row.querySelector('.patient-info strong').textContent;
            viewPatientHistory(patientName);
        });
    });
    
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const row = this.closest('.patient-row');
            const patientName = row.querySelector('.patient-info strong').textContent;
            recordVitalSigns(patientName);
        });
    });
    
    editButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const row = this.closest('.patient-row');
            const patientName = row.querySelector('.patient-info strong').textContent;
            editPatientInfo(patientName);
        });
    });
}

function filterPatients(searchTerm) {
    const patientRows = document.querySelectorAll('.patient-row');
    let visibleCount = 0;
    
    patientRows.forEach(row => {
        const patientName = row.querySelector('.patient-info strong')?.textContent?.toLowerCase() || '';
        const patientDni = row.querySelector('.patient-info span')?.textContent?.toLowerCase() || '';
        const diagnosis = row.querySelector('td:nth-child(4)')?.textContent?.toLowerCase() || '';
        
        if (patientName.includes(searchTerm) || patientDni.includes(searchTerm) || diagnosis.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} pacientes de ${patientRows.length}`);
}

function applyFilters() {
    const statusFilter = document.getElementById('filter-status').value;
    const wardFilter = document.getElementById('filter-ward').value;
    const doctorFilter = document.getElementById('filter-doctor').value;
    
    const patientRows = document.querySelectorAll('.patient-row');
    let visibleCount = 0;
    
    patientRows.forEach(row => {
        let shouldShow = true;
        
        // Filtrar por estado
        if (statusFilter && !row.classList.contains(statusFilter)) {
            shouldShow = false;
        }
        
        // Filtrar por área (simplificado para demo)
        if (wardFilter) {
            const roomText = row.querySelector('td:nth-child(2)')?.textContent?.toLowerCase() || '';
            if (wardFilter === 'icu' && !roomText.includes('uci')) {
                shouldShow = false;
            } else if (wardFilter === 'surgery' && !roomText.includes('cirugía')) {
                shouldShow = false;
            } else if (wardFilter === 'internal' && !roomText.includes('medicina')) {
                shouldShow = false;
            } else if (wardFilter === 'emergency' && !roomText.includes('urgencias')) {
                shouldShow = false;
            }
        }
        
        // Filtrar por médico (simplificado para demo)
        if (doctorFilter) {
            const doctorName = row.querySelector('td:nth-child(5)')?.textContent || '';
            if (doctorFilter === '1' && !doctorName.includes('Carlos Ruiz')) {
                shouldShow = false;
            } else if (doctorFilter === '2' && !doctorName.includes('Ana Martínez')) {
                shouldShow = false;
            } else if (doctorFilter === '3' && !doctorName.includes('Roberto Silva')) {
                shouldShow = false;
            }
        }
        
        row.style.display = shouldShow ? '' : 'none';
        if (shouldShow) visibleCount++;
    });
    
    console.log(`Filtros aplicados - Mostrando ${visibleCount} pacientes`);
}

function loadPatientDetails(patientId) {
    console.log(`Cargando detalles del paciente: ${patientId}`);
    
    // Datos de ejemplo para demo
    const patientData = {
        'carlos-ruiz': {
            name: 'Carlos Ruiz',
            age: '65 años',
            gender: 'Masculino',
            allergies: 'Penicilina',
            bloodType: 'O+',
            diagnosis: 'Hipertensión arterial severa',
            room: '304 - UCI',
            doctor: 'Dr. Carlos Ruiz',
            vitals: {
                pressure: { value: '180/110', status: 'high' },
                heartRate: { value: '92 lpm', status: 'normal' },
                temperature: { value: '37.2°C', status: 'normal' },
                oxygen: { value: '96%', status: 'normal' }
            }
        },
        'ana-lopez': {
            name: 'Ana López',
            age: '42 años',
            gender: 'Femenino',
            allergies: 'Ninguna conocida',
            bloodType: 'A+',
            diagnosis: 'Neumonía bacteriana',
            room: '205 - Medicina',
            doctor: 'Dra. Ana Martínez',
            vitals: {
                pressure: { value: '130/85', status: 'normal' },
                heartRate: { value: '88 lpm', status: 'normal' },
                temperature: { value: '39.2°C', status: 'high' },
                oxygen: { value: '92%', status: 'low' }
            }
        },
        'miguel-torres': {
            name: 'Miguel Torres',
            age: '58 años',
            gender: 'Masculino',
            allergies: 'Sulfas',
            bloodType: 'B+',
            diagnosis: 'Diabetes mellitus tipo 2',
            room: '102 - Cirugía',
            doctor: 'Dr. Roberto Silva',
            vitals: {
                pressure: { value: '125/80', status: 'normal' },
                heartRate: { value: '76 lpm', status: 'normal' },
                temperature: { value: '36.8°C', status: 'normal' },
                oxygen: { value: '98%', status: 'normal' }
            }
        }
    };
    
    const patient = patientData[patientId];
    if (!patient) return;
    
    // Actualizar información del paciente
    const patientDetails = document.getElementById('patient-details');
    patientDetails.innerHTML = `
        <div class="detail-group">
            <h4>${patient.name}</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Edad:</strong>
                    <span>${patient.age}</span>
                </div>
                <div class="detail-item">
                    <strong>Género:</strong>
                    <span>${patient.gender}</span>
                </div>
                <div class="detail-item">
                    <strong>Alergias:</strong>
                    <span>${patient.allergies}</span>
                </div>
                <div class="detail-item">
                    <strong>Grupo Sanguíneo:</strong>
                    <span>${patient.bloodType}</span>
                </div>
                <div class="detail-item">
                    <strong>Diagnóstico:</strong>
                    <span>${patient.diagnosis}</span>
                </div>
                <div class="detail-item">
                    <strong>Habitación:</strong>
                    <span>${patient.room}</span>
                </div>
                <div class="detail-item">
                    <strong>Médico Tratante:</strong>
                    <span>${patient.doctor}</span>
                </div>
                <div class="detail-item">
                    <strong>Estado:</strong>
                    <span>${patientId === 'carlos-ruiz' ? 'Crítico' : patientId === 'ana-lopez' ? 'Grave' : 'Estable'}</span>
                </div>
            </div>
        </div>
    `;
    
    // Actualizar signos vitales
    const vitalsSummary = document.getElementById('vitals-summary');
    vitalsSummary.innerHTML = `
        <div class="vital-item">
            <div class="vital-icon ${patient.vitals.pressure.status === 'high' ? 'high' : ''}">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="vital-info">
                <strong>${patient.vitals.pressure.value}</strong>
                <span>Presión Arterial</span>
            </div>
        </div>
        <div class="vital-item">
            <div class="vital-icon ${patient.vitals.heartRate.status === 'high' ? 'high' : ''}">
                <i class="fas fa-heart"></i>
            </div>
            <div class="vital-info">
                <strong>${patient.vitals.heartRate.value}</strong>
                <span>Frec. Cardíaca</span>
            </div>
        </div>
        <div class="vital-item">
            <div class="vital-icon ${patient.vitals.temperature.status === 'high' ? 'high' : ''}">
                <i class="fas fa-temperature-high"></i>
            </div>
            <div class="vital-info">
                <strong>${patient.vitals.temperature.value}</strong>
                <span>Temperatura</span>
            </div>
        </div>
        <div class="vital-item">
            <div class="vital-icon ${patient.vitals.oxygen.status === 'low' ? 'high' : ''}">
                <i class="fas fa-lungs"></i>
            </div>
            <div class="vital-info">
                <strong>${patient.vitals.oxygen.value}</strong>
                <span>Sat. Oxígeno</span>
            </div>
        </div>
    `;
}

function registerNewPatient() {
    const form = document.getElementById('nuevo-paciente-form');
    const formData = new FormData(form);
    
    // En una implementación real, aquí se enviarían los datos al servidor
    console.log('Registrando nuevo paciente...');
    
    // Simular registro exitoso
    setTimeout(() => {
        alert('Paciente registrado exitosamente en el sistema.');
        document.getElementById('nuevo-paciente-modal').classList.remove('active');
        form.reset();
        
        // En una implementación real, aquí se actualizaría la lista de pacientes
        refreshPatientList();
    }, 1000);
}

function viewPatientHistory(patientName) {
    console.log(`Viendo historial de: ${patientName}`);
    alert(`Abriendo historial médico de ${patientName}\nEsta funcionalidad mostraría el historial completo del paciente.`);
}

function recordVitalSigns(patientName) {
    console.log(`Registrando signos vitales para: ${patientName}`);
    // Simular redirección a página de signos vitales
    alert(`Redirigiendo a registro de signos vitales para ${patientName}`);
    // window.location.href = `signos-vitales.html?patient=${encodeURIComponent(patientName)}`;
}

function editPatientInfo(patientName) {
    console.log(`Editando información de: ${patientName}`);
    alert(`Editando información de ${patientName}\nEsta funcionalidad abriría un formulario de edición.`);
}

function exportPatientList() {
    console.log('Exportando lista de pacientes...');
    alert('Generando reporte de pacientes en formato PDF...\nEl reporte incluirá la lista completa de pacientes hospitalizados.');
}

function refreshPatientList() {
    console.log('Actualizando lista de pacientes...');
    // En una implementación real, aquí se haría una petición al servidor
    alert('Lista de pacientes actualizada.');
}

function logout() {
    console.log('Cerrando sesión de enfermera...');
    localStorage.removeItem('enfermeraLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const enfermeraLoggedIn = localStorage.getItem('enfermeraLoggedIn');
    if (!enfermeraLoggedIn) {
        console.log('No hay sesión activa de enfermera, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión de enfermera activa');
    }
}

// Inicialización
checkSession();
console.log('Script pacientes inicializado');