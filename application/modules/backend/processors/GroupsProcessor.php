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
            }

            return true;
        } catch (Exception $e) {
            $this->output = $e;
            return false;
        }
    }

}
