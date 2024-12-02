const mix = require('laravel-mix');

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

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/fullcalendar/main.min.css', 'public/css/fullcalendar.css')
   .copy('node_modules/fullcalendar/main.min.js', 'public/js/fullcalendar.js')
   .copy('node_modules/@fullcalendar/core/main.min.js', 'public/js/fullcalendar.js')
   .copy('node_modules/@fullcalendar/daygrid/main.min.js', 'public/js/fullcalendar-daygrid.js')
   .copy('node_modules/@fullcalendar/timegrid/main.min.js', 'public/js/fullcalendar-timegrid.js');

