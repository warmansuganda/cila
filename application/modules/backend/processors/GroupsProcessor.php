<?php

class GroupsProcessor extends BaseProcessor {

    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new GroupsService();
    }

    public function setProcessor(string $operation_type, array $data)
    {
        try {
            switch ($operation_type) {
                case 'create':
                    $this->output = $this->service->create($data);
                    break;
                case 'read':
                    $this->output = $this->service->read($data);
                    break;
                case 'update':
                    $this->output = $this->service->update($data);
                    break;
                case 'delete':
                    $this->output = $this->service->delete($data);
                    break;
            }

            return true;
        } catch (Exception $e) {
            $this->output = $e;
            return false;
        }
    }

}
