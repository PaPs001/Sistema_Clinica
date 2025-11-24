<template id="archivo-template">
     <div class="file-card">
        <div class="file-card-header">
            <div class="file-info">
                <h3 class="nombre"></h3>
                <span class="fecha"></span>
            </div>
        </div>

        <p class="descripcion"></p>

        <div class="file-actions">
            <button class="ver-btn">Ver</button>
            <button class="descargar-btn">Descargar</button>
        </div>
    </div>
</template>

<div id="lista-archivos" class="file-grid"></div>