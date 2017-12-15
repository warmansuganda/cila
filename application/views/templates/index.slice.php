@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
<section class="content-header">
  <h1>
    {{ $title }}
    <small>{{ $description }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-header with-border">
            @include('components.index-tools', [ 'button' => [$module . '/add', '<i class="fa fa-plus"></i> Add New', true] ])
          </div>
          <div class="box-header with-border">
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
                    {{ form_dropdown('description', [], '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
            </div>
            {{ form_close() }}
          </div>
          <div class="box-body">
            @include('components.datatables', [ 'table_id' => 'main-table', 'header' => ['Name', 'Description', 'Status', 'Action'] ])
          </div>
          <div class="box-footer">
            
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  $(function(){
    var autoFilter = true;
    var oTable = $('table#main-table').myDataTable({
        columns: [
            {data: 'score', name: 'score'},
            {data: 'desc', name: 'desc'},
            {data: 'status', name: 'status'},
            {data: 'action', name:'id', className:'hide-orderable-node'}
        ]
    });
  })
</script>
@endsection