/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/templates/*.php"],
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
