<table id="{{ isset($table_id) ? $table_id :  'dt-basic' }}"
       class="table table-striped table-hover"
       width="100%" style="margin-top: 0 !important;"
       data-table-source="{{ isset($data_source) ? $data_source : '' }}"
       data-table-filter="{{ isset($filter_id) ? $filter_id :  '#form-filter' }}">
    <thead>
	    <tr>
	    	@if (isset($header) && count($header) > 0)
	    		@foreach($header as $key => $value)
		    		<th>{{ $value }}</th>
		    	@endforeach
		    @endif
	    </tr>
    </thead>
</table>