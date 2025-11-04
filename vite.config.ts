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
                'resources/css/RECEPCIONISTA/general.css'
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
