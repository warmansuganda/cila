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
            @include('components.index-tools', [ 'button' => [$module . '/add', '<i class="fa fa-plus"></i> Tambah', true, true], 'tools' => false ])

            <div class="box-title pull-right">
                <div class="actions" id="nestable-menu">
                    <button type="button" class="btn btn-sm btn-default" data-action="expand-all">Expand All</button>
                    <button type="button" class="btn btn-sm btn-default" data-action="collapse-all">Collapse All</button>
                </div>
            </div>
          </div>
          <div id="nestable" data-source="{{ base_url($module) }}/read" class="box-body"></div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  function loadNestable() {
    var $nestable = $('#nestable');
    var $source = $nestable.data('source');

    $('.box-widget').waitMe();
    $nestable.load($source, function(){
      $('.box-widget').waitMe("hide");
    });
  }  
</script>

<script type="text/javascript">
  $(function(){
    initModalAjax();
    loadNestable();

    $('#nestable-menu').on('click', function (e) {
        var target = $(e.target), action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
  })
</script>
@endsection