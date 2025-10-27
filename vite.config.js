// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true,
      // (opcional) se quiser mudar a pasta, mantenha 'build'
      // buildDirectory: 'build',
    }),
    vue(),
  ],
  build: {
    outDir: 'public/build',
    assetsDir: 'assets',
    emptyOutDir: true,
    // 👇 força o arquivo exatamente em public/build/manifest.json
    manifest: 'manifest.json',
  },
})
