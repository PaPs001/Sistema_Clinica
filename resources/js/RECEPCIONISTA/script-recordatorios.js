import { crearBuscador } from "../medic/util/buscador.js";

// Script sencillo para la gestión de recordatorios (filtros y contador)
console.log("Script de recordatorios cargado correctamente");

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM completamente cargado - Módulo Recordatorios");

    initMessageCounter();
    initPatientSearchFilter();
});

function initMessageCounter() {
    const textarea = document.getElementById("reminder-message");
    const counter = document.getElementById("reminder-char-count");

    if (!textarea || !counter) return;

    const update = () => {
        const length = textarea.value.length;
        counter.textContent = length.toString();
    };

    textarea.addEventListener("input", update);
    update();
}

function initPatientSearchFilter() {
    const nameInput = document.querySelector("#reminder-search");
    const suggestionsContainer = document.querySelector("#sugerencias-recordatorios");

    if (!nameInput || !suggestionsContainer) return;

    crearBuscador({
        input: "#reminder-search",
        contenedor: "#sugerencias-recordatorios",
        url: "/recepcionista/buscar-pacientes?query=",
        renderItem: (p) => `${p.name} (${p.phone ?? "Sin teléfono"})`,
        onSelect: (p) => {
            nameInput.value = p.name;
        },
    });
}
