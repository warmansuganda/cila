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
              <label for="name" class="col-sm-2 control-label"> Nama <sup class="text-red">*</sup></label>
              <div class="col-sm-5">
                {{ form_input('name', '', ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Group Admin</label>
              <div class="col-sm-3">
                <input type="checkbox" name="is_admin" data-on-text="Ya" data-off-text="Bukan">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"> Deskripsi</label>
              <div class="col-sm-8">
                {{ form_textarea('name', '', ['class' => 'form-control', 'style' => 'height: 100px;']) }}
              </div>
            </div>

            <fieldset>
              <legend>Otoritas Modul </legend>
              <div class="row">
                <div class="col-sm-4">
                  <div class="actions" id="nestable-menu">
                    <button type="button" class="btn btn-sm btn-default" data-action="expand-all">Expand All</button>
                    <button type="button" class="btn btn-sm btn-default" data-action="collapse-all">Collapse All</button>
                  </div>
                </div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4"></div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  {{ $nestable }}
                </div>
              </div>

            </fieldset>

          </div>
          <div class="box-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
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
    $("[name='is_admin']").bootstrapSwitch();
    $('form#my-form').submit(function(e){
      e.preventDefault();
      $(this).myAjax({
          success: function (data) {
              $('.modal').modal('hide');
              loadNestable();
          }
        }).submit();
    });

    $('.dd').nestable({ /* config options */ });
    $('#nestable-menu').on('click', function (e) {
        var target = $(e.target), action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('.checkbox-id').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  })
</script>
@endsection