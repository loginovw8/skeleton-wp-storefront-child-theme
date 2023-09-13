const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.options({ manifest: false })

mix.js('resources/js/app.js', 'dist/js')
    .postCss('resources/css/app.css', 'dist/css', [
        require('tailwindcss'),
    ]);
