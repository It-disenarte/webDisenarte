import { defineConfig } from 'astro/config';
import tailwindcss from '@tailwindcss/vite';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  // URL oficial de tu sitio en Vercel para generar el sitemap.xml
  site: 'https://www.disenartemx.com', 

  // Como mencionaste que es estático, aseguramos el renderizado en el build
  output: 'static',

  image: {
    // Esto permite que Astro convierta las imágenes de tu WP a WebP/Avif
    // sustituye 'tu-dominio-backend.com' por el dominio donde vive tu WordPress
    domains: ['panel.disenartemx.com'], 
  },

  vite: {
    plugins: [tailwindcss()],
  },

  integrations: [
    sitemap({
      // Opciones extra para ayudar a los buscadores
      changefreq: 'weekly',
      priority: 0.7,
      lastmod: new Date(),
    })
  ]
});