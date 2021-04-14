const mix = require('laravel-mix');


mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
});

// JS Сайта
let jslib = [
    'resources/js/app.js',
    'resources/js/calculator.js'
];

// JS Админ
let AdminJsLib = [
    'resources/js/admin/app.js'
];

// Компиляция js
mix.js(jslib, 'public/static/js/main.es6.js')
    .babel('public/static/js/main.es6.js', 'public/static/js/main.js');

mix.js(AdminJsLib, 'public/static/js/admin/main.es6.js')
    .babel('public/static/js/admin/main.es6.js', 'public/static/js/admin/main.js');

mix.js(['resources/js/admin.js'], 'public/static/js/admin.es6.js')
    .babel('public/static/js/admin.es6.js', 'public/static/js/admin.js');

// Компиляция CSS
mix.sass('resources/sass/app.sass', 'public/static/css/main.css')
    .sass('resources/sass/admin/app.sass', 'public/static/css/admin')
    .options({
        postCss: [
            require('autoprefixer')({
                cascade: false
            })
        ],
        processCssUrls: false
    });
