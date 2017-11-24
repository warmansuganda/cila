<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_users extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('users')) {
            Capsule::schema()->create('users', function ($table) {
                $table->uuid('id');
                $table->string('ip_address', 16);
                $table->string('username', 100)->unique();
                $table->string('password', 100);
                $table->string('salt', 40);
                $table->string('email', 100);
                $table->string('activation_code', 40);
                $table->string('forgotten_password_code', 40);
                $table->dateTimeTz('forgotten_password_time');
                $table->string('remember_code', 40);
                $table->dateTimeTz('last_login');
                $table->boolean('active');
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->string('company', 100);
                $table->string('phone', 20);
                $table->timestamps();

                $table->primary('id');
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('users')) {
            Capsule::schema()->drop('users');
        }
    }

}