// script-medico.js - Versión mejorada
console.log('Script médico cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado');
    
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

        // Notificaciones
        const notificationBell = document.querySelector('.notifications');
        if (notificationBell) {
            notificationBell.addEventListener('click', function() {
                showNotifications();
            });
        }

        // Botones de acción
        setupTableButtons();
        console.log('Todos los event listeners configurados correctamente');
        
    } catch (error) {
        console.error('Error al configurar el dashboard:', error);
    }
});

function setupTableButtons() {
    const viewButtons = document.querySelectorAll('.btn-view');
    const editButtons = document.querySelectorAll('.btn-edit');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            if (row) {
                const patientName = row.querySelector('strong')?.textContent || 'Paciente';
                viewPatient(patientName);
            }
        });
    });
    
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            if (row) {
                const patientName = row.querySelector('strong')?.textContent || 'Paciente';
                editPatient(patientName);
            }
        });
    });
}

function filterPatients(searchTerm) {
    const rows = document.querySelectorAll('.patients-table tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const patientName = row.querySelector('strong')?.textContent?.toLowerCase() || '';
        const patientId = row.querySelector('span')?.textContent?.toLowerCase() || '';
        
        if (patientName.includes(searchTerm) || patientId.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} pacientes de ${rows.length}`);
}

function showNotifications() {
    const notifications = [
        'Nuevo paciente registrado: Ana García',
        'Recordatorio: Revisar resultados de laboratorio',
        'Cita cancelada: Pedro Martínez - 16:00 hrs'
    ];
    
    // Crear modal de notificaciones
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        z-index: 1000;
        max-width: 400px;
        width: 90%;
    `;
    
    modal.innerHTML = `
        <h3>Notificaciones (3)</h3>
        <ul style="margin: 15px 0; padding-left: 20px;">
            ${notifications.map(notif => `<li>${notif}</li>`).join('')}
        </ul>
        <button onclick="this.parentElement.remove()" style="
            background: #061175;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        ">Cerrar</button>
    `;
    
    document.body.appendChild(modal);
}


// Inicialización
console.log('Script médico inicializado');

document.addEventListener('DOMContentLoaded', function () {
    const inputNombre = document.getElementById('nombre');
    const inputTelefono = document.getElementById('telefono');
    const sugerenciasDiv = document.getElementById('sugerencias-pacientes');
    const inputId = document.getElementById('paciente_id');

    // Campos adicionales
    const inputTemp = document.getElementById('temperatura');
    const inputPresion = document.getElementById('presionArterial');
    const inputFrecuencia = document.getElementById('frecuenciaCardiaca');
    const inputPeso = document.getElementById('peso');
    const inputEstatura = document.getElementById('estatura');
    const inputCitaFecha = document.getElementById('fechaConsulta');
    const inputMotivo = document.getElementById('motivoConsulta');

    let timeout = null;

    inputNombre.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(timeout);
        sugerenciasDiv.innerHTML = '';

        if (query.length < 2) return;

        timeout = setTimeout(() => {
            fetch(`/buscar-pacientes?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    sugerenciasDiv.innerHTML = '';

                    if (data.length === 0) {
                        const item = document.createElement('div');
                        item.classList.add('sugerencia-item', 'text-muted');
                        item.textContent = 'Sin resultados';
                        sugerenciasDiv.appendChild(item);
                        return;
                    }

                    // 🔁 Mostrar resultados
                    data.forEach(paciente => {
                        const item = document.createElement('div');
                        item.classList.add('sugerencia-item');
                        item.textContent = `${paciente.temporary_name} (${paciente.temporary_phone || 'Sin teléfono'})`;

                        item.addEventListener('click', () => {
                            inputNombre.value = paciente.temporary_name;
                            inputTelefono.value = paciente.temporary_phone;
                            inputId.value = paciente.id;
                            sugerenciasDiv.innerHTML = '';

                            if (paciente.signos_vitales) {
                                const sv = paciente.signos_vitales;
                                inputTemp.value = sv.temperatura ?? '';
                                inputPresion.value = sv.presion_arterial ?? '';
                                inputFrecuencia.value = sv.frecuencia_cardiaca ?? '';
                                inputPeso.value = sv.peso ?? '';
                                inputEstatura.value = sv.estatura ?? '';

                                if (paciente.signos_vitales && paciente.signos_vitales.cita) {
                                    const cita = paciente.signos_vitales.cita;
                                    inputCitaFecha.value = cita.fecha ?? '';
                                    inputMotivo.value = cita.motivo ?? '';
                                } else {
                                    inputCitaFecha.value = '';
                                    inputMotivo.value = '';
                                }
                            } else {
                                inputTemp.value = '';
                                inputPresion.value = '';
                                inputFrecuencia.value = '';
                                inputPeso.value = '';
                                inputEstatura.value = '';
                                inputCitaFecha.value = '';
                                inputMotivo.value = '';
                            }

                            console.log("✅ Paciente cargado:", paciente);
                        });

                        sugerenciasDiv.appendChild(item);
                    });
                })
                .catch(err => {
                    console.error("❌ Error al buscar pacientes:", err);
                });
        }, 400);
    });

    // Ocultar sugerencias al perder foco
    document.addEventListener('click', (e) => {
        if (!sugerenciasDiv.contains(e.target) && e.target !== inputNombre) {
            sugerenciasDiv.innerHTML = '';
        }
    });
});