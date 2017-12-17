<?php

abstract class BaseRepository {
    protected $processor;
    protected $data;
    protected $rules;
    protected $errors;
    protected $operation_type;
    protected $ci;

    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->library('form_validation');
    }

    abstract public function getInput($request);

    abstract public function setValidationRules();
    
    public function validate(array $request) {

        $this->getInput(function($name, $default = NULL) use ($request){
            return isset($request[$name]) ? $request[$name] : $default;
        });

        $this->cleanFromXss();
        $this->setValidationRules();

        if ($this->rules) {
            $this->ci->form_validation->set_data($this->getData());
            $this->ci->form_validation->set_rules($this->rules);

            if ($this->ci->form_validation->run() == false) {
                $this->errors = $this->ci->form_validation->error_array();
                return false;
            }
        }

        return true;
    }

    public function startProcess(string $operation_type, array $request = []) {
        $this->operation_type = $operation_type;
        if (!$this->validate($request)) {
            return [
                'code' => 422,
                'status' => 'fail',
                'message' => http_response_text(422),
                'data' => $this->getErrors()
            ];
        }

        return $this->processor->run($operation_type, $this->getData());
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getData() {
        return $this->data;
    }

    public function getErrorTemplate() {
        return $this->ci->load->view('errors/validation', ['errors' => $this->errors], true);
    }

    public function cleanFromXss() {
        $this->data = $this->ci->security->xss_clean($this->data);
    }

    public function getOperationType() {
        return $this->operation_type;
    }

    public function getRules() {
        return $this->rules;
    }

}