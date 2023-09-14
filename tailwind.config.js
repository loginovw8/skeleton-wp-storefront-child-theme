/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./assets/**/*.svg", "./resources/templates/**/*.php"],
    theme: {
        extend: {
            fontFamily: {
                source: ['"Source Sans Pro"', "sans-serif"],
            },
            colors: {},
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
