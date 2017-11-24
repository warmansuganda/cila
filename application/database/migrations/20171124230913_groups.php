<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_groups extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('groups')) {
            Capsule::schema()->create('groups', function ($table) {
                $table->uuid('id');
                $table->string('name', 20)->unique();
                $table->string('description', 100);
                $table->timestamps();

                $table->primary('id');
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('groups')) {
            Capsule::schema()->drop('groups');
        }
    }

}