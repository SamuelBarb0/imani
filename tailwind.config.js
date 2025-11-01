/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'dark-turquoise': '#12463c',
        'dark-turquoise-alt': '#003a2f',
        'gray-brown': '#5c533b',
        'gray-orange': '#c2b59b',
      },
      fontFamily: {
        'spartan': ['League Spartan', 'sans-serif'],
        'sans': ['Open Sans', 'sans-serif'],
        'script': ['Corinthia', 'cursive'],
        'serif': ['Above the Beyond Serif', 'serif'],
      },
    },
  },
  plugins: [],
}
