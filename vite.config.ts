import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.tsx',
                'resources/css/auth_log/login.css',
                'resources/css/ADMINISTRADOR/general.css',
                'resources/css/ENFERMERA/general.css',
                'resources/css/medic/general.css',
                'resources/css/PACIENTE/general.css',
                'resources/css/RECEPCIONISTA/general.css',
                // JS de autenticación
                'resources/js/auth_log/script.js',
                // JS del médico
                'resources/js/medic/script-medico.js',
                'resources/js/medic/script-agregar-alergias.js',
                'resources/js/medic/script-filtrar-expedientes.js',
                'resources/js/medic/script-filtro-expediente.js',
                'resources/js/PACIENTE/script-historial',
                'resources/css/medic/paginas/modulo_plantilla.css',
                'resources/css/medic/paginas/consulta_historial_medico.css',
                'resources/css/medic/paginas/subir_doc_medico.css',
                'resources/css/medic/paginas/filtrar_exp_medico.css',
                'resources/css/medic/paginas/registro_alergias_medico.css',
                'resources/css/medic/paginas/registro-expediente.css',
                // CSS del paginador
                'resources/css/PACIENTE/paginas/paginador.css',
                // JS de la enfermera
                'resources/js/ENFERMERA/script-enfermera.js',
                // JS del administrador
                'resources/js/ADMINISTRATOR/gestion-roles.js',
                // JS de la recepcionista
                'resources/js/RECEPCIONISTA/script-agenda.js',
                'resources/js/RECEPCIONISTA/script-gestion-citas.js',
                'resources/js/RECEPCIONISTA/script-pacientes.js',
                'resources/js/RECEPCIONISTA/script-recepcionista.js',
                'resources/js/RECEPCIONISTA/script-recordatorios.js',
                'resources/js/RECEPCIONISTA/script-registro-paciente.js',
                // ENFERMERA - Dashboard
                'resources/js/ENFERMERA/script-enfermera.js',
                // ENFERMERA - Pacientes
                'resources/css/ENFERMERA/paginas/style-pacientes.css',
                'resources/js/ENFERMERA/script-pacientes.js',
                // ENFERMERA - Signos Vitales
                'resources/css/ENFERMERA/paginas/style-signos.css',
                'resources/js/ENFERMERA/script-signos.js',
                // ENFERMERA - Tratamientos
                'resources/css/ENFERMERA/paginas/style-tratamientos.css',
                'resources/js/ENFERMERA/script-tratamientos.js',
                // ENFERMERA - Citas
                'resources/css/ENFERMERA/paginas/style-citas.css',
                'resources/js/ENFERMERA/paginas/script-citas.js',
                // ENFERMERA - Medicamentos
                'resources/css/ENFERMERA/paginas/style-medicamentos.css',
                'resources/js/ENFERMERA/script-medicamentos.js',
                // ENFERMERA - Reportes
                'resources/css/ENFERMERA/paginas/style-reportes.css',
                'resources/js/ENFERMERA/script-reportes.js',
                // PACIENTE - Dashboard e historial
                'resources/js/PACIENTE/script-historial.js',
                'resources/js/PACIENTE/script-paciente.js',
                // PACIENTE - Otras secciones
                'resources/js/PACIENTE/script-perfil.js',
                'resources/js/PACIENTE/script-citas.js',
                'resources/js/PACIENTE/script-alergias.js',
                'resources/js/PACIENTE/script-documentos.js',
                // App JS clásico (welcome.blade)
                'resources/js/app.js',
                ],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
    ],
    esbuild: {
        jsx: 'automatic',
    },
});
