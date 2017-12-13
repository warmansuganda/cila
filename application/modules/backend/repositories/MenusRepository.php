<?php

class MenusRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new MenusProcessor();
    }

    public function getInput($request) {
        $this->data = [ 
            'name'   => $request('name'),
            'description'   => $request('description')
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
                ]
            ];

            break;
        default:
            $this->rules = [];
        }

    }
}
