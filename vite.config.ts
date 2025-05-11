import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';

// vite
import { defineConfig } from 'vite';

import alias from '@rollup/plugin-alias';
import eslint from 'vite-plugin-eslint';

export default defineConfig({
  plugins: [
    react(),
    tailwindcss(),
    alias({
      entries: [{ find: '@', replacement: '/resources/js' }],
    }),
    eslint(),
    laravel({
      input: ['resources/js/app.tsx'],
      refresh: true,
    }),
  ],
});
