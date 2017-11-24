<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_login_attempts extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('login_attempts')) {
            Capsule::schema()->create('login_attempts', function ($table) {
                $table->uuid('id');
                $table->string('ip_address', 16);
                $table->string('token', 16);
                $table->timestamps();

                $table->primary('id');
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('login_attempts')) {
            Capsule::schema()->drop('login_attempts');
        }
    }

}