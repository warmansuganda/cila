<div class="box-title pull-left">
  @if (isset($button[2]) && $button[2])
    <?php 
        $class = ['class' => 'btn btn-primary btn-sm'];
        if (isset($button[3]) && $button[3]) {
            $class['data-toggle'] = 'modal';
            $class['data-target'] = '#modal-form';
        }
    ?>
    {{ anchor($button[0], $button[1], $class) }}
  @else
    <i class="fa fa-search" style="margin: 5px;"></i>
  @endif
</div>
<div class="box-title pull-right">
    <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-gear"></i>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li class="box-auto-filter">
            Auto Filter :
            <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
                <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
            </div>
        </li>
        <li class="divider"></li>
        <li><a href="javascript:void(0);" onclick="__reloadTable()"><i class="fa fa-refresh"></i>Muat Ulang</a></li>
        <li><a href="javascript:void(0);" onclick="__resetTable()"><i class="fa fa-undo"></i>Reset Filter</a></li>

        <!-- Extend other list menu -->
        @if (isset($menu) && count($menu) > 0)
            <li class="divider"></li>
            @foreach($menu as $key => $value)
                <li><a href="javascript:void(0);" id="{{ $key }}">{{ $value }}</a></li>
            @endforeach
        @endif
    </ul>
</div>