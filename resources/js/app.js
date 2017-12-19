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
function initDatatable (table_id, callback_delete) {
  $('input', table_id).iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });

  $('.btn-delete', table_id).click(function(){
    $(this).myAjax({
          success: function (data) {
              callback_delete();
          }
      }).delete();

    return false;
  });
}

function initDatatableChecked (table_id, callback_delete) {
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
                    callback_delete();
                }
            }).delete();
        } else {
            command: toastr["warning"]("Data yang akan dihapus tidak ditemukan.");
        }

        return false;
    });
}