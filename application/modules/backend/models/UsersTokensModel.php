<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class UsersTokensModel extends Eloquent {

    use UuidTrait;

    public $incrementing = false;
    protected $table = 'users_tokens'; // Table name
    protected $fillable = ['user_id', 'token']; // Defining Fillable Attributes On A Model

}
