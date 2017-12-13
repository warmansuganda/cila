<?php

class Menus extends BaseController {

    private $repo;

    function __construct() {
        parent::__construct([
            'title'   => 'Menus',
            'description'   => 'Menus Management',
        ]);

        $this->repo = new MenusRepository();
    }

    public function getIndex() {
        $this->serveView();
    }

    public function getRead() {
        $this->serveView();
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
        $this->serveView();
    }

    public function postUpdate() {
      $input = $this->input->post();
      $return = $this->repo->startProcess('update', $input);
      $this->serveJSON($return);
    }    

    public function postDelete() {
      $input = $this->input->get();
      $return = $this->repo->startProcess('delete', $input);
      $this->serveJSON($return);
    }

}
