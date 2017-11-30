<?php

class GroupsService extends BaseService {

    private $model;
    
    function __construct() {
        parent::__construct();
        $this->model = new GroupsModel();
    }

    public function create(array $data) {
        $query = $this->model->create([ 
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        if ($query) {   
            $result = [
                '_id' => $query->id,
                'messages' => [200, 'Created successfully.', '']
            ];
        } else {
            $result = [
                'messages' => [500, 'Created failed.', '']
            ];
        }

        return $result;
    }

}
