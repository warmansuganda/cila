<?php

class GroupsSeeder extends Seeder {

    public function run() {
        GroupsModel::truncate();

        //seed records manually
        $data = [
            'name'        => 'admin',
            'description' => 'Administrator',
            'status'      => true
        ];

        GroupsModel::create($data);
    }
}
