<?php

class Auth extends BaseController {
    private $repo;

    function __construct() {
        parent::__construct([
            'modules' => 'backend/auth',
            'title'   => 'Authentication',
        ]);

        $this->repo = new AuthRepository();
    }

    public function index() {
        $data = $this->getViewData();
        $data['title'] = 'Welcome';
        $data['error_message'] = $this->session->flashdata('error_message');
        $this->slice->view("backend/auth/signin", $data);
    }

    public function signin() {
        $input = $this->input->post();
        $input['ip_address'] = $this->input->ip_address();
        $input['user_agent'] = $this->input->user_agent();
        
        $return = $this->repo->startProcess('signin', $input);
        $config_auth = $this->getConfigAuth();
        if ($return == false) {
            $this->session->set_flashdata('error_message', 'Username and password do not match');
            redirect($config_auth['page'], 'refresh');
        } else {
            redirect($config_auth['landing_page'], 'refresh');
        }
    }

    public function signout()
    {
        $config_auth = $this->getConfigAuth();
        $this->session->sess_destroy();
        redirect($config_auth['page'], 'refresh');
    }

    public function check_session()
    {
        $this->serveJSON($this->session->userdata());
    }
}