// script-alergias.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página Mis Alergias cargada');
    
    // Modal nueva alergia
    const nuevaAlergiaBtn = document.getElementById('nueva-alergia');
    const nuevaAlergiaModal = document.getElementById('nueva-alergia-modal');
    const closeModal = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.btn-cancel');
    
    if (nuevaAlergiaBtn && nuevaAlergiaModal) {
        nuevaAlergiaBtn.addEventListener('click', function() {
            nuevaAlergiaModal.classList.add('active');
        });
        
        closeModal.addEventListener('click', function() {
            nuevaAlergiaModal.classList.remove('active');
        });
        
        cancelBtn.addEventListener('click', function() {
            nuevaAlergiaModal.classList.remove('active');
        });
        
        // Cerrar modal al hacer clic fuera
        nuevaAlergiaModal.addEventListener('click', function(e) {
            if (e.target === nuevaAlergiaModal) {
                nuevaAlergiaModal.classList.remove('active');
            }
        });
    }
    
    // Formulario nueva alergia
    const nuevaAlergiaForm = document.getElementById('nueva-alergia-form');
    if (nuevaAlergiaForm) {
        nuevaAlergiaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Alergia registrada exitosamente.');
            nuevaAlergiaModal.classList.remove('active');
            nuevaAlergiaForm.reset();
            
            // Aquí se agregaría la lógica para actualizar la lista de alergias
            updateAllergySummary();
        });
    }
    
    // Botones de acciones
    setupAllergyButtons();
    
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

function setupAllergyButtons() {
    // Botones editar alergia
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const allergyCard = this.closest('.allergy-card');
            const allergyName = allergyCard.querySelector('h3').textContent;
            
            alert(`Editando alergia: ${allergyName}\n\nEsta funcionalidad abriría el formulario de edición.`);
        });
    });
    
    // Botones eliminar alergia
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const allergyCard = this.closest('.allergy-card');
            const allergyName = allergyCard.querySelector('h3').textContent;
            
            if (confirm(`¿Estás seguro de eliminar la alergia a ${allergyName}?`)) {
                allergyCard.style.opacity = '0.5';
                setTimeout(() => {
                    allergyCard.remove();
                    updateAllergySummary();
                    alert('Alergia eliminada exitosamente.');
                }, 300);
            }
        });
    });
}

function updateAllergySummary() {
    const criticalAllergies = document.querySelectorAll('.allergy-card.critical').length;
    const moderateAllergies = document.querySelectorAll('.allergy-card.moderate').length;
    const mildAllergies = document.querySelectorAll('.allergy-card.mild').length;
    
    // Actualizar contadores en el resumen
    const summaryCards = document.querySelectorAll('.summary-card');
    summaryCards[0].querySelector('h3').textContent = criticalAllergies;
    summaryCards[1].querySelector('h3').textContent = moderateAllergies;
    summaryCards[2].querySelector('h3').textContent = mildAllergies;
    
    console.log(`Resumen actualizado: ${criticalAllergies} críticas, ${moderateAllergies} moderadas, ${mildAllergies} leves`);
}