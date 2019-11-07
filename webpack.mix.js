const mix = require('laravel-mix');

mix.options({
    processCssUrls: false,
    postCss: [
        require('postcss-import'),
        require('tailwindcss')('tailwind.config.js'),
        require('postcss-custom-properties')
    ]
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

// mix.sass('resources/sass/app.scss', 'public/css')
mix.sass('resources/sass/themes/scolmore.scss', 'public/css/app-scolmore.css')
    .sass('resources/sass/themes/ovia.scss', 'public/css/app-ovia.css')
    .sass('resources/sass/themes/unicrimp.scss', 'public/css/app-unicrimp.css')
    .js('resources/js/app.js', 'public/js')
    .version();
