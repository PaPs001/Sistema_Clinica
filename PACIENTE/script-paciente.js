// script-paciente.js - Versión mejorada para paciente
console.log('Script paciente mejorado cargado correctamente');

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

        // Buscador mejorado
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterContent(searchTerm);
            });
            
            // Agregar funcionalidad de búsqueda con Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch(this.value);
                }
            });
        }

        // Notificaciones con modal
        const notificationBell = document.querySelector('.notifications');
        const notificationsModal = document.getElementById('notifications-modal');
        const closeModal = document.querySelector('.close-modal');
        
        if (notificationBell && notificationsModal) {
            notificationBell.addEventListener('click', function() {
                notificationsModal.classList.add('active');
            });
            
            closeModal.addEventListener('click', function() {
                notificationsModal.classList.remove('active');
            });
            
            // Cerrar modal al hacer clic fuera
            notificationsModal.addEventListener('click', function(e) {
                if (e.target === notificationsModal) {
                    notificationsModal.classList.remove('active');
                }
            });
        }

        // Botones de acción en citas
        setupAppointmentButtons();

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

        // Botones de filtro y exportación
        const filterBtn = document.getElementById('filter-appointments');
        const exportBtn = document.getElementById('export-appointments');
        
        if (filterBtn) {
            filterBtn.addEventListener('click', showAppointmentFilters);
        }
        
        if (exportBtn) {
            exportBtn.addEventListener('click', exportAppointments);
        }

        console.log('Todos los event listeners configurados correctamente');
        
    } catch (error) {
        console.error('Error al configurar el dashboard:', error);
    }
});

function setupAppointmentButtons() {
    const viewButtons = document.querySelectorAll('.btn-view');
    const cancelButtons = document.querySelectorAll('.btn-cancel');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            if (row) {
                const doctorName = row.querySelector('.doctor-info strong')?.textContent || 'Médico';
                const date = row.querySelector('.appointment-info strong')?.textContent || 'Fecha';
                viewAppointmentDetails(doctorName, date);
            }
        });
    });
    
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            if (row) {
                const doctorName = row.querySelector('.doctor-info strong')?.textContent || 'Médico';
                const date = row.querySelector('.appointment-info strong')?.textContent || 'Fecha';
                cancelAppointment(doctorName, date);
            }
        });
    });
}

function filterContent(searchTerm) {
    const rows = document.querySelectorAll('.appointments-table tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const doctorName = row.querySelector('.doctor-info strong')?.textContent?.toLowerCase() || '';
        const specialty = row.querySelector('td:nth-child(3)')?.textContent?.toLowerCase() || '';
        
        if (doctorName.includes(searchTerm) || specialty.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} citas de ${rows.length}`);
}

function performSearch(searchTerm) {
    if (searchTerm.trim() === '') return;
    
    // Aquí se implementaría la búsqueda en toda la base de datos
    console.log(`Realizando búsqueda: ${searchTerm}`);
    alert(`Buscando: ${searchTerm}\nEsta funcionalidad se conectaría con el backend para búsquedas completas.`);
}

function showAppointmentFilters() {
    // Crear modal de filtros
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
        <h3>Filtrar Citas</h3>
        <div style="margin: 15px 0;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-specialty"> Filtrar por especialidad
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-date"> Filtrar por fecha
            </label>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" id="filter-doctor"> Filtrar por médico
            </label>
        </div>
        <button onclick="this.parentElement.remove()" style="
            background: #061175;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        ">Aplicar Filtros</button>
    `;
    
    document.body.appendChild(modal);
}

function exportAppointments() {
    console.log('Exportando citas...');
    alert('Exportando citas a formato PDF...\nEsta funcionalidad generaría un archivo descargable con todas las citas.');
}

function viewAppointmentDetails(doctorName, date) {
    console.log(`Viéndo detalles de cita con: ${doctorName} para el ${date}`);
    // Aquí se podría mostrar un modal con más detalles de la cita
    alert(`Cita con ${doctorName}\nFecha: ${date}\nUbicación: Consultorio asignado\nEstado: Confirmada`);
}

function cancelAppointment(doctorName, date) {
    if (confirm(`¿Estás seguro de que quieres cancelar tu cita con ${doctorName} para el ${date}?`)) {
        console.log(`Cancelando cita con: ${doctorName} para el ${date}`);
        alert('Tu cita ha sido cancelada. Puedes agendar una nueva cuando lo desees.');
        // Aquí iría la lógica para cancelar la cita en el backend
    }
}

function logout() {
    console.log('Cerrando sesión...');
    localStorage.removeItem('pacienteLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const pacienteLoggedIn = localStorage.getItem('pacienteLoggedIn');
    if (!pacienteLoggedIn) {
        console.log('No hay sesión activa, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión activa');
    }
}

// Inicialización
checkSession();
console.log('Script paciente inicializado');