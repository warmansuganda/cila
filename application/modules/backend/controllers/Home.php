<?php

class Home extends BaseController {
    private $repo;

    function __construct() {
        parent::__construct([
            'title'       => 'Home',
            'description' => 'Controll panel'
        ]);
    }

    public function getIndex() {
        $this->serveView();
    }

    public function test($value='')
    {
    	echo "string: " . $value;
    }
}