<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends MX_Controller {

    private $view_data = [];

    public function __construct(array $view_data = []) {
        parent::__construct();
        $this->view_data = $view_data;

        $this->config->load('auth');
        $this->middleware();
    }

    private function middleware() {
        $config_auth = $this->getConfigAuth();
        $whitelist = $config_auth['whitelist'];

        $current_uri = $this->getURI();
        $logged_in = $this->session->userdata('logged_in');

        if (!$logged_in) {
            if (!in_array($current_uri, $whitelist)) {
            	$this->session->set_flashdata('error_message', 'Sign in to start your session');
                $this->session->set_userdata('next_uri', $current_uri);
                redirect($config_auth['page'], 'refresh');
            }
        } else {
            if ($current_uri == $config_auth['page']) {
                redirect($config_auth['landing_page'], 'refresh');
            }
        }
    }

    protected function getConfigAuth()
    {
    	return config_item('auth');
    }

    protected function getURI() {
        return $this->uri->uri_string();
    }

    protected function getMethod() {
        return $this->router->fetch_method();
    }

    protected function getModule()
    {
        $module = $this->router->fetch_module();
        $class = $this->router->fetch_class();

        $result = [];
        if (!empty($module)) {
            $result[] = $module;
        }
        if (!empty($class)) {
            $result[] = $class;
        }
        return implode('/', $result);
    }

    protected function getViewData() {
        $data = $this->view_data;
        if (!isset($data['module'])) {
            $data['module'] = $this->getModule();
        } 
        return $data;
    }

    protected function serveJSON($data) {
        echo json_encode($data);
    }

}
