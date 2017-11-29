<?php

class AuthService extends BaseService {
    private $model;
    
    function __construct() {
        parent::__construct();
        $this->model = new UsersModel();
    }

    public function signin(array $data) {
        $user = $this->model->where([
            'username' => $data['username'],
        ])->first();

        if ($user) {
            $password_hash = $user->password;

            $login_status = false;
            if (password_verify($data['password'], $password_hash)) {
                $token = $this->ci->token->encode([
                    "iss" => $user->id,
                ]);

                $newdata = array(
					'token'     => $token,
					'logged_in' => TRUE,
                );

                // set session
                $this->ci->session->set_userdata($newdata);
                // update last login information
                $user->update([
                	'last_login' => $this->carbon->now()
                ]);

                $user->token()->create(['token' => $token]);

                $login_status = true;
            }

            // login attempts record
            $user->login_attempts()->create([
				'ip_address' => $data['ip_address'],
				'user_agent' => $data['user_agent'],
				'status'     => $login_status,
            ]);

            if ($login_status) {
            	return $token;
            }
        }

        return false;
    }

    public function signout(array $data)
    {
    	
    }
}