const mix = require('laravel-mix');
require('mix-tailwindcss');

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

mix.ts('resources/ts/admin/components/index.tsx', 'public/admin/js')
    .react()
    .sass('resources/sass/admin/app.scss', 'public/admin/css')
    .sass('resources/sass/common.scss', 'public/css')
    .sass('resources/sass/header.scss', 'public/css')
    .sass('resources/sass/footer.scss', 'public/css')
    .sass('resources/sass/top.scss', 'public/css')
    .sass('resources/sass/reservation.scss', 'public/css')
    .sass('resources/sass/access.scss', 'public/css')
    .sass('resources/sass/fee.scss', 'public/css')
    .sass('resources/sass/overview.scss', 'public/css')
    .js('resources/js/top.js', 'public/js')
    .js('resources/js/reservation.js', 'public/js')
    .js('resources/js/register.js', 'public/js')
    .js('resources/js/login.js', 'public/js')
    .tailwind();
    
