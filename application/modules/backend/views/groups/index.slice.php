@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
<section class="content-header">
  @include('components.content-header', ['id' => 'main-header', 'title' => $title, 'description' => $description])
</section>
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-header with-border">
            @include('components.index-tools', [ 'button' => [$module . '/add', '<i class="fa fa-plus"></i> Tambah', true] ])
          </div>
          <div class="box-header with-border">
            {{ form_open('', ['id' => 'form-filter']) }}
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
          <div class="box-body">
            @include('components.datatables', [ 'id' => 'main-table', 'header' => ['Name', 'Description', 'Group Admin', 'Status', 'Action'], 'data_source' => $module . '/read', 'delete_action' => $module . '/delete'])
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
          {data: 'checkbox', orderable: false, width: "1%"},
          {data: 'name', name: 'name'},
          {data: 'description', name: 'description'},
          {data: 'group_admin', name: 'group_admin'},
          {data: 'status', name: 'status'},
          {data: 'action', name:'id', orderable: false}
        ],
        onComplete: function() {
          initDatatable($(this), __reloadTable);
          initDatatableChecked($(this), __reloadTable);
        }, 
        onDraw : function() {
          initDatatable($(this), __reloadTable);
        }
    });

    var __reloadTable = function(refresh) {
        oTable.reload(refresh);
    }

    var __resetTable = function () {
        oTable.filterReset();
    }

    $('#main-header .reload-table').click(function(){
      __reloadTable();
      return false;
    });

    $('#main-header .reset-filter').click(function(){
      __resetTable();
      return false;
    });

  })
</script>
@endsection