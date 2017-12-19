@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
<section class="content-header">
  @include('components.content-header', ['title' => $title, 'description' => $description, 'breadcrumb' => ['#' => 'Form Tambah']])
</section>
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-header with-border">
            <h3 class="box-title">Form Tambah</h3>
          </div>
          {{ form_open($module . '/create' , ['class' => 'form-horizontal', 'id' => 'my-form']) }}
          <div class="box-body">
            
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> First Name <sup class="text-red">*</sup></label>
              <div class="col-sm-5">
                {{ form_input('first_name', '', ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Last Name <sup class="text-red">*</sup></label>
              <div class="col-sm-5">
                {{ form_input('last_name', '', ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Company <sup class="text-red">*</sup></label>
              <div class="col-sm-5">
                {{ form_input('company', '', ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Phone <sup class="text-red">*</sup></label>
              <div class="col-sm-5">
                {{ form_input('phone', '', ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Email <sup class="text-red">*</sup></label>
              <div class="col-sm-5">
                {{ form_input('email', '', ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Status</label>
              <div class="col-sm-5">
                <input type="checkbox" value="1" data-toggle="switch" name="status" data-on-text="Aktif" data-off-text="Tidak Aktif">
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