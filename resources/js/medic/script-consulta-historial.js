import { crearBuscador } from "./util/buscador.js";

document.addEventListener("DOMContentLoaded", () => {
    crearBuscador({
        input: "#searchPatient",
        contenedor: "#sugerencias-historial",
        url: "/buscar-pacientes-historial?query=",
        renderItem: (p) =>
            `${p.name} — ${p.phone ?? "Sin teléfono"} — ${p.email ?? "Sin correo"}`,
        onSelect: (p) => {
            const input = document.querySelector("#searchPatient");
            if (input) {
                input.value = p.name;
            }
            const form = document.querySelector(".search-filters");
            if (form) {
                form.submit();
            }
        },
    });
});

