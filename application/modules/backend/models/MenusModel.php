<?php

class MenusModel extends BaseModel {

    protected $table = 'menus'; // Table name
    /* 
     * Defining Fillable Attributes On A Model
     */ 
    protected $fillable = [ 
        'name',
        'description',
        'url',
        'icon',
        'order',
        'parent_id'
    ];

    public function groups() {
        return $this->belongsToMany('\GroupsModel', 'groups_menus', 'menu_id', 'group_id')
                        ->withTimestamps()
                        ->withPivot('authority_read', 'authority_create', 'authority_update', 'authority_delete', 'authority_import', 'authority_export', 'authority_approve', 'authority_data');
    }

}
