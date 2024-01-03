/** @type {import('tailwindcss').Config} */
export default {
  corePlugins: {
    // preflight: false,
  },
  darkMode: "class",
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.jsx',
    

    "./Modules/*/resources/view/**/**/*.blade.php",
    "./Modules/*/resources/assets/js/**/**/*.js",
    "./Modules/*/resources/assets/js/**/**/*.jsx",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    
  ],
}

