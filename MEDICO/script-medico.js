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

function viewPatient(patientName) {
    console.log(`Viéndo expediente de: ${patientName}`);
    // window.location.href = `historial-paciente.html?patient=${encodeURIComponent(patientName)}`;
}

function editPatient(patientName) {
    console.log(`Editando expediente de: ${patientName}`);
    // window.location.href = `editar-expediente.html?patient=${encodeURIComponent(patientName)}`;
}

function logout() {
    console.log('Cerrando sesión...');
    localStorage.removeItem('medicoLoggedIn');
    window.location.href = 'index.html';
}

// Verificación de sesión (simulada)
function checkSession() {
    const medicoLoggedIn = localStorage.getItem('medicoLoggedIn');
    if (!medicoLoggedIn) {
        console.log('No hay sesión activa, redirigiendo al login...');
        // Para pruebas, comentar esta línea:
        // window.location.href = 'index.html';
    } else {
        console.log('Sesión activa');
    }
}

// Inicialización
checkSession();
console.log('Script médico inicializado');