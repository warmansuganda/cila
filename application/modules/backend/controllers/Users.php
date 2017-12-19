<?php

class Users extends BaseController {

    private $repo;

    function __construct() {
        parent::__construct([
            'title'   => 'Users',
            'description'   => 'Users Manajemen',
        ]);

        $this->repo = new UsersRepository();
    }

    public function getIndex() {
        $this->serveView();
    }

    public function getRead() {
      $input = $this->input->get();
      $return = $this->repo->startProcess('read', $input);
      $this->serveJSON($return);
    }
    
    public function getAdd() {
        $this->serveView();
    }

    public function postCreate() {
      $input = $this->input->post();
      $return = $this->repo->startProcess('create', $input);
      $this->serveJSON($return);
    }

    public function getEdit() {
        $input = $this->input->get();
        $this->setViewData('data', $this->repo->startProcess('get', $input));
        $this->serveView();
    }

    public function postUpdate() {
      $input = $this->input->post();
      $return = $this->repo->startProcess('update', $input);
      $this->serveJSON($return);
    }    

    public function postDelete() {
      $input = $this->input->post();
      $return = $this->repo->startProcess('delete', $input);
      $this->serveJSON($return);
    }

}
