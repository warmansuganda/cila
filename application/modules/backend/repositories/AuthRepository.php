<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->processor = new AuthProcessor();
    }

    public function getInput($request) {
        $this->data = [
            'username'   => $request('username'),
            'password'   => $request('password'),
            'ip_address' => $request('ip_address'),
            'user_agent' => $request('user_agent'),
            'remember'   => $request('remember')
        ];

    }

    public function setValidationRules() {
        switch ($this->operation_type) {
        case 'signin':
            $this->rules = [
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required'
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required'
                ],
            ];

            break;
        case 'signout':
            $this->rules = [];
        }

    }

}