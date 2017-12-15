<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      <span aria-hidden="true">×</span></button>
	    <h4 class="modal-title">Form Edit</h4>
	  </div>

	  {{ form_open($module . '/update' , ['class' => 'form-horizontal', 'id' => 'my-form']) }}

	  {{ form_hidden('grid_id', $data['id']) }}
	  {{ form_hidden('parent_id', $data['parent_id']) }}

	  <div class="modal-body">
	    
		<div class="form-group">
		  <label for="name" class="col-sm-2 control-label"> Nama <sup class="text-red">*</sup></label>
		  <div class="col-sm-10">
		    {{ form_input('name', $data['name'], ['class' => 'form-control']) }}
		  </div>
		</div>

		<div class="form-group">
		  <label for="name" class="col-sm-2 control-label"> URL <sup class="text-red">*</sup></label>
		  <div class="col-sm-10">
		    <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                {{ form_input('url', $data['url'], ['class' => 'form-control']) }}
            </div>
		  </div>
		</div>

		<div class="form-group">
		  	<label for="icon" class="col-sm-2 control-label"> Icon</label>
	        <div class="col-md-8">
	            <div class="input-group">
	                <span class="input-group-addon"><i class="fa fa-photo"></i></span>
	                {{ form_input('icon', $data['icon'], ['class' => 'form-control']) }}
	            </div>
	        </div>
	    </div>

		<div class="form-group">
		  <label for="name" class="col-sm-2 control-label"> Deskripsi</label>
		  <div class="col-sm-10">
          	{{ form_textarea('description', $data['description'], ['class' => 'form-control', 'style' => 'height: 80px' ]) }}
		  </div>
		</div>

	  </div>

	  <div class="modal-footer">
	    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
	    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
	  </div>

	  {{ form_close() }}

	</div>
<!-- /.modal-content -->
</div>

<script type="text/javascript">
	$(function(){
		$('form#my-form').submit(function(e){
			e.preventDefault();
			$(this).myAjax({
				waitMe: '.modal-dialog',
	            success: function (data) {
	                $('.modal').modal('hide');
	                loadNestable();
	            }
	        }).submit();
		});
	});
</script>