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
        $options = [
            'module'     => 'backend/groups',
            'encryption' => $this->encryption
        ];

        return $this->datatables->of($query)
            ->filter(function($query) use ($data) {
                if (!empty($data['name'])) {
                    $query->where('name', 'admin');
                }
                return $query;
            })
            ->addColumn('checkbox', function($query) use ($options) {
                $html = '<div class="checkbox-custom checkbox-default">';
                $html .= form_checkbox('id[]', $options['encryption']->encode($query->id), FALSE, ['class' => 'checkbox-id']);
                $html .= '<label></label>';

                return $html;
            })
            ->addColumn('status', function($query) {
                return $query->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Unactive</span>';
            })
            ->addColumn('action', function($query) use ($options) {
                $action[] = anchor($options['module'] . '/edit/' . $options['encryption']->encode($query->id), '<i class="fa fa-edit"></i> Edit', [
                    'class' => 'btn btn-warning btn-xs'
                ]);
                $action[] = anchor($options['module'] . '/delete/' . $options['encryption']->encode($query->id), '<i class="fa fa-trash"></i> Delete', [
                    'class' => 'btn btn-danger btn-xs'
                ]);
                return implode(' ', $action);
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
