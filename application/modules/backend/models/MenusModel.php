<?php

class MenusModel extends BaseModel {

    protected $table = 'menus'; // Table name
    /* 
     * Defining Fillable Attributes On A Model
     */ 
    protected $fillable = [ 
        'name',
        'description'
    ];

}
