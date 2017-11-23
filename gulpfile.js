var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    /*
     |--------------------------------------------------------------------------
     | Login : Login Assets Setup
     |--------------------------------------------------------------------------
     */

    mix.styles([
        // Vendor
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/font-awesome/css/font-awesome.min.css',
        'node_modules/ionicons/dist/css/ionicons.min.css',
        'node_modules/admin-lte/dist/css/AdminLTE.min.css',
        'node_modules/icheck/skins/square/blue.css',
        'node_modules/nprogress/nprogress.css',

    ], 'public/assets/css/login.min.css', './');

    mix.scripts([
        // Vendor
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/icheck/icheck.min.js',
        'node_modules/nprogress/nprogress.js',
    ], 'public/assets/js/login.min.js', './');

    mix.copy('node_modules/font-awesome/fonts', 'assets/fonts');
    mix.copy('node_modules/ionicons/dist/fonts', 'assets/fonts');
    mix.copy('node_modules/icheck/skins/square/blue.png', 'assets/css');

    /*
     |--------------------------------------------------------------------------
     | Main : Main Assets Setup
     |--------------------------------------------------------------------------
     */

    mix.styles([
        // Vendor
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/nprogress/nprogress.css',

        'resources/css/main.custome.css',

    ], 'public/assets/css/main.min.css', './');

    mix.scripts([
      // Vendor
      'node_modules/jquery/dist/jquery.min.js',
      'node_modules/nprogress/nprogress.js',

    ], 'public/assets/js/main.min.js', './');

    // // mix.copy('themes/backend/adminlte/libs/ionicons/fonts', 'themes/backend/adminlte/fonts');

    mix.version([
      'assets/css/login.min.css',
      'assets/js/login.min.js',
      'assets/css/main.min.css',
      'assets/js/main.min.js',
    ], './');



});
