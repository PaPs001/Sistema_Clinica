import { crearBuscador } from "./util/buscador.js";
import { addVitalSigns } from "./util/signos-vitales.js";
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

    const medicamentos = bloque.querySelector(".medicamentos-actuales");
    if (medicamentos) {
        crearBuscador({
            input: medicamentos,
            contenedor: bloque.querySelector(".sugerencias-medicamentos-actuales"),
            url: "/buscar-medicamentos?query=",
            renderItem: m => m.presentation ? `${m.name} — ${m.presentation}` : m.name,
            onSelect: m => {
                medicamentos.value = m.name;
                bloque.querySelector(".medicamentos-actuales_id").value = m.id;
            }
        });
    }
}
document.addEventListener("DOMContentLoaded", () => {
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            window.location.href = window.location.pathname;
        }, 2000);
    }
    const urlParams = new URLSearchParams(window.location.search);
    const appointmentId = urlParams.get('appointment_id');

    if (appointmentId) {
        cargarDatosPacienteDesdeCita(appointmentId);
    }

    const nombreInput = document.querySelector("#nombre");
    const sugerenciasPacientes = document.querySelector("#sugerencias-pacientes");

    if (nombreInput && sugerenciasPacientes) {
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
                    if (fechaInput) {
                        fechaInput.value = paciente.fechaNacimiento;
                        fechaInput.readOnly = true;
                    }
                    if (generoInput) {
                        generoInput.value = paciente.genero;
                    }
                    if (direccionInput) {
                        direccionInput.value = paciente.direccion;
                        direccionInput.readOnly = true;
                    }
                    if (emailInput) {
                        emailInput.value = paciente.email;
                        emailInput.readOnly = true;
                    }
                }

                addVitalSigns(paciente.signos_vitales);
            }
        });
    }

    const diagnosticoInput = document.querySelector("#diagnostico");
    const sugerenciasDiagnosticos = document.querySelector("#sugerencias-diagnosticos");

    if (diagnosticoInput && sugerenciasDiagnosticos) {
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
    }

    const selectedMedications = [];
    const medsHiddenInput = document.querySelector("#prescribed_medications");
    const medsHiddenIdsInput = document.querySelector("#prescribed_medications_ids");
    const medsSelectedContainer = document.querySelector("#selected-medications");

    function renderSelectedMedications() {
        if (!medsSelectedContainer) return;
        medsSelectedContainer.innerHTML = "";

        selectedMedications.forEach((m) => {
            const chip = document.createElement("span");
            chip.classList.add("med-chip");
            const label = m.presentation
                ? `${m.name} (${m.presentation})`
                : m.name;
            chip.textContent = label;
            chip.title = "Click para quitar";
            chip.addEventListener("click", () => {
                const index = selectedMedications.findIndex((x) => x.id === m.id);
                if (index !== -1) {
                    selectedMedications.splice(index, 1);
                    renderSelectedMedications();
                }
            });
            medsSelectedContainer.appendChild(chip);
        });

        const names = selectedMedications.map((m) => m.name);
        const ids = selectedMedications.map((m) => m.id);

        if (medsHiddenInput) {
            medsHiddenInput.value = names.join(", ");
        }
        if (medsHiddenIdsInput) {
            medsHiddenIdsInput.value = ids.join(",");
        }
    }

    const medicationSearchInput = document.querySelector("#medication_search");
    const sugerenciasMedicamentos = document.querySelector("#sugerencias-medicamentos");

    if (medicationSearchInput && sugerenciasMedicamentos) {
        crearBuscador({
            input: "#medication_search",
            contenedor: "#sugerencias-medicamentos",
            url: "/buscar-medicamentos?query=",
            renderItem: (m) =>
                m.presentation
                    ? `${m.name} — ${m.presentation}`
                    : m.name,
            onSelect: (m) => {
                if (!selectedMedications.some((x) => x.id === m.id)) {
                    selectedMedications.push(m);
                    renderSelectedMedications();
                }
                const input = document.querySelector("#medication_search");
                if (input) input.value = "";
            },
        });
    }

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

    window.agregarMedicamento = function () {
        agregarBloqueExpandible({
            contenedor: "#contenedorMedicamentos",
            template: "#template-medicamento",
            titulo: "Medicamentos Actuales",
            inicializarBuscadores: inicializarBuscadores
        })
    };
});

function cargarDatosPacienteDesdeCita(appointmentId) {
    fetch(`/cita/${appointmentId}/datos-paciente`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                preLlenarFormulario(data.data);
            } else {
                console.error('Error al cargar datos del paciente:', data.message);
                alert('Error al cargar los datos del paciente: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
}

function preLlenarFormulario(data) {
    if (data.nombre) {
        const nombreInput = document.querySelector("#nombre");
        if (nombreInput) {
            nombreInput.value = data.nombre;
            nombreInput.readOnly = true;
        }
    }

    if (data.telefono) {
        const telefonoInput = document.querySelector("#telefono");
        if (telefonoInput) {
            telefonoInput.value = data.telefono;
        }
    }

    if (data.appointment_date && data.appointment_time) {
        const fechaConsultaInput = document.querySelector("#fechaConsulta");
        if (fechaConsultaInput) {
            const datetime = `${data.appointment_date}T${data.appointment_time}`;
            fechaConsultaInput.value = datetime;
        }
    }

    if (data.patient_id) {
        const pacienteIdInput = document.querySelector("#paciente_id");
        if (pacienteIdInput) {
            pacienteIdInput.value = data.patient_id;
        }
    }

    if (!data.is_temporary) {
        if (data.fechaNacimiento) {
            const fechaNacimientoInput = document.querySelector("#fechaNacimiento");
            if (fechaNacimientoInput) {
                fechaNacimientoInput.value = data.fechaNacimiento;
                fechaNacimientoInput.readOnly = true;
            }
        }

        if (data.genero) {
            const generoInput = document.querySelector("#genero");
            if (generoInput) {
                generoInput.value = data.genero;
            }
        }

        if (data.email) {
            const emailInput = document.querySelector("#email");
            if (emailInput) {
                emailInput.value = data.email;
                emailInput.readOnly = true;
            }
        }

        if (data.direccion) {
            const direccionInput = document.querySelector("#direccion");
            if (direccionInput) {
                direccionInput.value = data.direccion;
                direccionInput.readOnly = true;
            }
        }

        if (data.smoking_status) {
            const smokingInput = document.querySelector("#smoking_status");
            if (smokingInput) smokingInput.value = data.smoking_status;
        }

        if (data.alcohol_use) {
            const alcoholInput = document.querySelector("#alcohol_use");
            if (alcoholInput) alcoholInput.value = data.alcohol_use;
        }

        if (data.physical_activity) {
            const activityInput = document.querySelector("#physical_activity");
            if (activityInput) activityInput.value = data.physical_activity;
        }

        if (data.special_needs) {
            const specialNeedsInput = document.querySelector("#special_needs");
            if (specialNeedsInput) specialNeedsInput.value = data.special_needs;
        }

        if (data.signos_vitales) {
            addVitalSigns(data.signos_vitales);
        }
    }
}
