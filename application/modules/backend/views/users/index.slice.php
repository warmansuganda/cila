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
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-3 control-label">First Name</label>
                  <div class="col-md-9">
                    {{ form_input('first_name', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-3 control-label">Last Name</label>
                  <div class="col-md-9">
                    {{ form_input('last_name', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-3 control-label">Company</label>
                  <div class="col-md-9">
                    {{ form_input('company', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-3 control-label">Phone</label>
                  <div class="col-md-9">
                    {{ form_input('phone', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-3 control-label">Email</label>
                  <div class="col-md-9">
                    {{ form_input('email', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-3 control-label">Status</label>
                  <div class="col-md-9">
                    {{ form_dropdown('status', dropdown_status(), '', ['class' => 'form-control filter-select select2']) }}
                  </div>
                </div>
              </div>
            </div>
            {{ form_close() }}
          </div>
          <div class="box-body">
            @include('components.datatables', [ 'id' => 'main-table', 'header' => ['First Name', 'Last Name', 'Company', 'Phone', 'Email'], 'data_source' => $module . '/read', 'delete_action' => $module . '/delete'])
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  $(function(){
    initPage();

    var oTable = $('table#main-table').myDataTable({
        columns: [
          {data: 'checkbox', orderable: false, width: "1%"},
          {data: 'first_name', name:'first_name'},
          {data: 'last_name', name:'last_name'},
          {data: 'company', name:'company'},
          {data: 'phone', name:'phone'},
          {data: 'email', name:'email'},
          {data: 'action', name:'id', orderable: false}
        ],
        onDraw : function() {
          initDatatableAction($(this), function(){
            oTable.reload();
          });
        }
    });

    initDatatableTools($('table#main-table'), $('#main-header'), oTable);

  })
</script>
@endsection