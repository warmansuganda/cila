<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_users_groups extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('users_groups')) {
            Capsule::schema()->create('users_groups', function ($table) {
                $table->uuid('id');
                $table->uuid('user_id');
                $table->uuid('group_id');
                $table->timestamps();

                $table->primary('id');
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('users_groups')) {
            Capsule::schema()->drop('users_groups');
        }
    }

}