<?php

class GroupsSeeder extends Seeder {

    public function run() {
        GroupsModel::truncate();

        //seed records manually
        $data = [
            'id'          => '9bfac102-d136-11e7-8941-cec278b6b50a',
            'name'        => 'admin',
            'description' => 'Administrato',
        ];

        GroupsModel::create($data);

        echo PHP_EOL;
    }
}
