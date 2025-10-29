// script-documentos.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página Mis Documentos cargada');
    
    // Filtros
    const filterType = document.getElementById('filter-type');
    const filterDate = document.getElementById('filter-date');
    
    if (filterType) {
        filterType.addEventListener('change', filterDocuments);
    }
    
    if (filterDate) {
        filterDate.addEventListener('change', filterDocuments);
    }
    
    // Búsqueda
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            searchDocuments(searchTerm);
        });
    }
    
    // Botones de acciones
    setupDocumentButtons();
    
    // Modal compartir
    setupShareModal();
    
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

function setupDocumentButtons() {
    // Botones ver documento
    const viewButtons = document.querySelectorAll('.btn-view, .btn-view-sm');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const documentCard = this.closest('.document-card, tr');
            let documentName;
            
            if (documentCard.classList.contains('document-card')) {
                documentName = documentCard.querySelector('h4').textContent;
            } else {
                documentName = documentCard.querySelector('strong').textContent;
            }
            
            alert(`Viendo documento: ${documentName}\n\nEsta funcionalidad abriría el visor de documentos.`);
        });
    });
    
    // Botones descargar
    const downloadButtons = document.querySelectorAll('.btn-download, .btn-download-sm');
    downloadButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const documentCard = this.closest('.document-card, tr');
            let documentName;
            
            if (documentCard.classList.contains('document-card')) {
                documentName = documentCard.querySelector('h4').textContent;
            } else {
                documentName = documentCard.querySelector('strong').textContent;
            }
            
            alert(`Descargando: ${documentName}\n\nEl documento comenzará a descargarse.`);
            
            // Simular descarga
            setTimeout(() => {
                alert('Descarga completada exitosamente.');
            }, 1000);
        });
    });
}

function setupShareModal() {
    const shareButtons = document.querySelectorAll('.btn-share, .btn-share-sm');
    const shareModal = document.getElementById('share-modal');
    const closeModal = document.querySelector('#share-modal .close-modal');
    const cancelBtn = document.querySelector('#share-modal .btn-cancel');
    const shareOptions = document.querySelectorAll('.share-option');
    
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const documentCard = this.closest('.document-card, tr');
            let documentName;
            
            if (documentCard.classList.contains('document-card')) {
                documentName = documentCard.querySelector('h4').textContent;
            } else {
                documentName = documentCard.querySelector('strong').textContent;
            }
            
            // Actualizar título del modal con el nombre del documento
            shareModal.querySelector('h3').textContent = `Compartir: ${documentName}`;
            shareModal.classList.add('active');
        });
    });
    
    closeModal.addEventListener('click', function() {
        shareModal.classList.remove('active');
    });
    
    cancelBtn.addEventListener('click', function() {
        shareModal.classList.remove('active');
    });
    
    // Cerrar modal al hacer clic fuera
    shareModal.addEventListener('click', function(e) {
        if (e.target === shareModal) {
            shareModal.classList.remove('active');
        }
    });
    
    // Opciones de compartir
    shareOptions.forEach(option => {
        option.addEventListener('click', function() {
            const action = this.querySelector('span').textContent;
            alert(`Compartiendo documento vía: ${action}\n\nEsta funcionalidad abriría la opción seleccionada.`);
            shareModal.classList.remove('active');
        });
    });
}

function filterDocuments() {
    const typeFilter = document.getElementById('filter-type').value;
    const dateFilter = document.getElementById('filter-date').value;
    
    const documentCards = document.querySelectorAll('.document-card');
    const tableRows = document.querySelectorAll('.documents-table tbody tr');
    
    let visibleCount = 0;
    
    // Filtrar tarjetas de documentos
    documentCards.forEach(card => {
        const type = card.querySelector('p:nth-child(2)').textContent.toLowerCase();
        const dateText = card.querySelector('p:nth-child(3)').textContent;
        const date = new Date(dateText.replace('Fecha: ', ''));
        
        const typeMatch = typeFilter === 'all' || 
                         (typeFilter === 'results' && type.includes('resultados')) ||
                         (typeFilter === 'reports' && type.includes('reporte')) ||
                         (typeFilter === 'prescriptions' && type.includes('receta')) ||
                         (typeFilter === 'images' && type.includes('imagen'));
        
        const dateMatch = dateFilter === 'all' || checkDateFilter(date, dateFilter);
        
        if (typeMatch && dateMatch) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Filtrar filas de la tabla
    tableRows.forEach(row => {
        const type = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const dateText = row.querySelector('td:nth-child(3)').textContent;
        const date = new Date(dateText);
        
        const typeMatch = typeFilter === 'all' || 
                         (typeFilter === 'results' && type.includes('resultado')) ||
                         (typeFilter === 'reports' && type.includes('reporte')) ||
                         (typeFilter === 'prescriptions' && type.includes('receta')) ||
                         (typeFilter === 'images' && type.includes('imagen'));
        
        const dateMatch = dateFilter === 'all' || checkDateFilter(date, dateFilter);
        
        if (typeMatch && dateMatch) {
            row.style.display = 'table-row';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} documentos`);
}

function checkDateFilter(date, filter) {
    const now = new Date();
    const timeDiff = now - date;
    const daysDiff = timeDiff / (1000 * 3600 * 24);
    
    switch(filter) {
        case 'week':
            return daysDiff <= 7;
        case 'month':
            return daysDiff <= 30;
        case 'year':
            return daysDiff <= 365;
        default:
            return true;
    }
}

function searchDocuments(searchTerm) {
    const documentCards = document.querySelectorAll('.document-card');
    const tableRows = document.querySelectorAll('.documents-table tbody tr');
    
    let visibleCount = 0;
    
    // Buscar en tarjetas
    documentCards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Buscar en tabla
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = 'table-row';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    console.log(`Mostrando ${visibleCount} documentos que coinciden con "${searchTerm}"`);
}