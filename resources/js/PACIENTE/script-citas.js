// script-citas.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página Mis Citas cargada');
    
    // Modal nueva cita
    const nuevaCitaBtn = document.getElementById('nueva-cita');
    const nuevaCitaModal = document.getElementById('nueva-cita-modal');
    const closeModal = document.querySelector('.close-modal');
    const cancelModal = document.querySelector('.modal .btn-cancel');
    
    if (nuevaCitaBtn && nuevaCitaModal) {
        nuevaCitaBtn.addEventListener('click', function() {
            nuevaCitaModal.classList.add('active');
        });
        
        closeModal.addEventListener('click', function() {
            nuevaCitaModal.classList.remove('active');
        });
        
        cancelModal.addEventListener('click', function() {
            nuevaCitaModal.classList.remove('active');
        });
        
        // Cerrar modal al hacer clic fuera
        nuevaCitaModal.addEventListener('click', function(e) {
            if (e.target === nuevaCitaModal) {
                nuevaCitaModal.classList.remove('active');
            }
        });
    }
    
    // Formulario nueva cita
    const nuevaCitaForm = document.getElementById('nueva-cita-form');
    if (nuevaCitaForm) {
        nuevaCitaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Cita agendada exitosamente. Recibirás una confirmación por correo.');
            nuevaCitaModal.classList.remove('active');
            nuevaCitaForm.reset();
        });
    }
    
    // Filtros
    const filterStatus = document.getElementById('filter-status');
    const filterSpecialty = document.getElementById('filter-specialty');
    
    if (filterStatus) {
        filterStatus.addEventListener('change', filterAppointments);
    }
    
    if (filterSpecialty) {
        filterSpecialty.addEventListener('change', filterAppointments);
    }
    
    // Botones de acciones
    setupAppointmentButtons();
});

function setupAppointmentButtons() {
    // Botones ver detalles
    const viewButtons = document.querySelectorAll('.btn-view');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.appointment-card, tr');
            let doctorName, date, specialty;
            
            if (card.classList.contains('appointment-card')) {
                doctorName = card.querySelector('h3').textContent;
                date = card.querySelector('.appointment-details strong').textContent;
                specialty = card.querySelector('.appointment-details p:nth-child(2)').textContent.replace('Medicina General', '').replace('Cardiología', '').trim();
            } else {
                doctorName = card.querySelector('.doctor-info strong').textContent;
                date = card.querySelector('.appointment-info strong').textContent;
                specialty = card.querySelector('td:nth-child(3)').textContent;
            }
            
            alert(`Detalles de cita:\nMédico: ${doctorName}\nFecha: ${date}\nEspecialidad: ${specialty}\nEstado: Confirmada`);
        });
    });
    
    // Botones cancelar cita
    const cancelButtons = document.querySelectorAll('.btn-cancel');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.appointment-card');
            const doctorName = card.querySelector('h3').textContent;
            
            if (confirm(`¿Estás seguro de cancelar la cita con ${doctorName}?`)) {
                card.style.opacity = '0.5';
                card.querySelector('.status-badge').textContent = 'Cancelada';
                card.querySelector('.status-badge').className = 'status-badge cancelled';
                alert('Cita cancelada exitosamente');
            }
        });
    });
    
    // Botones reprogramar
    const rescheduleButtons = document.querySelectorAll('.btn-reschedule');
    rescheduleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.appointment-card');
            const doctorName = card.querySelector('h3').textContent;
            alert(`Reprogramar cita con ${doctorName}\nEsta funcionalidad abriría el calendario para seleccionar nueva fecha.`);
        });
    });
    
    // Botones descargar
    const downloadButtons = document.querySelectorAll('.btn-download');
    downloadButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const doctorName = row.querySelector('.doctor-info strong').textContent;
            const date = row.querySelector('.appointment-info strong').textContent;
            alert(`Descargando comprobante de cita con ${doctorName} del ${date}`);
        });
    });
}

function filterAppointments() {
    const statusFilter = document.getElementById('filter-status').value;
    const specialtyFilter = document.getElementById('filter-specialty').value;
    
    const appointmentCards = document.querySelectorAll('.appointment-card');
    const tableRows = document.querySelectorAll('.appointments-table tbody tr');
    
    let visibleCount = 0;
    
    // Filtrar tarjetas de citas pendientes
    appointmentCards.forEach(card => {
        const status = card.querySelector('.status-badge').textContent.toLowerCase();
        const specialty = card.querySelector('.appointment-details p:nth-child(2)').textContent.toLowerCase();
        
        const statusMatch = statusFilter === 'all' || 
                           (statusFilter === 'pending' && status === 'confirmada') ||
                           (statusFilter === 'confirmed' && status === 'confirmada');
        
        const specialtyMatch = specialtyFilter === 'all' || 
                              (specialtyFilter === 'cardiology' && specialty.includes('cardio')) ||
                              (specialtyFilter === 'general' && specialty.includes('general')) ||
                              (specialtyFilter === 'dermatology' && specialty.includes('dermato'));
        
        if (statusMatch && specialtyMatch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Filtrar filas de la tabla
    tableRows.forEach(row => {
        const status = row.querySelector('.status-badge').textContent.toLowerCase();
        const specialty = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        
        const statusMatch = statusFilter === 'all' || 
                           (statusFilter === 'completed' && status === 'completada') ||
                           (statusFilter === 'cancelled' && status === 'cancelada');
        
        const specialtyMatch = specialtyFilter === 'all' || 
                              (specialtyFilter === 'cardiology' && specialty.includes('cardio')) ||
                              (specialtyFilter === 'general' && specialty.includes('general')) ||
                              (specialtyFilter === 'dermatology' && specialty.includes('dermato'));
        
        if (statusMatch && specialtyMatch) {
            row.style.display = 'table-row';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} citas`);
}