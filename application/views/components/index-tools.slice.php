<div id="{{ isset($id) ? $id : 'main-header'}}">
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

    @if(!isset($tools) || $tools)
    <div class="box-title pull-right">
        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-gear"></i>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li class="box-auto-filter">
                Auto Filter :
                <input type="checkbox" value="1" checked class="auto_filter" data-toggle="switch" data-size="mini" data-on-text="Ya" data-off-text="Tidak">
            </li>
            <li class="divider"></li>
            <li><a href="#" class="reload-table"><i class="fa fa-refresh"></i>Muat Ulang</a></li>
            <li><a href="#" class="reset-filter"><i class="fa fa-undo"></i>Reset Filter</a></li>

            <!-- Extend other list menu -->
            @if (isset($menu) && count($menu) > 0)
                <li class="divider"></li>
                @foreach($menu as $key => $value)
                    <li><a href="javascript:void(0);" id="{{ $key }}">{{ $value }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
    @endif
</div>