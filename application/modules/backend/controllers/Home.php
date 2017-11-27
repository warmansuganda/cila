<?php

class Home extends BaseController {
    private $repo;

    function __construct() {
        parent::__construct([
            'module' => 'backend/home',
            'title'   => 'Home',
        ]);
    }

    public function index() {
        $data = $this->getViewData();
        $this->slice->view($data['module'] . "/index", $data);
    }

    public function test($value='')
    {
    	echo "string: " . $value;
    }
}