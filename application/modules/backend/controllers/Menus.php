<?php

class Menus extends BaseController {

    private $repo;

    function __construct() {
        parent::__construct([
            'title'       => 'Menu',
            'description' => 'Manajemen Menu',
        ]);

        $this->repo = new MenusRepository();
    }

    public function getIndex() {
        $this->serveView();
    }

    public function getRead() {
        $this->setViewData('menus', $this->repo->startProcess('read'));
        $this->serveView();
    }

    public function getAdd() {
        $this->setViewData('parent_id', $this->input->get('parent_id'));
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

    public function postUpdateOrder() {
        $input = $this->input->post();
        $return = $this->repo->startProcess('update_order', $input);
        $this->serveJSON($return);
    }

    public function postDelete() {
        $input = $this->input->post();
        $return = $this->repo->startProcess('delete', $input);
        $this->serveJSON($return);
    }

}
