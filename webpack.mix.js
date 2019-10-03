const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.options({
    processCssUrls: false,
    postCss: [tailwindcss('tailwind.config.js')]
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/app.scss', 'public/css')
    .version();
