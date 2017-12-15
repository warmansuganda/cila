<?php

class Navigation
{
	private $ci;

	function __construct()
	{
		$this->ci = &get_instance();
	}

	private function data()
	{	
		$query = MenusModel::get();
		$data = [];
		$active_menu = ''; 

		foreach ($query->sortBy(function($q){ return $q->order; }) as $menu) {
			$parent_id = !empty($menu->parent_id) ? $menu->parent_id : 0;
			$url = $menu->url == '#' ? $menu->url : base_url($menu->url);

			$active = preg_match('/^' . str_replace('/', '\/', $menu->url) . '/', uri_string());

			if ($active_menu == '' && $active) {
				$active_menu = $menu->id;
			}

			$data[$menu->id] = [
				'id'          => $menu->id,
				'parent_id'   => $parent_id,
				'label'       => $menu->name,
				'icon'        => $menu->icon,
				'description' => $menu->description,
				'order'       => $menu->order,
				'url'         => $url,
				'active'      => $active
			];
		}

		// update status
		if (!empty($active_menu)) {
			$data = $this->setActiveMenu($data, $active_menu);
		}


		// data tree
		$tree = [];

		foreach ($data as $value) {
			$tree[$value['parent_id']][] = $value;
		}

		return $tree;
	}

	private function setActiveMenu(array $data, $active_menu)
	{
		if (isset($data[$active_menu])) {
			$data[$active_menu]['active'] = true;
			$active_menu = $data[$active_menu]['parent_id'];
			if (!empty($active_menu)) {
				$data = $this->setActiveMenu($data, $active_menu);
			}
		}

		return $data;
	}

	public function make()
	{
		$data = $this->data();

		$nav  = '<ul class="sidebar-menu" data-widget="tree">';
		$nav .= $this->generate($data);
		$nav .= '</ul>';

		return $nav;
	}

	private function generate(array $data, $parent_id = 0)
	{
		$temp_menu = '';

		if (isset($data[$parent_id])) {
			foreach ($data[$parent_id] as $value) {
				$have_child = isset($data[$value['id']]);
				$className = '';
				if ($have_child) {
					$className .= 'treeview ';
				}

				if ($value['active']) {
					$className .= 'menu-open active';
				}

				$temp_menu .= '<li class="' . $className . '">';
				$temp_menu .= '	<a href="' . $value['url'] . '">';
			    $temp_menu .= '		<i class="' . $value['icon'] . '"></i> <span>' . $value['label'] . '</span>';

			    if ($have_child) {
			  		$temp_menu .= '	<span class="pull-right-container">
					              <i class="fa fa-angle-left pull-right"></i>
					            </span>';
			    }

			  	$temp_menu .= '	</a>';

			  	// check child
			  	if ($have_child) {
			  		$temp_menu .= '<ul class="treeview-menu">';
			  		$temp_menu .= $this->generate($data, $value['id']);
			  		$temp_menu .= '</ul>';
			  	}

				$temp_menu .= '</li>';
			}
		}

		return $temp_menu;
	}
}