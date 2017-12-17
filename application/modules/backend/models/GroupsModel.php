<?php

class GroupsModel extends BaseModel {

    protected $table = 'groups'; // Table name
    /* 
     * Defining Fillable Attributes On A Model
     */ 
    protected $fillable = [ 
        'name',
        'is_admin',
        'description',
        'status'
    ];

    public function menus() {
        return $this->belongsToMany('\MenusModel', 'groups_menus', 'group_id', 'menu_id')
                        ->withTimestamps()
                        ->withPivot('authority_read', 'authority_create', 'authority_update', 'authority_delete', 'authority_import', 'authority_export', 'authority_approve', 'authority_data');
    }

}
