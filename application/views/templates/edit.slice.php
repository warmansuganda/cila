@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
<section class="content-header">
  @include('components.content-header', ['title' => $title, 'description' => $description, 'breadcrumb' => ['#' => 'Form Edit']])
</section>
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-header with-border">
            <h3 class="box-title">Form Edit</h3>
          </div>
          {{ form_open($module . '/update' , ['class' => 'form-horizontal', 'id' => 'my-form']) }}
          {{ form_hidden('grid_id', $data['id']) }}
          <div class="box-body">
            <<<form-edit>>>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Status</label>
              <div class="col-sm-5">
                <input type="checkbox" value="1" {{ $data['status'] ? 'checked' : '' }}  name="status"  data-toggle="switch" data-on-text="Aktif" data-off-text="Tidak Aktif">
              </div>
            </div>
          </div>
          <div class="box-footer">
            {{ anchor($module, 'Kembali', ['class' => 'btn btn-default pull-left']) }}
            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Simpan</button>
          </div>
          {{ form_close() }}
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  $(function(){
    initPage();
    
    $('form#my-form').submit(function(e){
      e.preventDefault();
      $(this).myAjax({
          success: function (data) {
              window.location = '{{ base_url($module) }}';
          }
        }).submit();
    });
  })
</script>
@endsection