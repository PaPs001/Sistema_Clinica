export function agregarBloqueExpandible({
    contenedor,
    template,
    titulo = "nuevo bloque",
    inicializarBuscadores = null
}) {
    const cont = document.querySelector(contenedor);
    const tmpl = document.querySelector(template).innerHTML;

    if (!cont) {
        console.error("Erro al obtener contenedor");
    } else if (!tmpl) {
        console.error("Erro al obtener template");
    }
    const idUnico = "block_" + Date.now() + "_" + Math.floor(Math.random() * 10000);
    cont.insertAdjacentHTML('beforeend', `
        <div class="expandible" id="${idUnico}">
            <div class="expandible-header" onclick="toggleExpandible(this)">
                <h3>${titulo}</h3>
                <span class="icon">+</span>
            </div>

            <div class="expandible-content">
                ${tmpl}
                <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                    <button type="button" class="btn-eliminar" onclick="eliminarExpandible('${idUnico}')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    `);

    const nuevoBloque = cont.lastElementChild;
    if (typeof inicializarBuscadores === "function") {
        inicializarBuscadores(nuevoBloque);
    }
}

window.toggleExpandible = function (header) {
    const contenedor = header.parentElement;
    contenedor.classList.toggle("open");
    const icon = header.querySelector(".icon");
    icon.textContent = contenedor.classList.contains("open") ? "-" : "+";
};

window.eliminarExpandible = function (id) {
    const bloque = document.getElementById(id);
    if (bloque) bloque.remove();
};

window.agregarBloqueExpandible = agregarBloqueExpandible;
