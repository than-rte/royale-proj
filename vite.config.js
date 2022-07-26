import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { createVuePlugin } from "vite-plugin-vue2";
import path from "path";
export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/scss/app.scss", "resources/js/app.js"],
      refresh: true,
    }),
    createVuePlugin(),
  ],
  resolve: {
    alias: {
      "@": "/resources/js",
      "@ziggy": path.resolve("vendor/tightenco/ziggy/dist/vue.m"),
    },
  },
});
