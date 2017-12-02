<?php

class GroupsService extends BaseService {

    function __construct() {
        parent::__construct();
    }

    public function create(array $data) {
        return GroupsModel::createOne([
            'name'        => $data['name'],
            'description' => $data['description'],
            'status'      => $data['status'],
        ]);
    }

    public function read(array $data) {
        $query = GroupsModel::data();
        return $this->datatables->of($query)
            ->filter(function($query){
                $query->where('name', 'admin');
                return $query;
            })
            ->addColumn('percentage', function($query){
                return "";
            })
            ->make();
    }

    public function update(array $data) {
        return GroupsModel::updateOne($data['id'], [
            'name'        => $data['name'],
            'description' => $data['description'],
            'status'      => $data['status'],
        ]);
    }

    public function delete(array $data) {
        return GroupsModel::deleteOne($data['id']);
    }

}
