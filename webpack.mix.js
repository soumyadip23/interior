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
mix.webpackConfig({
    devtool: "inline-source-map"
});
mix.copyDirectory("resources/backend", "public/backend");
mix.copyDirectory("resources/frontend", "public/frontend");
mix.sass("resources/frontend/scss/main.scss", "public/frontend/css/main.css"); 
mix.js("resources/frontend/js/main.js", "public/frontend/js/main.js"); 
mix.sourceMaps();