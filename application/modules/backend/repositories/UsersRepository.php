<?php

class UsersRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new UsersProcessor();
    }

    public function getInput($request) {
        $this->data = [ 
            'id' => $request('grid_id'),
            'first_name'   => $request('first_name'),
            'last_name'   => $request('last_name'),
            'company'   => $request('company'),
            'phone'   => $request('phone'),
            'email'   => $request('email')
        ];

    }

    public function setValidationRules() {
        switch ($this->operation_type) {
        case 'create':
            $this->rules = [ 
                [
                    'field' => 'first_name',
                    'label' => 'first_name',
                    'rules' => 'required'
                ],
                [
                    'field' => 'last_name',
                    'label' => 'last_name',
                    'rules' => 'required'
                ],
                [
                    'field' => 'company',
                    'label' => 'company',
                    'rules' => 'required'
                ],
                [
                    'field' => 'phone',
                    'label' => 'phone',
                    'rules' => 'required'
                ],
                [
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'required'
                ]
            ];

            break;
        default:
            $this->rules = [];
        }

    }
}
