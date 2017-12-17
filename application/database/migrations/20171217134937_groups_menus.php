<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_groups_menus extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('groups_menus')) {
            Capsule::schema()->create('groups_menus', function ($table) {
                $table->uuid('group_id');
                $table->uuid('menu_id');
                $table->boolean('authority_read')->nullable();
                $table->boolean('authority_create')->nullable();
                $table->boolean('authority_update')->nullable();
                $table->boolean('authority_delete')->nullable();
                $table->boolean('authority_import')->nullable();
                $table->boolean('authority_export')->nullable();
                $table->boolean('authority_approve')->nullable();
                $table->integer('authority_data')->nullable();
                $table->timestamps();

                $table->primary(['group_id', 'menu_id']);
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('groups_menus')) {
            Capsule::schema()->drop('groups_menus');
        }
    }

}