@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
<section class="content-header">
  @include('components.content-header', ['title' => $title, 'description' => $description, 'breadcrumb' => isset($breadcrumb) ? $breadcrumb : []])
</section>
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-header with-border">
            <h3 class="box-title">Form Add</h3>
          </div>
          <div class="box-body">
            {{ form_open() }}
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-3 control-label">Name</label>
                  <div class="col-md-9">
                    {{ form_input('name', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-3 control-label">Description</label>
                  <div class="col-md-9">
                    {{ form_input('description', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-3 control-label">Status</label>
                  <div class="col-md-9">
                    {{ form_dropdown('description', dropdown_status(), '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
            </div>
            {{ form_close() }}
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  $(function(){
    $('.dd').nestable({ /* config options */ });
  })
</script>
@endsection