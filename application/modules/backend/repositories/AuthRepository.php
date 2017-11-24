<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new AuthProcessor();
    }

    public function getInput(array $request) {
        $this->username = $request['username'];
        $this->password = $request['password'];
    }

    public function setValidationData() {
        $this->data = [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    public function setValidationRules() {
        switch ($this->operation_type) {
        case 'signin':
            $this->rules = [
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => [
                        'required',
                        'valid_email'
                    ]
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required',
                ],
            ];

            break;
        case 'signout':
            $this->rules = [];
        }

    }

}