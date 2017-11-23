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
     | SmartAdmin : Login Assets Setup
     |--------------------------------------------------------------------------
     */

    // mix.styles([
    //     // Vendor
    //     'themes/backend/smartadmin/css/bootstrap.min.css',

    // ], 'assets/css/login.min.css', './');

    mix.scripts([
      // Vendor
      'node_modules/jquery/dist/jquery.min.js',

    ], 'public/assets/js/login.min.js', './');

    // mix.copy('themes/backend/smartadmin/img/rev', 'themes/backend/img/rev');

    /*
     |--------------------------------------------------------------------------
     | AdminLTE : Default Assets Setup
     |--------------------------------------------------------------------------
     */

    // mix.styles([
    //     // Vendor
    //     'themes/backend/adminlte/libs/bootstrap/css/bootstrap.min.css',

    // ], 'assets/css/main.min.css', './');

    // mix.scripts([
    //   // Vendor
    //   'themes/backend/adminlte/libs/jquery.min.js',

    // ], 'assets/js/main.min.js', './');

    // // mix.copy('themes/backend/adminlte/libs/ionicons/fonts', 'themes/backend/adminlte/fonts');

    mix.version([
      // 'assets/css/login.min.css',
      'assets/js/login.min.js',
    //   'assets/css/main.min.css',
    //   'assets/js/main.min.js',
    ], './');



});
