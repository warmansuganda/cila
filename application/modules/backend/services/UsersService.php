<?php

class UsersService extends BaseService {
    
    function __construct() {
        parent::__construct();
    }

    public function create(array $data) {
        return UsersModel::createOne([ 
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company' => $data['company'],
            'phone' => $data['phone'],
            'email' => $data['email']
        ]);
    }

    public function read(array $data) {
        $query = UsersModel::data();
        $options = [
            'module'  => 'backend/users',
            'encrypt' => $this->encrypt
        ];

        return $this->datatables->of($query)
            ->filter(function($query) use ($data) { 
                if ($data['first_name'] != '') {
                    $query->where('first_name', $data['first_name']);
                }
                if ($data['last_name'] != '') {
                    $query->where('last_name', $data['last_name']);
                }
                if ($data['company'] != '') {
                    $query->where('company', $data['company']);
                }
                if ($data['phone'] != '') {
                    $query->where('phone', $data['phone']);
                }
                if ($data['email'] != '') {
                    $query->where('email', $data['email']);
                }
                return $query;
            }) 
            ->addColumn('checkbox', function($query) use ($options) {
                return form_checkbox('id[]', $options['encrypt']->encode($query->id), FALSE, ['class' => 'checkbox-id']);
            }) 
            ->addColumn('first_name', function($query) {
                return $query->first_name;
            })
            ->addColumn('last_name', function($query) {
                return $query->last_name;
            })
            ->addColumn('company', function($query) {
                return $query->company;
            })
            ->addColumn('phone', function($query) {
                return $query->phone;
            })
            ->addColumn('email', function($query) {
                return $query->email;
            })
            ->addColumn('action', function($query) use ($options) {
                $action[] = anchor($options['module'] . '/edit?grid_id=' . $options['encrypt']->encode($query->id), '<i class="fa fa-edit"></i> Edit', [
                    'class' => 'btn btn-warning btn-xs',
                    'rel' => 'tooltip',
                    'title' => 'Edit'
                ]);
                $action[] = anchor($options['module'] . '/delete', '<i class="fa fa-trash"></i> Delete',[
                    'class' => 'btn btn-danger btn-xs btn-delete',
                    'data-grid' => $options['encrypt']->encode($query->id)
                ]);
                return implode(' ', $action);
            })
            ->make();
    }

    public function get(array $data)
    {
        $id = $data['id'];

        if (!empty($id)) {
            $query = UsersModel::find($this->encrypt->decode($id));
            if ($query) {
                return [
                    'id' => $this->encrypt->encode($query->id), 
                    'first_name' => $query->first_name,
                    'last_name' => $query->last_name,
                    'company' => $query->company,
                    'phone' => $query->phone,
                    'email' => $query->email
                ];
            }
        }

        return NULL;
    }

    public function update(array $data) {
        return UsersModel::updateOne($this->encrypt->decode($data['id']), [ 
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company' => $data['company'],
            'phone' => $data['phone'],
            'email' => $data['email']
        ]);
    }

    public function delete(array $data) {
        if (is_array($data['id'])) {
            $id = [];
            foreach ($data['id'] as $value) {
                $id[] = $this->encrypt->decode($value);
            }

            return BaseModel::transaction(function() use ($id) {
                return UsersModel::deleteMany($id);
            });    
        } else {
            $id = $this->encrypt->decode($data['id']);
            return UsersModel::deleteOne($id);
        }
    }

}
