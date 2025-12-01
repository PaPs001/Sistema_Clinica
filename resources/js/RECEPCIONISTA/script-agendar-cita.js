import { crearBuscador } from "../medic/util/buscador.js";

function calcularEdad(fechaStr) {
    if (!fechaStr) return "";
    const fecha = new Date(fechaStr);
    if (Number.isNaN(fecha.getTime())) return "";
    const hoy = new Date();
    let edad = hoy.getFullYear() - fecha.getFullYear();
    const m = hoy.getMonth() - fecha.getMonth();
    if (m < 0 || (m === 0 && hoy.getDate() < fecha.getDate())) {
        edad--;
    }
    return edad.toString();
}

document.addEventListener("DOMContentLoaded", () => {
    const nameInput = document.querySelector("#patient_name");
    const phoneInput = document.querySelector("#patient_phone");
    const emailInput = document.querySelector("#patient_email");
    const ageInput = document.querySelector("#patient_age");
    const patientIdInput = document.querySelector("#patient_id");
    const isNewInput = document.querySelector("#is_new");

    // Prefill desde query string cuando venimos desde la lista de pacientes
    try {
        const params = new URLSearchParams(window.location.search);
        if (params.has("name") && nameInput) {
            nameInput.value = params.get("name") || "";
        }
        if (params.has("phone") && phoneInput) {
            phoneInput.value = params.get("phone") || "";
        }
        if (params.has("email") && emailInput) {
            emailInput.value = params.get("email") || "";
        }
        if (params.has("patient_id") && patientIdInput) {
            patientIdInput.value = params.get("patient_id") || "";
            if (isNewInput) {
                isNewInput.value = "false";
            }
        }
    } catch (err) {
        console.error("Error leyendo parametros de la URL en agendar cita:", err);
    }

    if (nameInput && document.querySelector("#sugerencias-pacientes")) {
        crearBuscador({
            input: "#patient_name",
            contenedor: "#sugerencias-pacientes",
            url: "/recepcionista/buscar-pacientes?query=",
            renderItem: (p) =>
                `${p.name} (${p.phone ?? "Sin teléfono"})`,
            onSelect: (p) => {
                nameInput.value = p.name;
                if (patientIdInput) patientIdInput.value = p.id;
                if (phoneInput) phoneInput.value = p.phone ?? "";
                if (emailInput && p.email) emailInput.value = p.email;
                if (ageInput) {
                    ageInput.value = p.birthdate ? calcularEdad(p.birthdate) : "";
                }
                if (isNewInput) {
                    isNewInput.value = "false";
                }
            },
        });
    }

    const form = document.querySelector("#appointment-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dateInput = document.querySelector("#date");
        const timeInput = document.querySelector("#time");
        const doctorSelect = document.querySelector("#doctor_id");
        const typeSelect = document.querySelector("#type");
        const notesInput = document.querySelector("#notes");

        const data = {
            email: emailInput?.value?.trim() || "",
            doctor_id: doctorSelect?.value || "",
            date: dateInput?.value || "",
            time: timeInput?.value || "",
            type: typeSelect?.value || "consulta",
            notes: notesInput?.value || "",
            is_new: "false",
            name: nameInput?.value?.trim() || "",
            phone: phoneInput?.value?.trim() || "",
        };

        // Determinar si es paciente nuevo (sin selección del buscador)
        if (!patientIdInput || !patientIdInput.value) {
            data.is_new = "true";
        }

        if (!data.email || !data.doctor_id || !data.date || !data.time) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Incompletos',
                text: 'Por favor completa correo, médico, fecha y hora de la cita.',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        if (data.is_new === "true" && (!data.name || !data.phone)) {
            Swal.fire({
                icon: 'warning',
                title: 'Datos Faltantes',
                text: 'Para un paciente nuevo, nombre y teléfono son obligatorios.',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        try {
            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            const response = await fetch("/recepcionista/store-appointment", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token || "",
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cita Agendada!',
                    text: 'La cita se ha agendado correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = "/gestion-citas";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || "Ocurrió un error al agendar la cita.",
                    confirmButtonText: 'Cerrar'
                });
            }
        } catch (error) {
            console.error("Error al agendar cita:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error del Sistema',
                text: 'Ocurrió un error inesperado al agendar la cita.',
                confirmButtonText: 'Cerrar'
            });
        }
    });
});
