const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/js/app.js', 'public/js')
 .js('resources/js/top.js', 'public/js')
 .sass('resources/sass/common.scss', 'public/css')
 .sass('resources/sass/header.scss', 'public/css')
 .sass('resources/sass/footer.scss', 'public/css')
 .sass('resources/sass/top.scss', 'public/css')
 .sass('resources/sass/access.scss', 'public/css')
 .sass('resources/sass/fee.scss', 'public/css')
;

