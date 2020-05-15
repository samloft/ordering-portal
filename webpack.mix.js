const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.options({
    processCssUrls: false,
    postCss: [
        require('postcss-import'),
        require('tailwindcss')('tailwind.config.js'),
        require('postcss-custom-properties'),
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

mix.sass('resources/sass/themes/scolmore.scss', 'public/css/app-scolmore.css')
    .sass('resources/sass/themes/ovia.scss', 'public/css/app-ovia.css')
    .sass('resources/sass/themes/unicrimp.scss', 'public/css/app-unicrimp.css')
    .sass('resources/sass/themes/esp.scss', 'public/css/app-esp.css')
    .sass('resources/sass/themes/litehouse.scss', 'public/css/app-litehouse.css')
    .sass('resources/sass/themes/espi.scss', 'public/css/app-espi.css')
    .sass('resources/sass/cms.scss', 'public/css/cms.css')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/cms.js', 'public/js')
    .version()
    .purgeCss({
        enabled: mix.inProduction(),
        folders: [
            'src',
            'templates',
            'modules',
        ],
        extensions: [
            'html',
            'js',
            'php',
            'vue'
        ],
        whitelistPatterns: [/badge/, /flatpickr/, /category/]
    });
