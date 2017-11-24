<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class GroupsModel extends Eloquent {

    use UuidTrait;

    public $incrementing = false;
    protected $table = 'groups'; // Table name
    protected $fillable = ['name','description']; // Defining Fillable Attributes On A Model

}
