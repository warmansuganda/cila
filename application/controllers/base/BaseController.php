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

    protected function getConfigAuth() {
        return config_item('auth');
    }

    protected function getURI() {
        return $this->uri->uri_string();
    }

    protected function getMethod() {
        return $this->router->fetch_method();
    }

    protected function getModule() {
        $module = $this->router->fetch_module();
        $class = $this->router->fetch_class();

        $result = [];
        if (!empty($module)) {
            $result[] = $module;
        }
        if (!empty($class)) {
            $controller_suffix = $this->config->item('controller_suffix');
            
            $controller = rtrim($class, $controller_suffix);
            $matches = preg_split('/(?=[A-Z])/', $controller);
            $result[] = ltrim(strtolower(implode('_', $matches)), '_');
        }
        return implode('/', $result);
    }

    protected function setViewData($key, $value)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->view_data[$k] = $v;
            }
        } else {
            $this->view_data[$key] = $value;
        }
    }

    protected function getViewData() {
        $data = $this->view_data;
        if (!isset($data['module'])) {
            $data['module'] = $this->getModule();
        }
        if (!isset($data['title'])) {
            $data['title'] = "Untitled";
        }
        if (!isset($data['description'])) {
            $data['description'] = "";
        }
        return $data;
    }

    protected function serveJSON($data, $code = 200, $status = 'success', $message = 'OK') {
        $output = $data;

        if (is_array($data)) {
            $code = isset($data['code']) ? $data['code'] : $code;          

            $output = [
                'code'    => $code,
                'status'  => isset($data['status']) ? $data['status'] : $status,
                'message' => isset($data['message']) ? $data['message'] : $message,
                'data' => isset($data['data']) ? $data['data'] : NULL,
            ];

            // extend data table responses
            if (isset($data['draw'])) {
                $output['draw'] = $data['draw'];
            }
            if (isset($data['recordsTotal'])) {
                $output['recordsTotal'] = $data['recordsTotal'];
            }
            if (isset($data['recordsFiltered'])) {
                $output['recordsFiltered'] = $data['recordsFiltered'];
            }
        }

        http_response_code($code);
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($output);
    }

    protected function serveView($data = [], $path = '') {
        if (empty($path)) {
            $path = isset($data['module']) ? $data['module'] : $this->getModule();
            $path .= '/' . $this->getMethod();
        }
        $this->slice->view($path, count($data) > 0 ? $data : $this->getViewData());
    }

    public function _remap($method, $params = array()) {
        $request_method = $this->input->method(FALSE);
        $camelcase = ucwords($method, "-");
        $cleanDash = str_replace('-', '', $camelcase);
        // dump($cleanDash);
        $method = $request_method . '' . $cleanDash;

        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }

}
