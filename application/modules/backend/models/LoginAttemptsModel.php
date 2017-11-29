<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class LoginAttemptsModel extends Eloquent {

    use UuidTrait;

    public $incrementing = false;
    protected $table = 'login_attempts'; // Table name
    protected $fillable = ['user_id', 'ip_address', 'status', 'user_agent']; // Defining Fillable Attributes On A Model

}
