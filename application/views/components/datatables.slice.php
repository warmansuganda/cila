<table id="{{ isset($id) ? $id :  'dt-basic' }}"
       class="table table-striped table-hover"
       width="100%" style="margin-top: 0 !important;"
       data-table-source="{{ base_url(isset($data_source) ? $data_source : '') }}"
       data-table-filter="{{ isset($filter_id) ? $filter_id :  '#form-filter' }}">
    <thead>
	    <tr>
	    	<th>
	    		<div class="btn-group btn-group-dt-delete">
		    		<button type="button" class="btn btn-default btn-flat dropdown-toggle btn-dropdown-action" data-toggle="dropdown" aria-expanded="false" style="width: 22px;height: 22px; padding: 0px;">
		            	<span class="caret"></span>
		                <span class="sr-only">Toggle Dropdown</span>
		             </button>
		             <ul class="dropdown-menu" role="menu">
		                <li>
		                  	{{ anchor('#', '<i class="fa fa-check-square-o"></i> Sellect All', ['class' => 'btn-checked-all'  ]) }}
		                </li>
		                <li>
		                  	{{ anchor('#', '<i class="fa fa-square-o"></i> Deselect All', ['class' => 'btn-unchecked-all'  ]) }}
		                </li>
		                <li class="divider"></li>
		                <li>
		                  	{{ anchor('#', '<i class="fa fa-trash"></i> Delete Selected', ['class' => 'btn-delete-selected'  ]) }}
		                </li>
		            </ul>
		        </div>
	    	</th>
	    	@if (isset($header) && count($header) > 0)
	    		@foreach($header as $key => $value)
		    		<th>{{ $value }}</th>
		    	@endforeach
		    @endif
	    </tr>
    </thead>
</table>