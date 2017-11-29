<?php

class  extends Seeder {

    public function run() {
        $this->db->truncate($this->table);

        //seed records manually
        $data = [
            'name' => 'admin',
            'password' => '9871'
        ];
        UserModel::create($data);

        //seed many records using faker
        $limit = 33;
        echo "seeding $limit user accounts";

        for ($i = 0; $i < $limit; $i++) {
            echo ".";

            $data = array(
                'name' => $this->faker->unique()->userName,
                'password' => '1234',
            );

            UserModel::create($data);
        }

        echo PHP_EOL;
    }
}
