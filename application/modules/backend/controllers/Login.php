<?php
class Login extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	$this->slice->view("backend/login/index");
    }
}