<template id="consulta-template">
    <div class="accordion-item">
        <button class="accordion-header" onclick="toggleExpandibleUser(this)">            
            <span class="titulo-consulta"></span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div class="accordion-body">
            <p><strong>Medico:</strong> <span class="medico"></span></p>
            <p><strong>Diagnostico:</strong> <span class="diagnostico"></span></p>
            <p><strong>Tratamiento:</strong> <span class="tratamiento"></span></p>
            <p><strong>Sintomas:</strong> <span class="sintomas"></span></p>
            <p><strong>Razon:</strong> <span class="razon"></span></p>
            <p><strong>Revision:</strong> <span class="revision"></span></p>
            <p><strong>Medicamentos recetados:</strong> <span class="medicamentos"></span></p>
            <p><strong>Tratamientos y fechas:</strong> <span class="tratamientos-detalle"></span></p>
        </div>
    </div>
</template>
