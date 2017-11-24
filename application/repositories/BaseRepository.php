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

    abstract public function getInput(array $request);

    abstract public function setValidationData();

    abstract public function setValidationRules();
    
    public function validate(array $request) {
        $this->getInput($request);
        $this->setValidationData();
        $this->clean_from_xss();
        $this->setValidationRules();

        if ($this->rules) {
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
            return $this->getErrors();
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

    public function clean_from_xss() {
        $this->data = $this->ci->security->xss_clean($this->data);
    }

    public function getOperationType() {
        return $this->operation_type;
    }

    public function getRules() {
        return $this->rules;
    }

}