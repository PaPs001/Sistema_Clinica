import { renderPaginator } from "./paginador";

export function filtradoGeneral({
    input,
    contenedor,
    url,
    renderItem,
    paginationContainer
}) {
    const inputBus = document.querySelector(input);
    const contenedorBus = document.querySelector(contenedor);
    const pagination = document.querySelector(paginationContainer);
    const counter = document.querySelector("#resultsCount");

    async function cargarPagina(page = 1) {
        const texto = inputBus.value.trim();

        if (texto.length === 0) {
            contenedorBus.innerHTML = "<p class='text-muted'>Ingresa texto para buscar</p>";
            counter.textContent = 0;
            pagination.innerHTML = "";
            return;
        }

        try {
            const respuesta = await fetch(url + `?page=${page}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ texto })
            });

            const data = await respuesta.json();

            counter.textContent = data.total;

            if (data.data.length === 0) {
                contenedorBus.innerHTML = "<p class='text-muted'>Sin resultados</p>";
                pagination.innerHTML = "";
                return;
            }

            contenedorBus.innerHTML = "";
            data.data.forEach(item => {
                contenedorBus.innerHTML += renderItem(item);
            });

            renderPaginator({
                currentPage: data.current_page,
                totalPages: data.last_page,
                container: pagination,
                onPageChange: cargarPagina
            });

        } catch (error) {
            console.error("Error en filtrado", error);
        }
    }

    return cargarPagina;
}

export function filtrador({
    input,
    contenedor,
    url,
    callback = null
}) {
    const inputBus = document.querySelector(input);
    const contenedorBus = document.querySelector(contenedor);

    return async function () {

        const texto = inputBus.value.trim();

        if (texto.length === 0) {
            contenedorBus.innerHTML = "<tr><td colspan='10' class='text-muted'>Ingresa texto para buscar</td></tr>";
            if (callback) callback(null);
            return;
        }

        try {
            const respuesta = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                },
                body: JSON.stringify({ texto })
            });

            const html = await respuesta.text();

            contenedorBus.innerHTML = html;

            if (callback) callback(html);

        } catch (error) {
            console.error("Error en filtrado:", error);
            contenedorBus.innerHTML = "<tr><td colspan='10' class='text-danger'>Error al cargar resultados</td></tr>";
        }
    };
}