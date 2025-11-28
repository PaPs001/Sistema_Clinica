<template id="antecedentes-alergias-template">
    <div class="accordion-item">
        <button class="accordion-header" onclick="toggleExpandibleUser(this)">            
            <span class="titulo-alergia"></span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div class="accordion-body">
            <p><strong>Alergeno:</strong> <span class="alergeno"></span></p>
            <p><strong>Severidad:</strong> <span class="severidad"></span></p>
            <p><strong>Estatus:</strong> <span class="estatus"></span></p>
            <p><strong>Sintomas:</strong> <span class="sintomas"></span></p>
            <p><strong>Tratamientos:</strong> <span class="tratamientos"></span></p>
        </div>
    </div>
</template>