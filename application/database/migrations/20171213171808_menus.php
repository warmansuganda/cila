<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_menus extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('menus')) {
            Capsule::schema()->create('menus', function ($table) {
                $table->uuid('id')->primary();
                $table->uuid('parent_id')->nullable();
                $table->string('name', 50)->unique();
                $table->string('description')->nullable();
                $table->string('url', 100)->nullable();
                $table->string('icon', 50)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('menus')) {
            Capsule::schema()->drop('menus');
        }
    }

}