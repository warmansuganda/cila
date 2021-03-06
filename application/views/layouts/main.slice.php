<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ $this->security->get_csrf_hash() }}">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="{{ base_url() . elixir('assets/css/main.min.css') }}">
	<style type="text/css">
	</style>
	@yield('css')
</head>
<body class="hold-transition skin-black sidebar-mini">
	<div class="wrapper">
		<!-- Header -->
		<header class="main-header">
			@include('partials.header')
		</header>

	    <!-- Sidebar -->
	    <!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
		    <!-- sidebar: style can be found in sidebar.less -->
		    <section class="sidebar">
	    		@include('partials.sidebar')
	    	</section>
	    </aside>

	    <!-- Content Wrapper. Contains page content -->
  		<div class="content-wrapper">
	        <!-- We'll fill this with dummy content -->
	        @yield('content')
	    </div>

	    <footer class="main-footer">
		    @include('partials.footer')
		</footer>
	</div> 

	<!-- BOX MODAL -->
	<div class="modal" id="modal-form" data-backdrop="static"></div>
    <div class="modal container" id="modal-wide" data-backdrop="static"></div>

	<script type="text/javascript" src="{{ base_url() . elixir('assets/js/main.min.js') }}"></script>
	<script type="text/javascript" src="{{ base_url('resources/js/form.js') }}"></script>
	<script type="text/javascript" src="{{ base_url('resources/js/ajax.js') }}"></script>
	<script type="text/javascript">
		NProgress.start();
	</script>
	<script type="text/javascript">
	    $(function(){
	    	NProgress.done();
	    	// Side clock
	    	$('#live-date').clock({"langSet": "id", "timer": "false"});
            $('#live-time').clock({"format": "24", "calendar": "false"});
	    });
	</script>
	@yield('js')
</body>
</html>