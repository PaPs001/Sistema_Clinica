import{ crearBuscador } from "./util/buscador.js";
import{ filtradoGeneral } from "./util/filtrado.js";
document.addEventListener("DOMContentLoaded", () => {
crearBuscador({
        input: "#diagnostico",
        contenedor: "#sugerencias-diagnosticos",
        url: "/buscar-diagnostico?query=",
        renderItem: d => d.name,
        onSelect: d => {
            document.querySelector("#diagnostico").value = d.name;
            document.querySelector("#diagnostico_id").value = d.id;
        }
    });
    
const filtrar = filtradoGeneral({
    input: "#diagnostico",
    contenedor: "#patientsGrid",
    paginationContainer: "#paginationContainer",
    url: "/filtrado-expedientes",
    renderItem: exp => `
        <div class="card p-3 mb-2">

            <strong>Paciente:</strong> 
            ${exp.patient_user?.user?.name ?? "Sin nombre"}<br>

            <strong>DNI:</strong> 
            ${exp.patient_user?.DNI ?? "No disponible"}<br>

            <strong>Expediente ID:</strong> 
            ${exp.id}<br>

            <strong>Fecha de creación:</strong> 
            ${exp.creation_date}<br>

            <strong>Coincidencias:</strong><br>
            ${
                exp.consult_diseases
                    .map(c => `- ${c.disease.name}`)
                    .join("<br>")
            }
        </div>
    `
});

document.getElementById("btnBuscar").addEventListener("click", () => filtrar(1));

filtrar(1);
});