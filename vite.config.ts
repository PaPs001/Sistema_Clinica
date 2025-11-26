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
                'resources/js/auth_log/script.js',
                'resources/js/medic/script-medico.js',
                'resources/css/app.css',
                'resources/js/app.js',
                // ENFERMERA - Dashboard
                'resources/css/ENFERMERA/paginas/style-enfermera.css',
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
