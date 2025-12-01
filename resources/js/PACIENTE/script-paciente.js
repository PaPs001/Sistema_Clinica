import { cargarDatos } from "../medic/util/cargarDatos";
import { openOtherSpaces } from "../PACIENTE/util/openOtherSpaces";
cargarDatos({
    url: "/datos-historial-consulta",
    contenedor: "#lista-consultas",
    template: "#consulta-template",
    paginationContainer: "#paginationContainer-consulta",
    campos: {
        ".titulo-consulta": c => `${c.servicio} - ${c.fecha}`,
        ".medico": c => c.doctor,
        ".diagnostico": c => c.diagnostico,
        ".tratamiento": c => c.tratamiento,
        ".sintomas": c => c.sintomas,
        ".razon": c => c.razon,
        ".revision": c => c.revision,
        ".medicamentos": c => (c.medicamentos && c.medicamentos.length)
            ? c.medicamentos.join(", ")
            : "Sin medicamentos",
        ".tratamientos-detalle": c => (c.tratamientos_detalle && c.tratamientos_detalle.length)
            ? c.tratamientos_detalle
                .map(t => `${t.descripcion}${t.inicio ? ` (${t.inicio}` : ""}${t.fin ? ` - ${t.fin}` : (t.inicio ? ")" : "")}`)
                .join(" | ")
            : "Sin tratamientos",
    }
})

openOtherSpaces({
    buttons: ".tab-btn",
    sections: ".tab-content"
})

cargarDatos({
    url: "/archivos-Historial-Medico",
    contenedor: "#lista-archivos",
    template: "#archivo-template",
    paginationContainer: "#paginationContainer-archivos",
    campos: {
        ".nombre": "file_name",
        ".fecha": item => new Date(item.created_at).toLocaleDateString(),
        ".descripcion": "description",
        ".ver-btn": item => element => {
            element.addEventListener("click", (e) => {
                e.stopPropagation();
                window.open(`/verArchivo/${item.id}`, "_blank");
            });
        },
        ".descargar-btn": item => element => {
            element.addEventListener("click", (e) => {
                e.stopPropagation();
                window.location.href = `/archivos/descargar/${item.id}`;
            });
        }
    },
    limpio: true
});

cargarDatos({
    url: "/datos-antecedentes-medicos",
    contenedor: "#lista-antecedentes",
    template: "#antecedentes-alergias-template",
    paginationContainer: "#paginationContainer-antecedentes",
    campos: {
        ".titulo-alergia": a => a.allergie_allergene.allergie.name ?? "Sin alergia",
        ".alergeno": a => a.allergie_allergene.allergene.name ?? "sin alergeno",
        ".severidad": a => a.severity,
        ".estatus": a => a.status,
        ".sintomas": a => a.symptoms,
        ".tratamientos": a => a.treatments
    }
})
