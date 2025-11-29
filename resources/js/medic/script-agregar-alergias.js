import { crearBuscador } from "./util/buscador.js";
import { agregarBloqueExpandible } from "./util/bloqueExpandible.js";
function inicializarBuscadores(bloque) {


    const alergias = bloque.querySelector(".alergias");
    if (alergias) {
        crearBuscador({
            input: alergias,
            contenedor: bloque.querySelector(".sugerencias-alergias"),
            url: "/buscar-alergias?query=",
            renderItem: d => d.name,
            onSelect: d => {
                alergias.value = d.name;
                bloque.querySelector(".alergias_id").value = d.id;
            }
        });
    }

    const alergenos = bloque.querySelector(".alergenos");
    if (alergenos) {
        crearBuscador({
            input: alergenos,
            contenedor: bloque.querySelector(".sugerencias-alergenos"),
            url: "/buscar-alergenos?query=",
            renderItem: d => d.name,
            onSelect: d => {
                alergenos.value = d.name;
                bloque.querySelector(".alergenos_id").value = d.id;
            }
        });
    }

    const cronicas = bloque.querySelector(".enfermedades-cronicas");
    if (cronicas) {
        crearBuscador({
            input: cronicas,
            contenedor: bloque.querySelector(".sugerencias-enfermedades-cronicas"),
            url: "/buscar-diagnostico?query=",
            renderItem: d => d.name,
            onSelect: d => {
                cronicas.value = d.name;
                bloque.querySelector(".enfermedades-cronicas_id").value = d.id;
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    crearBuscador({
        input: document.querySelector(".nombre-paciente"),
        contenedor: document.querySelector(".sugerencias-pacientes"),
        url: "/buscar-paciente-archivos?query=",
        renderItem: p => p.user.name,
        onSelect: paciente => {
            document.querySelector(".nombre-paciente").value = paciente.user.name;
            document.querySelector(".paciente_id").value = paciente.id;
        }
    });
    window.agregarAlergia = function () {
        agregarBloqueExpandible({
            contenedor: "#contenedorAlergias",
            template: "#template-alergia",
            titulo: "Alergias",
            inicializarBuscadores: inicializarBuscadores
        });
    };
    window.agregarCronica = function () {
        agregarBloqueExpandible({
            contenedor: "#contenedorCronicas",
            template: "#template-cronica",
            titulo: "Enfermedades",
            inicializarBuscadores: inicializarBuscadores
        })
    };

    window.limpiarFormulario = function () {
        const contenedorAlergias = document.getElementById('contenedorAlergias');
        if (contenedorAlergias) {
            contenedorAlergias.innerHTML = '';
        }
        const contenedorCronicas = document.getElementById('contenedorCronicas');
        if (contenedorCronicas) {
            contenedorCronicas.innerHTML = '';
        }

        const nombrePaciente = document.querySelector('.nombre-paciente');
        if (nombrePaciente) {
            nombrePaciente.value = '';
        }

        const pacienteId = document.querySelector('.paciente_id');
        if (pacienteId) {
            pacienteId.value = '';
        }
    };
});

window.inicializarBuscadores = inicializarBuscadores;
