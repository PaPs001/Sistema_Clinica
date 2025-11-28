// TEST SCRIPT - Verificar que los scripts se cargan
console.log('✅ Script de prueba cargado correctamente');

// Verificar que DOMContentLoaded funciona
document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ DOMContentLoaded ejecutado');

    // Verificar que los botones existen
    const botones = document.querySelectorAll('button');
    console.log(`✅ Encontrados ${botones.length} botones en la página`);

    // Agregar click listener a TODOS los botones como prueba
    botones.forEach((btn, index) => {
        btn.addEventListener('click', function (e) {
            console.log(`🔘 Click en botón ${index + 1}:`, this.id || this.className || 'sin ID');
        });
    });

    console.log('✅ Event listeners agregados a todos los botones');
});
