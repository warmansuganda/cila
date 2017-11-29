<?php

class UsersSeeder extends Seeder {

    public function run() {
        UsersModel::truncate();

        //seed records manually
        $data = [
            'id'                      => '9bfac760-d136-11e7-8941-cec278b6b50a',
            'ip_address'              => '127.0.0.1',
            'username'                => 'administrator',
            'password'                => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
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
