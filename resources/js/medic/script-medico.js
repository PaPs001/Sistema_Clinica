import{ crearBuscador } from "./util/buscador.js";
import{ addVitalSigns } from "./util/signos-vitales.js";
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
        input: "#nombre",
        contenedor: "#sugerencias-pacientes",
        url: (q) => {
            const fechaConsulta = document.querySelector("#fechaConsulta")?.value || "";
            const params = new URLSearchParams();
            if (fechaConsulta) {
                params.append("fecha", fechaConsulta);
            }
            params.append("query", q);
            return "/buscar-pacientes?" + params.toString();
        },
        renderItem: p => `${p.nombre} (${p.telefono || "Sin teléfono"})`,
        onSelect: paciente => {
            document.querySelector("#nombre").value = paciente.nombre;
            document.querySelector("#telefono").value = paciente.telefono;
            document.querySelector("#paciente_id").value = paciente.id;

            if (paciente.userId != null) {
                const fechaInput = document.querySelector("#fechaNacimiento");
                const generoInput = document.querySelector("#genero");
                const direccionInput = document.querySelector("#direccion");
                const emailInput = document.querySelector("#email");
                fechaInput.value = paciente.fechaNacimiento;
                fechaInput.readOnly = 'true';
                generoInput.value = paciente.genero;
                generoInput.disabled = 'true';
                direccionInput.value = paciente.direccion;
                direccionInput.readOnly = 'true';
                emailInput.value = paciente.email;
                emailInput.readOnly = 'true';
            }

            addVitalSigns(paciente.signos_vitales);
        }
    });

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
});
