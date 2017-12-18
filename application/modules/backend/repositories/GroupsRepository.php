<?php

class GroupsRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new GroupsProcessor();
    }

    public function getInput($request) {
        $this->data = [ 
            'id'             => $request('grid_id'),
            'name'           => $request('name'),
            'is_admin'       => $request('is_admin', 0),
            'description'    => $request('description'),
            'status'         => $request('status', 0),
            'read'           => $request('read'),
            'create'         => $request('create'),
            'update'         => $request('update'),
            'delete'         => $request('delete'),
            'import'         => $request('import'),
            'export'         => $request('export'),
            'approve'        => $request('approve'),
            'authority_data' => $request('authority_data'),
        ];
    }

    public function setValidationRules() {
        switch ($this->operation_type) {
        case 'create':
            $this->rules = [ 
                [
                    'field' => 'name',
                    'label' => 'name',
                    'rules' => 'required'
                ]
            ];

            break;
        default:
            $this->rules = [];
        }

    }
}
