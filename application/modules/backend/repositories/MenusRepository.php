<?php

class MenusRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new MenusProcessor();
    }

    public function getInput($request) {
        $this->data = [ 
            'name'        => $request('name'),
            'description' => $request('description'),
            'url'         => $request('url'),
            'icon'        => $request('icon'),
            'parent_id'   => $request('parent_id')
        ];

    }

    public function setValidationRules() {
        switch ($this->operation_type) {
        case 'create':
            $this->rules = [ 
                [
                    'field' => 'name',
                    'label' => 'Nama',
                    'rules' => 'required'
                ], [
                    'field' => 'url',
                    'label' => 'URL',
                    'rules' => 'required'
                ]
            ];

            break;
        case 'update':
            $this->rules = [ 
                [
                    'field' => 'name',
                    'label' => 'Nama',
                    'rules' => 'required'
                ], [
                    'field' => 'url',
                    'label' => 'URL',
                    'rules' => 'required'
                ]
            ];

            break;
        default:
            $this->rules = [];
        }

    }
}
