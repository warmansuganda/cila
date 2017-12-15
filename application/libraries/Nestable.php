<?php

class Nestable
{
	private $ci;
	private $data = [];
	private $base_url = '';

	function __construct()
	{
		$this->ci = &get_instance();
	}

	public function of(array $data)
	{
		$this->data = $data;
		return $this;
	}

	public function setBaseURL($url='')
	{
		$this->base_url = base_url($url);
		return $this;
	}

	public function make()
	{
		$nestable  = '<div class="dd">';
		$nestable .= $this->render(0);
		$nestable .= '</div>';
		return $nestable;
	}

	private function render($parent_id)
	{	
		$nestable = '';

		if (isset($this->data[$parent_id])) {

			$nestable  .= '<ol class="dd-list">';

			foreach ($this->data[$parent_id] as $key => $value) {
				$id        = $value['id'];
				$encode_id = $this->ci->encrypt->encode($id);
				$url       = $value['url'] == '#' ? $value['url'] : '/' . $value['url'];
				$label     = $value['label'];
				$icon      = $value['icon'];

				$nestable .= '<li class="dd-item dd3-item" data-id="' . $encode_id . '">';
				$nestable .= '	<div class="dd-handle dd3-handle">Drag</div>';
				$nestable .= '	<div class="dd3-content">';
				// left content
				$nestable .= '		<i class="' . $icon . '"></i> ' . $label;
				$nestable .= '		<span class="text-info">' . $url . '</span>';
				// right content
				$nestable .= '		<div class="pull-right">';
				$nestable .= '			<a href="' . $this->base_url . '/add?parent_id=' . $encode_id .  '" class="text-primary" rel="tooltip" data-placement="top" data-title="Tambah" data-toggle="modal" data-target="#modal-form" style="margin:5px"><i class="fa fa-plus"></i> Tambah Turunan</a>';
				$nestable .= '			<a href="' . $this->base_url . '/edit?grid_id=' . $encode_id .  '" class="text-warning" rel="tooltip" data-placement="top" data-title="Edit" data-toggle="modal" data-target="#modal-form" style="margin:5px"><i class="fa fa-edit"></i> Edit</a>';
				$nestable .= '			<a href="' . $this->base_url . '/delete" data-grid="' . $encode_id .  '" class="btn-delete text-danger" rel="tooltip"><i class="fa fa-trash"></i> Hapus</a>';
				$nestable .= '		</div>';
				$nestable .= '	</div>';

				// load child 
				$nestable .= $this->render($id);

                $nestable .= '</li>';
			}

			$nestable .= '</ol>';
		}

		return $nestable;
	}

	public function ordering($nestable, $temp_ordering = [], $parent = NULL) {
        if (is_array($nestable)) {
            $order = 1;

            foreach ($nestable as $dt) {
                $temp_ordering[$dt->id] = [
                    'order' => $order,
                    'parent' => $parent
                ];

                if (isset($dt->children)) {
                    $temp_ordering = $this->ordering($dt->children, $temp_ordering, $dt->id);
                }

                $order++;
            }
            return $temp_ordering;
        }

        return [];
    }
}