<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="{{ elixir('assets/css/main.min.css') }}">
	<style type="text/css">
		#nprogress .spinner {
			display: none !important;
		}
	</style>
	@yield('css')
</head>
<body>
	<div class="wrapper">
		<!-- Header -->
		@include('partials.header')

	    <!-- Sidebar -->
	    <nav id="sidebar">
	    	@include('partials.sidebar')
	    </nav>

	    <!-- Page Content -->
	    <div id="content">
	        <!-- We'll fill this with dummy content -->
	        @yield('content')
	    </div>

	    @include('partials.footer')

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