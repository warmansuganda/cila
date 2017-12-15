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
        'bower_components/nprogress/nprogress.css',

        'bower_components/admin-lte/dist/css/AdminLTE.min.css',
        'bower_components/iCheck/skins/square/blue.css',

        'resources/css/fonts-googleapis.min.css',
        'resources/css/default.custome.css',
        'resources/css/signin.custome.css',

    ], 'public/assets/css/signin.min.css', './');

    mix.scripts([
        // Vendor
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/iCheck/icheck.min.js',
        'bower_components/nprogress/nprogress.js',
    ], 'public/assets/js/signin.min.js', './');

    mix.copy('bower_components/bootstrap/fonts', 'assets/fonts');
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
        'bower_components/iCheck/skins/square/blue.css',
        'bower_components/nprogress/nprogress.css',
        'bower_components/bootstrap-daterangepicker/daterangepicker.css',
        'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'bower_components/select2/dist/css/select2.min.css',
        'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        'bower_components/sweetalert2/dist/sweetalert2.min.css',
        'bower_components/wait-me/dist/waitMe.min.css',
        'bower_components/toastr/toastr.min.css',
        'bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',

        'bower_components/admin-lte/dist/css/AdminLTE.min.css',
        'bower_components/admin-lte/dist/css/skins/skin-black.min.css',
        
        'resources/css/fonts-googleapis.min.css',
        'resources/css/default.custome.css',
        'resources/css/main.custome.css',

    ], 'public/assets/css/main.min.css', './');

    mix.scripts([
      // Vendor
      'bower_components/jquery/dist/jquery.min.js',
      'bower_components/bootstrap/dist/js/bootstrap.min.js',
      'bower_components/iCheck/icheck.min.js',
      'bower_components/nprogress/nprogress.js',
      'bower_components/select2/dist/js/select2.js',
      'bower_components/moment/min/moment.min.js',
      'bower_components/bootstrap-daterangepicker/daterangepicker.js',
      'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
      'bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
      'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
      'bower_components/fastclick/lib/fastclick.js',
      'bower_components/datatables.net/js/jquery.dataTables.min.js',
      'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
      'bower_components/sweetalert2/dist/sweetalert2.min.js',
      'bower_components/jquery-form/dist/jquery.form.min.js',
      'bower_components/wait-me/dist/waitMe.min.js',
      'bower_components/nestable/jquery.nestable.js',
      'bower_components/toastr/toastr.min.js',
      'bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',

      'bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js',
      'bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js',
      'bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js',
      'bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js',

      'bower_components/admin-lte/dist/js/adminlte.min.js',
      'bower_components/admin-lte/dist/js/demo.js',

      'resources/js/clock.js',
      'resources/js/datatable.js',
      // 'resources/js/form.js',
      'resources/js/custome.js',

    ], 'public/assets/js/main.min.js', './');

    mix.version([
      'assets/css/signin.min.css',
      'assets/js/signin.min.js',
      'assets/css/main.min.css',
      'assets/js/main.min.js',
    ], './');



});
