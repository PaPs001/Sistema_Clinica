import { cargarDatos } from '../medic/util/cargarDatos.js';

document.addEventListener("DOMContentLoaded", () => {
    const doctorSelect = document.querySelector('#filterDoctor');
    const dateInput = document.querySelector('#filterDate');

    function buildAppointmentsUrl() {
        const baseUrl = '/listar-consultas-dashboard-paciente';
        const params = new URLSearchParams();

        if (doctorSelect && doctorSelect.value) {
            params.set('doctor_id', doctorSelect.value);
        }
        if (dateInput && dateInput.value) {
            params.set('date', dateInput.value);
        }

        const query = params.toString();
        return query ? `${baseUrl}?${query}` : baseUrl;
    }

    function cargarCitas() {
        const url = buildAppointmentsUrl();
        cargarDatos({
            url,
            contenedor: '#appointments-tbody',
            template: '#cita-template',
            paginationContainer: '#paginationContainer-appointments',
            campos: {
                '.fecha': item => item.appointment_date,
                '.hora': item => item.appointment_time,
                '.doctor-nombre': item => item.doctor?.user?.name ?? 'N/A',
                '.doctor-servicio': item => item.doctor?.service?.name ?? 'N/A',
                '.doctor-especialidad': item => item.doctor?.service?.name ?? 'N/A',
            },
        });
    }

    if (doctorSelect) {
        doctorSelect.addEventListener('change', cargarCitas);
    }
    if (dateInput) {
        dateInput.addEventListener('change', cargarCitas);
    }

    cargarCitas();

    // Tratamientos / medicamentos activos
    cargarDatos({
        url: '/tratamientos-activos-paciente',
        contenedor: '#active-treatments',
        template: '#tratamiento-activo-template',
        paginationContainer: '#paginationContainer-treatments',
        campos: {
            '.tratamiento-nombre': t => t.treatment,
            '.tratamiento-detalle': t => {
                const parts = [];
                if (t.type) parts.push(t.type);
                if (t.status) parts.push(t.status);
                return parts.join(' · ') || 'Detalle no disponible';
            },
            '.tratamiento-fecha': t => {
                if (t.end_date) {
                    return `Hasta ${t.end_date}`;
                }
                return 'Sin fecha de término';
            },
        },
    });
});
