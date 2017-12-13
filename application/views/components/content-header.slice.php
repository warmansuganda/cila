<h1 style="border-left: 4px solid #126a99;padding-left: 15px;">
	{{ $title }}
	<small>{{ $description }}</small>
</h1>
<ol class="breadcrumb">
	@if (is_array($breadcrumb) && count($breadcrumb) > 0)
		<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		@foreach($breadcrumb as $key => $value)
			<li><a href="{{$key}}">{{$value}}</a></li>
		@endforeach
	@else 
		<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">{{ $title }}</li>
	@endif
</ol>