// Page Setup
function initPage() {
    $('[data-toggle="switch"]').bootstrapSwitch();
    $('select.select2').select2();
}

//REMOTE MODAL
function initModalAjax(selector) {
    var selector_triger = typeof selector !== 'undefined' ? selector : '[data-toggle="modal"]';
    $(selector_triger).click(function(e) {
        /* Parameters */
        var url = $(this).attr('href');
        var container = $(this).attr('data-target');

        if (url.indexOf('#') == 0) {
            $(container).modal();
        } else {
            /* XHR */
            NProgress.start();
            $(container).modal();
            $(container).html('').load(url, function(){
                NProgress.done();
            });
        }
        return false;
    });
}

// DATA TABLES
function initDatatableAction(table_id, callback) {
    $('input', table_id).iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('.btn-delete', table_id).click(function(){
        $(this).myAjax({
              success: function (data) {
                  callback();
              }
          }).delete();

        return false;
    });

}

function initDatatableTools(table_id, header_id, oTable) {

    var $form_filter = $(table_id).attr('data-table-filter'); 

    $($form_filter).submit(function (e) {
        e.preventDefault();
        oTable.reload();
    });

    $('.filter-select', $($form_filter)).change(function (event) {
        event.preventDefault();

        var $auto_filter = $(table_id).attr('data-auto-filter'); 
        if ($auto_filter == 'true') {
            oTable.reload();
        }
    });

    $('.btn-checked-all, .btn-unchecked-all', table_id).click(function () {
        var id = $(this).attr('class');

        if (id == 'btn-checked-all') {
          $('input', table_id).iCheck('check');
        } else {
          $('input', table_id).iCheck('uncheck');
        }
        return false;
    });

    $('.btn-delete-selected', table_id).click(function () {
        var id = [];

        $.each($('.checkbox-id', table_id), function(){
            if ($(this).is(':checked')) {
                id.push($(this).val());
            }
        });

        if (id.length > 0) {
            $(this).myAjax({
                data: {
                    grid_id: id
                },
                success: function (data) {
                    oTable.reload();
                }
            }).delete();
        } else {
            command: toastr["warning"]("Data yang akan dihapus tidak ditemukan.");
        }

        return false;
    });

    $('.auto_filter', header_id).on('switchChange.bootstrapSwitch', function(event, state) {
      $('table#main-table').attr('data-auto-filter', $(this).is(':checked') ? 'true' : 'false');
    });

    $('.reload-table', header_id).click(function(){
      oTable.reload();
      return false;
    });

    $('.reset-filter', header_id).click(function(){
      oTable.filterReset();
      return false;
    });
}