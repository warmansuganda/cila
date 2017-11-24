<?php

class Auth extends BaseController {
    private $repo;

    function __construct() {
        parent::__construct([
            'modules' => 'backend/auth',
            'title' => 'Authentication',
        ]);

        $this->repo = new AuthRepository();
    }

    public function index() {
        $data = $this->getDataView();
        $data['title'] = 'Welcome';
        $this->slice->view("backend/auth/signin", $data);
    }

    public function signin() {
        $return = $this->repo->startProcess('signin', $this->input->post());
        $this->serveJSON($return);
    }
}