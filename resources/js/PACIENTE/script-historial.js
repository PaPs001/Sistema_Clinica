// script-historial.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página Mi Historial cargada');
    
    // Botones de ver resultados
    const viewButtons = document.querySelectorAll('.btn-view');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const examCard = this.closest('.exam-card');
            const examName = examCard.querySelector('h4').textContent;
            const examDate = examCard.querySelector('p strong').textContent;
            
            alert(`Ver resultado de: ${examName}\nFecha: ${examDate}\n\nEsta funcionalidad mostraría el documento completo del examen.`);
        });
    });

    // Búsqueda en historial
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterHistory(searchTerm);
        });
    }
});

function filterHistory(searchTerm) {
    const timelineItems = document.querySelectorAll('.timeline-item');
    const examCards = document.querySelectorAll('.exam-card');
    const medRecords = document.querySelectorAll('.medication-record');
    
    let visibleCount = 0;
    
    // Filtrar consultas
    timelineItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Filtrar exámenes
    examCards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Filtrar medicamentos
    medRecords.forEach(record => {
        const text = record.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            record.style.display = 'flex';
            visibleCount++;
        } else {
            record.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} elementos del historial`);
}