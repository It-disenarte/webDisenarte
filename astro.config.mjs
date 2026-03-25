import { defineConfig } from 'astro/config';
import tailwindcss from '@tailwindcss/vite';
// Si vas a probar local, comenta el adaptador de node un momento
// import node from '@astrojs/node'; 

export default defineConfig({
  // Si vas a trabajar en tu compu, puedes dejarlo en 'static' o 'server'
  // pero asegúrate de que Tailwind esté presente:
  vite: {
    plugins: [tailwindcss()],
  }
});