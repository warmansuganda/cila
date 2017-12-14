<?php

class MenusService extends BaseService {
    
    function __construct() {
        parent::__construct();
    }

    public function create(array $data) {
        return MenusModel::createOne([ 
            'name'        => $data['name'],
            'description' => $data['description'],
            'url'         => $data['url'],
            'icon'        => $data['icon'],
            'parent_id'   => !empty($data['parent_id']) ? $this->encrypt->decode($data['parent_id']) : NULL
        ]);
    }

    public function read(array $data) {
        $query = MenusModel::data()->get();
        $menus = [];
        foreach ($query->sortBy(function($q){ return $q->order; }) as $menu) {
            $parent_id = !empty($menu->parent_id) ? $menu->parent_id : 0;
            $menus[$parent_id][] = [
                'id'        => $menu->id,
                'parent_id' => $menu->parent_id,
                'label'     => $menu->name,
                'icon'      => $menu->icon,
                'url'       => $menu->url
            ];
        }

        $this->ci->load->library('nestable');
        return $this->ci->nestable->of($menus)->setBaseURL('backend/menus')->make();
    }

    public function get(array $data)
    {
        $id = $data['id'];

        if (!empty($id)) {
            $query = MenusModel::find($this->encrypt->decode($id));
            if ($query) {
                return [
                    'id'          => $this->encrypt->encode($query->id),
                    'parent_id'   => $this->encrypt->encode($query->parent_id),
                    'name'        => $query->name,
                    'url'         => $query->url,
                    'description' => $query->description,
                    'icon'        => $query->icon
                ];
            }
        }

        return NULL;
    }

    public function update(array $data) {
        return MenusModel::updateOne($this->encrypt->decode($data['id']), [ 
            'name'        => $data['name'],
            'description' => $data['description'],
            'url'         => $data['url'],
            'icon'        => $data['icon']
        ]);
    }

    public function update_order(array $data) {
        try {
            $this->ci->load->library('nestable');
            $nestable = $data['nestable_output'];
            $cursors = $this->ci->nestable->ordering(json_decode($nestable));

            foreach ($cursors as $id => $cursor) {
                MenusModel::updateOne($this->encrypt->decode($id), [ 
                    'order'  => $cursor['order'],
                    'parent_id' => !empty($cursor['parent']) ? $this->encrypt->decode($cursor['parent']) : NULL
                ]);
            }

            return [
                'code'    => 200,
                'status'  => 'success',
                'message' => 'Urutan berhasil disimpan.',
                'data'    => $cursors
            ];
        } catch (Exception $e) {
            return [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem.',
                'data'    => $e
            ]; 
        }
        
    }

    public function delete(array $data) {
        $id = $this->encrypt->decode($data['id']);
        $query = MenusModel::where('parent_id', $id);
        if ($query->count() > 0) {
            return [
                'code'    => 422,
                'status'  => 'error',
                'message' => 'Data tidak dapat dihapus, dikarenakan memiliki turunan.'
            ];
        } 
        return MenusModel::deleteOne($id);
    }

}
