const mix = require('laravel-mix');
const path = require('path')
require('mix-tailwindcss');

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .tailwind()
  // Enable dynamic imports
  .babelConfig({
    plugins: ['@babel/plugin-syntax-dynamic-import'],
  })
  // Enable code splitting
  .webpackConfig({
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@': path.resolve('resources/js'),
      },
    },
  })
  .version()
  .disableSuccessNotifications();
