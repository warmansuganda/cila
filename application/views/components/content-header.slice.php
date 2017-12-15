<h1 style="border-left: 4px solid #126a99;padding-left: 15px;">
	{{ $title }}
	<small>{{ $description }}</small>
</h1>
<ol class="breadcrumb">
	@if (is_array($breadcrumb) && count($breadcrumb) > 0)
		<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		@foreach($breadcrumb as $value)
			<li><a href="{{$value['url']}}">{{$value['label']}}</a></li>
		@endforeach
	@else 
		@foreach($this->navigation->breadcrumb() as $value)
			<li><a href="{{$value['url']}}"><i class="{{$value['icon']}}"></i> {{$value['label']}}</a></li>
		@endforeach
	@endif
</ol>