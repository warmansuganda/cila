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
            <h3 class="box-title">Direct Chat</h3>
            <div class="box-tools pull-right">
              <span data-toggle="tooltip" title="" class="badge bg-light-blue" data-original-title="3 New Messages">3</span>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                <i class="fa fa-comments"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
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