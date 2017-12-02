<?php

class UsersSeeder extends Seeder {

    public function run() {
        UsersModel::truncate();

        //seed records manually
        $data = [
            'ip_address'              => '127.0.0.1',
            'username'                => 'administrator',
            'password'                => password_hash("administrator", PASSWORD_DEFAULT),
            'salt'                    => '',
            'email'                   => 'admin@admin.com',
            'activation_code'         => '',
            'forgotten_password_code' => NULL,
            'active'                  => '1',
            'first_name'              => 'Admin',
            'last_name'               => 'istrator',
            'company'                 => 'ADMIN',
            'phone'                   => '0',
        ];

        UsersModel::create($data);
    }
}
