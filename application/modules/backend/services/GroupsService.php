<?php

class GroupsService extends BaseService {

    function __construct() {
        parent::__construct();
    }

    public function create(array $data) {
        $authorities = $this->parsingAuthorities($data);

       return BaseModel::transaction(function() use ($data, $authorities) {
            return GroupsModel::createOne([
                'name'        => $data['name'],
                'description' => $data['description'],
                'is_admin'    => $data['is_admin'] ? 1 : 0,
                'status'      => $data['status']  ? 1 : 0,
            ], function($query, $event) use ($authorities){
                $event->menus()->attach($authorities);
            });
        });

    }

    private function parsingAuthorities($input)
    {
        $authorities = [];

        if (is_array($input['read'])) {
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
                if ($data['name'] != '') {
                    $query->whereLike('name', '%' . $data['name'] . '%');
                }
                
                if ($data['is_admin'] != '') {
                    $query->where('is_admin', $data['is_admin']);
                }
                
                if ($data['status'] != '') {
                    $query->where('status', $data['status']);
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
                $action[] = anchor($options['module'] . '/delete', '<i class="fa fa-trash"></i> Delete',[
                    'class' => 'btn btn-danger btn-xs btn-delete',
                    'data-grid' => $options['encrypt']->encode($query->id)
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
        $id = $this->encrypt->decode($data['id']);
        $authorities = $this->parsingAuthorities($data);

        return BaseModel::transaction(function() use ($id, $data, $authorities) {
            return GroupsModel::updateOne($id, [
                'name'        => $data['name'],
                'description' => $data['description'],
                'is_admin'    => $data['is_admin'] ? 1 : 0,
                'status'      => $data['status']  ? 1 : 0,
            ], function($query, $event, $cursor) use ($authorities) {
                $cursor->menus()->sync($authorities);
            });
        });
    }

    public function delete(array $data) {
        if (is_array($data['id'])) {
            $id = [];
            foreach ($data['id'] as $value) {
                $id[] = $this->encrypt->decode($value);
            }

            return BaseModel::transaction(function() use ($id) {
                return GroupsModel::deleteMany($id, function($query, $event, $cursor) {
                    $cursor->menus()->detach();
                });
            });    
        } else {
            $id = $this->encrypt->decode($data['id']);
            return BaseModel::transaction(function() use ($id) {
                return GroupsModel::deleteOne($id, function($query, $event, $cursor) {
                    $cursor->menus()->detach();
                });
            });
        }
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
