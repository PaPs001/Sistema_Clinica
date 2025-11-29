import { crearBuscador } from "./util/buscador.js";
import { filtradoGeneral } from "./util/filtrado.js";

document.addEventListener("DOMContentLoaded", () => {
    crearBuscador({
        input: "#diagnostico",
        contenedor: "#sugerencias-diagnosticos",
        url: "/buscar-diagnostico?query=",
        renderItem: (d) => d.name,
        onSelect: (d) => {
            document.querySelector("#diagnostico").value = d.name;
            document.querySelector("#diagnostico_id").value = d.id;
        },
    });

    const filtrar = filtradoGeneral({
        input: "#diagnostico",
        contenedor: "#patientsGrid",
        paginationContainer: "#paginationContainer",
        url: "/filtrado-expedientes",
        renderItem: (exp) => {
            const filtro = document
                .querySelector("#diagnostico")
                ?.value.trim()
                .toLowerCase() || "";

            const coincidencias = (exp.consult_diseases ?? []).filter((c) => {
                const nombre = c.disease?.name?.toLowerCase() ?? "";
                if (!filtro) return true;
                return nombre.includes(filtro);
            });

            const coincidenciasHtml =
                coincidencias.length > 0
                    ? coincidencias
                        .map((c) => `• ${c.disease?.name ?? "Sin nombre"}`)
                        .join("<br>")
                    : "Sin coincidencias";

            const patientId = exp.patient_user?.id ?? "";
            const patientName = exp.patient_user?.user?.name ?? "";

            return `
            <div class="patient-card">
                <div class="patient-header">
                    <div class="patient-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="patient-info">
                        <h4>${patientName || "Sin nombre"}</h4>
                        <div class="patient-meta">
                            DNI: ${exp.patient_user?.DNI ?? "No disponible"} ID: ${exp.id}
                        </div>
                    </div>
                </div>

                <div class="patient-details">
                    <div class="detail-item">
                        <span class="detail-label">Fecha de creacion</span>
                        <span class="detail-value">${exp.creation_date}</span>
                    </div>
                </div>

                <div class="patient-diagnosis">
                    <div class="diagnosis-label">Coincidencias</div>
                    <div class="diagnosis-value">
                        ${coincidenciasHtml}
                    </div>
                </div>

                <div class="patient-actions">
                    <a 
                        href="/consulta-historial?buscar=${encodeURIComponent(
                patientName
            )}" 
                        class="btn-view"
                    >
                        Ir a historial
                    </a>
                </div>
            </div>
        `;
        },
    });

    document
        .getElementById("btnBuscar")
        .addEventListener("click", () => filtrar(1));

    filtrar(1);
});

