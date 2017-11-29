<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_login_attempts extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('login_attempts')) {
            Capsule::schema()->create('login_attempts', function ($table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id');
                $table->string('ip_address', 16);
                $table->boolean('status');
                $table->string('user_agent');
                $table->timestamps();
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('login_attempts')) {
            Capsule::schema()->drop('login_attempts');
        }
    }

}