<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="{{ elixir('assets/css/main.min.css') }}">
	@yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
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

	<script type="text/javascript" src="{{ elixir('assets/js/main.min.js') }}"></script>
	<script type="text/javascript">
		NProgress.start();
	</script>
	<script type="text/javascript">
	    $(function(){
	    	NProgress.done();
	    });
	</script>
	@yield('js')
</body>
</html>