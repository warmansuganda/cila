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
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'bower_components/admin-lte/dist/css/AdminLTE.min.css',
        'bower_components/iCheck/skins/square/blue.css',
        'bower_components/nprogress/nprogress.css',

        'resources/css/fonts-googleapis.min.css',
        'resources/css/default.custome.css',
        'resources/css/login.custome.css',

    ], 'public/assets/css/login.min.css', './');

    mix.scripts([
        // Vendor
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/iCheck/icheck.min.js',
        'bower_components/nprogress/nprogress.js',
    ], 'public/assets/js/login.min.js', './');

    mix.copy('bower_components/font-awesome/fonts', 'assets/fonts');
    mix.copy('bower_components/Ionicons/fonts', 'assets/fonts');
    mix.copy('bower_components/iCheck/skins/square/blue.png', 'assets/css');
    mix.copy('resources/img', 'assets/img');
    mix.copy('resources/fonts', 'assets/fonts');

    /*
     |--------------------------------------------------------------------------
     | Main : Main Assets Setup
     |--------------------------------------------------------------------------
     */

    mix.styles([
        // Vendor
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'bower_components/admin-lte/dist/css/AdminLTE.min.css',
        'bower_components/admin-lte/dist/css/skins/skin-blue.min.css',
        'bower_components/iCheck/skins/square/blue.css',
        'bower_components/nprogress/nprogress.css',
        
        'resources/css/default.custome.css',
        'resources/css/main.custome.css',

    ], 'public/assets/css/main.min.css', './');

    mix.scripts([
      // Vendor
      'bower_components/jquery/dist/jquery.min.js',
      'bower_components/bootstrap/dist/js/bootstrap.min.js',
      'bower_components/iCheck/icheck.min.js',
      'bower_components/nprogress/nprogress.js',

    ], 'public/assets/js/main.min.js', './');

    mix.version([
      'assets/css/login.min.css',
      'assets/js/login.min.js',
      'assets/css/main.min.css',
      'assets/js/main.min.js',
    ], './');



});
