const mix = require('laravel-mix');
const path = require('path');

mix.webpackConfig({
    resolve: {
        alias: {
            '@sass': path.resolve('resources/sass'),
            '@js': path.resolve('resources/js'),
            '@images': path.resolve('resources/images'),
        },
    },
});

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sourceMaps();

mix.sass('resources/sass/app.sass', 'public/css')
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
