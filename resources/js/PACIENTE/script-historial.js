import { cargarDatos } from '../medic/util/cargarDatos.js';
document.addEventListener("DOMContentLoaded", () => {
    cargarDatos({
        url: '/listar-consultas-dashboard-paciente',
        contenedor: '#appointments-tbody',
        template: '#cita-template',
        paginationContainer: '#paginationContainer-appointments',
        campos: {
            '.fecha': item => item.appointment_date,
            '.hora': item => item.appointment_time,
            '.doctor-nombre': item => item.doctor?.user?.name ?? 'N/A',
            '.doctor-servicio': item => item.doctor?.service?.name ?? 'N/A',
            '.doctor-especialidad': item => item.doctor?.service?.name ?? 'N/A'
        }
    });
});