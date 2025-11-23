<template id="consulta-template">
    <div class="accordion-item">
        <button class="accordion-header" onclick="toggleExpandibleUser(this)">            
            <span class="titulo-consulta"></span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div class="accordion-body">
            <p><strong>Médico:</strong> <span class="medico"></span></p>
            <p><strong>Diagnóstico:</strong> <span class="diagnostico"></span></p>
            <p><strong>Tratamiento:</strong> <span class="tratamiento"></span></p>
            <p><strong>sintomas:</strong> <span class="sintomas"></span></p>
            <p><strong>razon:</strong> <span class="razon"></span></p>
            <p><strong>revision:</strong> <span class="revision"></span></p>
        </div>
    </div>
</template>