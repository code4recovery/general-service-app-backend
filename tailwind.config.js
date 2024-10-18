/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./app/providers/AppServiceProvider.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
