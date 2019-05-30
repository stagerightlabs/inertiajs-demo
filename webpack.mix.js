const mix = require('laravel-mix');
require('mix-tailwindcss');

mix.sass('resources/sass/app.scss', 'public/css')
   .tailwind()
   .version();
