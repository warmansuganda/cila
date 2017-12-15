{{ form_open($module . '/update-order' , ['id' => 'update_order']) }}

    <div class="alert alert-info alert-block" id="confirm-ordering" style="display: none">
        <h4 class="alert-heading">Konfirmasi !</h4>
        Urutan menu telah diubah, simpan perubahan ?

        <button type="button" id="btn_cancel" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>

    </div>

    <div class="row">
       
        {{ form_hidden('nestable_output') }}
        {{ form_hidden('nestable_temp') }}
      
    </div>

{{ form_close() }}

<div>{{ $menus }}</div>

<script type="text/javascript">
  $(function(){
    initModalAjax();
    $('.dd').nestable({ /* config options */ });
    $('.btn-delete').click(function(){
    	$(this).myAjax({
            success: function (data) {
                loadNestable();
            }
        }).delete();

    	return false;
    });

    /* Update ordering */
    var showConfirmOder = function(status) {
        var _box = $('#confirm-ordering');

        if(status) {
            _box.show();
        } else {
            _box.hide();
        }
    }; 

    var updateOrdering = function(e) {
        var list = e.length ? e : $(e.target), _output = list.data('output');

        if(window.JSON) {
            var _serialize_order = list.nestable('serialize');
            var _temp = $('[name="nestable_temp"]');

            if (_temp.val() === '') {
                _temp.val(window.JSON.stringify(_serialize_order));
            }

            _output.val(window.JSON.stringify(_serialize_order));
           
            if (_temp.val() !== _output.val()) {
                showConfirmOder(true);
            } else {
                showConfirmOder(false);
            }
        } else {
            alert('JSON browser support required for this demo.');
        }
    };

    updateOrdering($('.dd').data('output', $('[name="nestable_output"]')));

    $('.dd').nestable().on('change', updateOrdering);

    $('#update_order').submit(function(event) {
        event.preventDefault();
        $(this).myAjax({
            success : function(data) {
                showConfirmOder(false);
            }
        }).submit();
    });

    $('#btn_cancel', $('#update_order')).click(function(event) {
        event.preventDefault();
        loadNestable();
    });
  })
</script>