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
//     .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'public/icon/themify-icons/themify-icons.css',
    'public/icon/font-awesome/css/font-awesome.min.css',
    'public/icon/icofont/css/icofont.css',
    'public/css/style.css',
    'public/css/jquery.mCustomScrollbar.css',
    'public/css/select2.min.css',
], 
'public/css/template.css').version();

mix.scripts([
    'public/js/jquery-ui/jquery-ui.min.js',
    'public/js/popper.js/popper.min.js',
    'public/js/bootstrap/js/bootstrap.min.js',
    'public/js/jquery-slimscroll/jquery.slimscroll.js',
    'public/js/modernizr/modernizr.js',
    'public/js/modernizr/css-scrollbars.js',
    'public/js/common-pages.js',
    'public/js/select2.min.js',
],
'public/js/template.js').version();