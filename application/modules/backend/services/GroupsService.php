<?php

class GroupsService extends BaseService {

    function __construct() {
        parent::__construct();
    }

    public function create(array $data) {

        try {
            $event = GroupsModel::create([
                'name'        => $data['name'],
                'description' => $data['description'],
                'status'      => $data['status'],
            ]);
            $id    = $event->id;

            $event->menus()->attach($this->parsingAuthorities($data));

            return [
                'code'    => 200,
                'status'  => 'success',
                'message' => 'Created successfully.',
                'data'    => [
                    '_id' => $this->encrypt->encode($id),
                ]
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

    private function parsingAuthorities($input)
    {
        $authorities = [];

        foreach ($input['read'] as $key => $value) {
            $menu_id = $this->encrypt->decode($value);
            $authorities[$menu_id]['authority_read'] = $value ? TRUE : FALSE;
            $authorities[$menu_id]['authority_create'] = isset($input['create'][$key]) ? TRUE : FALSE;
            $authorities[$menu_id]['authority_update'] = isset($input['update'][$key]) ? TRUE : FALSE;
            $authorities[$menu_id]['authority_delete'] = isset($input['delete'][$key]) ? TRUE : FALSE;
            $authorities[$menu_id]['authority_import'] = isset($input['import'][$key]) ? TRUE : FALSE;
            $authorities[$menu_id]['authority_export'] = isset($input['export'][$key]) ? TRUE : FALSE;
            $authorities[$menu_id]['authority_approve'] = isset($input['approve'][$key]) ? TRUE : FALSE;
            $authorities[$menu_id]['authority_data'] = isset($input['data'][$key]) ? $input['data'][$key] : 1;
        }

        return $authorities;
    }

    public function read(array $data) {
        $query = GroupsModel::data();
        $options = [
            'module'     => 'backend/groups',
            'encrypt' => $this->encrypt
        ];

        return $this->datatables->of($query)
            ->filter(function($query) use ($data) {
                if (!empty($data['name'])) {
                    $query->where('name', 'admin');
                }
                return $query;
            })
            ->addColumn('checkbox', function($query) use ($options) {
                return form_checkbox('id[]', $options['encrypt']->encode($query->id), FALSE, ['class' => 'checkbox-id']);
            })
            ->addColumn('group_admin', function($query) {
                return $query->status ? 'Ya' : 'Bukan';
            })
            ->addColumn('status', function($query) {
                return dropdown_status($query->status);
            })
            ->addColumn('action', function($query) use ($options) {
                $action[] = anchor($options['module'] . '/edit?grid_id=' . $options['encrypt']->encode($query->id), '<i class="fa fa-edit"></i> Edit', [
                    'class' => 'btn btn-warning btn-xs',
                    'rel' => 'tooltip',
                    'title' => 'Edit'
                ]);
                $action[] = anchor($options['module'] . '/delete?grid_id=' . $options['encrypt']->encode($query->id), '<i class="fa fa-trash"></i> Delete', [
                    'class' => 'btn btn-danger btn-xs btn-delete'
                ]);
                return implode(' ', $action);
            })
            ->make();
    }

    public function get(array $data)
    {
        $id = $data['id'];

        if (!empty($id)) {
            $query = GroupsModel::find($this->encrypt->decode($id));
            if ($query) {
                $read           = [];
                $create         = [];
                $update         = [];
                $delete         = [];
                $import         = [];
                $export         = [];
                $approve         = [];
                $authority_data = [];

                foreach ($query->menus as $value) {
                    $dt = $value->pivot;
                    $menu_id = $dt->menu_id;

                    if ($dt->authority_read)
                        $read[] = $menu_id;
                    if ($dt->authority_create)
                        $create[] = $menu_id;
                    if ($dt->authority_update)
                        $update[] = $menu_id;
                    if ($dt->authority_delete)
                        $delete[] = $menu_id;
                    if ($dt->authority_import)
                        $import[] = $menu_id;
                    if ($dt->authority_export)
                        $export[] = $menu_id;
                    if ($dt->authority_approve)
                        $approve[] = $menu_id;

                    $authority_data[$menu_id] = $dt->authority_data;

                }

                return [
                    'id'          => $this->encrypt->encode($query->id),
                    'name'        => $query->name,
                    'is_admin'    => $query->is_admin,
                    'description' => $query->description,
                    'status'      => $query->status,
                    'menus'       => [
                        'read'           => $read,
                        'create'         => $create,
                        'update'         => $update,
                        'delete'         => $delete,
                        'import'         => $import,
                        'export'         => $export,
                        'approve'        => $approve,
                        'authority_data' => $authority_data
                    ]
                ];
            }
        }

        return NULL;
    }

    public function update(array $data) {
        $id = $data['id'];

        try {
            $query = GroupsModel::find($this->encrypt->decode($id));
            if ($query) {
                if ($query->update($data)) {
                    $query->menus()->sync($this->parsingAuthorities($data));
                }

                return [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => 'Created successfully.',
                    'data'    => [
                        '_id' => $id,
                    ]
                ];
            }

            return [
                'code'    => 422,
                'status'  => 'error',
                'message' => 'Id tidak ditemukan.',
                'data'    => [
                    '_id' => $id,
                ]
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
        return GroupsModel::deleteOne($data['id']);
    }

    public function get_nestable(array $data) {
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

        $options = [
            'module'     => 'backend/menus',
            'encrypt' => $this->encrypt
        ];

        $this->ci->load->library('nestable');
        return $this->ci->nestable
            ->of($menus)
            ->options(['drag' => false])
            ->make(function($value) use ($options, $data) {
                $base_url  = base_url($options['module']);
                $key        = uniqid('auth_');
                $id        = $value['id'];
                $encode_id = $options['encrypt']->encode($value['id']);

                $nestable = '';
                $nestable .= '<span class="pull-left dd-group-tools"><i class="fa fa-eye"></i></span>';
                $nestable .= '<span class="pull-left">' . form_checkbox('read[' . $key . ']', $encode_id, in_array($id, is_array($data['read']) ? $data['read'] : []), ['class' => 'checkbox-id']) . '</span>';
                $nestable .= '<span class="pull-left dd-group-tools"><i class="fa fa-plus"></i></span>';
                $nestable .= '<span class="pull-left">' . form_checkbox('create[' . $key . ']', $encode_id, in_array($id, is_array($data['create']) ? $data['create'] : []), ['class' => 'checkbox-id']) . '</span>';
                $nestable .= '<span class="pull-left dd-group-tools"><i class="fa fa-edit"></i></span>';
                $nestable .= '<span class="pull-left">' . form_checkbox('update[' . $key . ']', $encode_id, in_array($id, is_array($data['update']) ? $data['update'] : []), ['class' => 'checkbox-id']) . '</span>';
                $nestable .= '<span class="pull-left dd-group-tools"><i class="fa fa-trash"></i></span>';
                $nestable .= '<span class="pull-left">' . form_checkbox('delete[' . $key . ']', $encode_id, in_array($id, is_array($data['delete']) ? $data['delete'] : []), ['class' => 'checkbox-id']) . '</span>';

                return '<div style="margin-top: -2px">' . $nestable . '</div>';
            });
    }

}
