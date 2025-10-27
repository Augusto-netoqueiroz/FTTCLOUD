// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      // apenas JS, seu CSS continua com Tailwind CLI
      input: ['resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
})
