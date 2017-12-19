<?php

class Groups extends BaseController {

    private $repo;

    function __construct() {
        parent::__construct([
            'title'       => 'Groups',
            'description' => 'Groups Manajemen',
        ]);

        $this->repo = new GroupsRepository();
    }

    public function getIndex() {
        $this->serveView();
    }

    public function getRead() {
      $input  = $this->input->get();
      $return = $this->repo->startProcess('read', $input);
      $this->serveJSON($return);
    }
    
    public function getAdd() {
        $this->setViewData('nestable', $this->repo->startProcess('get_nestable'));
        $this->serveView();
    }

    public function postCreate() {
      $input  = $this->input->post();
      $return = $this->repo->startProcess('create', $input);
      $this->serveJSON($return);
    }

    public function getEdit() {
        $input = $this->input->get();
        $data  = $this->repo->startProcess('get', $input);
        $this->setViewData('data', $data);
        $this->setViewData('nestable', $this->repo->startProcess('get_nestable', $data['menus']));
        $this->serveView();
    }

    public function postUpdate() {
      $input  = $this->input->post();
      $return = $this->repo->startProcess('update', $input);
      $this->serveJSON($return);
    }    

    public function postDelete() {
      $input  = $this->input->post();
      $return = $this->repo->startProcess('delete', $input);
      $this->serveJSON($return);
    }

}
