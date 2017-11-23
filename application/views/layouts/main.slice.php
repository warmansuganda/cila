<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="wrapper">
	    @include('partials.header')

	    @include('partials.sidebar')

	    <div class="content-wrapper">
	        @yield('content')
	    </div>

	    @include('partials.footer')
	</div>
</body>
</html>