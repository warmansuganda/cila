<h1 style="border-left: 4px solid #126a99;padding-left: 15px;">
	{{ $title }}
	<small>{{ $description }}</small>
</h1>
<ol class="breadcrumb">
	@foreach($this->navigation->breadcrumb() as $value)
		<li><a href="{{$value['url']}}"><i class="{{$value['icon']}}"></i> {{$value['label']}}</a></li>
	@endforeach

	@if (isset($breadcrumb) && is_array($breadcrumb))
		@foreach($breadcrumb as $key => $value)
			<li><a href="{{ $key }}">{{ $value }}</a></li>
		@endforeach		
	@endif
</ol>