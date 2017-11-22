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

    mix.styles([
        // Vendor
        'themes/backend/smartadmin/css/bootstrap.min.css',
        'themes/backend/smartadmin/css/font-awesome.min.css',
        'themes/backend/smartadmin/css/smartadmin-production.min.css',
        'themes/backend/smartadmin/css/slider/rv.css',
        'themes/backend/smartadmin/css/customs.css',

    ], 'public/themes/backend/smartadmin/css/login.min.css', './');

    mix.scripts([
      // Vendor
      'themes/backend/smartadmin/js/libs/jquery-2.1.1.min.js',
      'themes/backend/smartadmin/js/plugin/moment.js',
      'themes/backend/smartadmin/js/plugin/datetimepicker/js/datetimepicker.min.js',
      // Custom
      'themes/global/js/my-clock.js',
    ], 'public/themes/backend/smartadmin/js/login.min.js', './');

    mix.copy('themes/backend/smartadmin/img/rev', 'themes/backend/img/rev');

    /*
     |--------------------------------------------------------------------------
     | AdminLTE : Default Assets Setup
     |--------------------------------------------------------------------------
     */

    mix.styles([
        // Vendor
        'themes/backend/adminlte/libs/bootstrap/css/bootstrap.min.css',
        'themes/backend/adminlte/libs/font-awesome/css/font-awesome.min.css',
        'themes/backend/adminlte/libs/ionicons/css/ionicons.min.css',
        'themes/backend/adminlte/libs/web-icons/web-icons.min.css',
        'themes/backend/adminlte/libs/simple-line-icons/css/simple-line-icons.min.css',
        'themes/backend/adminlte/libs/uniform/css/uniform.default.css',
        'themes/backend/adminlte/libs/sweetalert/sweetalert.css',
        'themes/backend/adminlte/libs/smartadmin/smartadmin.css',
        'themes/backend/adminlte/libs/toastr/toastr.min.css',
        'themes/backend/adminlte/libs/jasny-bootstrap/css/jasny-bootstrap.min.css',
        'themes/backend/adminlte/libs/bootstrap-modal/css/bootstrap-modal.css',
        'themes/backend/adminlte/libs/bootstrap-modal/css/bootstrap-modal-bs3patch.css',
        'themes/backend/adminlte/libs/select2/select2.css',
        'themes/backend/adminlte/libs/datetimepicker/css/datetimepicker.css',
        'themes/backend/adminlte/libs/jquery-treegrid/css/jquery.treegrid.css',
        'themes/backend/adminlte/libs/summernote/summernote.css',
        // 'themes/backend/adminlte/libs/org-chart/css/jquery.orgchart.css',
        'themes/backend/adminlte/libs/dependent-dropdown/css/dependent-dropdown.min.css',
        'themes/backend/adminlte/libs/twitter-suggesting/css/bootstrap-suggest.css',
        'themes/backend/adminlte/libs/googleapis/css/fonts-googleapis.min.css',
        'themes/backend/adminlte/css/AdminLTE.min.css',
        'themes/backend/adminlte/css/skins/_all-skins.min.css',
        'themes/backend/adminlte/css/custom.css',

    ], 'public/themes/backend/adminlte/css/default.min.css', './');

    mix.scripts([
      // Vendor
      'themes/backend/adminlte/libs/jquery.min.js',
      // 'themes/global/js/org-chart/jquery.min.js',
      'themes/backend/adminlte/libs/jquery.live.js',
      'themes/backend/adminlte/libs/jquery.form.js',
      'themes/backend/adminlte/libs/jquery.hotkeys.js',
      'themes/backend/adminlte/libs/bootstrap/js/bootstrap.min.js',
      'themes/backend/adminlte/libs/jquery-slimscroll/jquery.slimscroll.min.js',
      'themes/backend/adminlte/libs/fastclick/fastclick.min.js',
      'themes/backend/adminlte/libs/js.cookie.min.js',
      'themes/backend/adminlte/libs/moment.js',
      'themes/backend/adminlte/libs/uniform/js/jquery.uniform.min.js',
      'themes/backend/adminlte/libs/handlebars.js',
      'themes/backend/adminlte/libs/bootstrap-switch/js/bootstrap-switch.min.js',
      'themes/backend/adminlte/libs/bootstrap-modal/js/bootstrap-modal.js',
      'themes/backend/adminlte/libs/bootstrap-modal/js/bootstrap-modalmanager.js',
      'themes/backend/adminlte/libs/jquery-loading-overlay/loadingoverlay.js',
      'themes/backend/adminlte/libs/sweetalert/sweetalert.min.js',
      'themes/backend/adminlte/libs/smart-notification/smart-notification.min.js',
      'themes/backend/adminlte/libs/toastr/toastr.min.js',
      'themes/backend/adminlte/libs/select2/select2.full.min.js',
      'themes/backend/adminlte/libs/datetimepicker/js/datetimepicker.min.js',
      'themes/backend/adminlte/libs/jquery-validation/js/jquery-validate.min.js',
      'themes/backend/adminlte/libs/jquery-validation/js/additional-methods.min.js',
      'themes/backend/adminlte/libs/typeahead/typeahead.bundle.min.js',
      'themes/backend/adminlte/libs/jquery-numeric/jquery.numeric.js',
      'themes/backend/adminlte/libs/jquery-number/jquery.number.min.js',
      'themes/backend/adminlte/libs/slimscroll/jquery.slimscroll.min.js',
      'themes/backend/adminlte/libs/datatables/jquery.dataTables.min.js',
      'themes/backend/adminlte/libs/datatables/dataTables.bootstrap.min.js',
      'themes/backend/adminlte/libs/jquery-treegrid/js/jquery.cookie.js',
      'themes/backend/adminlte/libs/jquery-treegrid/js/jquery.treegrid.min.js',
      'themes/backend/adminlte/libs/jquery-treegrid/js/jquery.treegrid.bootstrap3.js',
      'themes/backend/adminlte/libs/summernote/summernote.min.js',
      'themes/backend/adminlte/libs/html2canvas/html2canvas.min.js',
      // 'themes/backend/adminlte/libs/org-chart/js/jquery.orgchart.js',
      'themes/backend/adminlte/libs/jasny-bootstrap/js/jasny-bootstrap.min.js',
      'themes/backend/adminlte/libs/typehead/bootstrap3-typeahead.min.js',
      'themes/backend/adminlte/libs/fuelux/wizard/wizard.min.js',
      'themes/backend/adminlte/libs/dependent-dropdown/dependent-dropdown.js',
      'themes/backend/adminlte/libs/dependent-dropdown/depdrop_locale_LANG.js',
      'themes/backend/adminlte/libs/highcharts/highcharts.js',
      'themes/backend/adminlte/libs/highcharts/drilldown.js',
      'themes/backend/adminlte/libs/highcharts/exporting.js',
      'themes/backend/adminlte/libs/highcharts/offline-exporting.js',
      'themes/backend/adminlte/libs/twitter-suggesting/js/bootstrap-suggest.js',
      'themes/backend/adminlte/js/app.js',
      'themes/backend/adminlte/js/demo.js',
      'themes/global/js/my-app.js',
      'themes/global/js/my-datatable.js',
      'themes/global/js/my-form.js',
      'themes/global/js/my-global.js',
      'themes/global/js/my-clock.js',

    ], 'public/themes/backend/adminlte/js/default.min.js', './');

    mix.copy('themes/backend/adminlte/libs/ionicons/fonts', 'themes/backend/adminlte/fonts');
    mix.copy('themes/backend/adminlte/libs/font-awesome/fonts', 'themes/backend/adminlte/fonts');
    mix.copy('themes/backend/adminlte/libs/googleapis/fonts', 'themes/backend/adminlte/fonts');
    mix.copy('themes/backend/metronic/libs/bootstrap/fonts', 'themes/backend/adminlte/fonts');

    mix.version([
      'themes/backend/smartadmin/css/login.min.css',
      'themes/backend/smartadmin/js/login.min.js',

      'themes/backend/adminlte/css/default.min.css',
      'themes/backend/adminlte/js/default.min.js',
    ], './');



});
