<?php

class MenusService extends BaseService {
    
    function __construct() {
        parent::__construct();
    }

    public function create(array $data) {
        return MenusModel::createOne([ 
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function read(array $data) {
        $query = MenusModel::data();
        return $this->datatables->of($query)
            ->filter(function($query) use ($data) {
                if (!empty($data['name'])) {
                    $query->where('name', 'admin');
                }
                return $query;
            })
            ->addColumn('percentage', function($query){
                return "";
            })
            ->make();
    }

    public function update(array $data) {
        return MenusModel::updateOne($data['id'], [ 
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function delete(array $data) {
        return MenusModel::deleteOne($data['id']);
    }

}
