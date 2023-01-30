let mix = require('laravel-mix');
require('laravel-mix-vue-svgicon');

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
// Override mix internal webpack output configuration
mix.config.webpackConfig.output = {
   /*  chunkFilename: 'js/[name].bundle.js', */
    publicPath: '/',
};

mix.js('resources/assets/js/app.js', 'public/js')
    .extract()
   .sass('resources/assets/sass/app.scss', 'public/css')
   .svgicon('resources/svg')
   .version();
