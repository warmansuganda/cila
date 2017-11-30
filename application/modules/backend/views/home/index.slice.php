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
            @include('components.index-tools', [ 'button' => ['<i class="fa fa-plus"></i>', 'Add New', false] ])
          </div>
          <div class="box-body">
            
          </div>
          <div class="box-footer">
            
          </div>
        </div>
      </div>
    </div>
</section>
@endsection


@section('js')
<script type="text/javascript"></script>
@endsection