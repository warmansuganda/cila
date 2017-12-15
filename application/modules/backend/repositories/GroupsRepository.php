<?php

class GroupsRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new GroupsProcessor();
    }

    public function getInput($request) {
        $this->data = [ 
            'id'          => $request('id'),
            'name'        => $request('name'),
            'description' => $request('description'),
            'status'      => $request('status')
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
                ],
                [
                    'field' => 'description',
                    'label' => 'description',
                    'rules' => 'required'
                ],
                [
                    'field' => 'status',
                    'label' => 'status',
                    'rules' => 'required'
                ]
            ];

            break;
        default:
            $this->rules = [];
        }

    }
}
