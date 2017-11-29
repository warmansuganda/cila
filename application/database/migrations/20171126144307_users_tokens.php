<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_users_tokens extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('users_tokens')) {
            Capsule::schema()->create('users_tokens', function ($table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id');
                $table->text('token');
                $table->timestamps();
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('users_tokens')) {
            Capsule::schema()->drop('users_tokens');
        }
    }

}