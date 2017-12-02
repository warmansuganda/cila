<?php

class GroupsModel extends BaseModel {

    protected $table = 'groups'; // Table name
    /* 
     * Defining Fillable Attributes On A Model
     */ 
    protected $fillable = [ 
        'name',
        'description',
        'status'
    ];

}
