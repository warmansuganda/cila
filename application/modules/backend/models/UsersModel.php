<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class UsersModel extends Eloquent {

    use UuidTrait;

    public $incrementing = false;
    protected $table = 'users'; // Table name
    protected $fillable = [
        'ip_address',
        'username',
        'password',
        'salt',
        'email',
        'activation_code',
        'forgotten_password_code',
        'forgotten_password_time',
        'remember_code',
        'last_login',
        'active',
        'first_name',
        'last_name',
        'company',
        'phone',
    ]; // Defining Fillable Attributes On A Model

    public function login_attempts()
    {
        return $this->hasMany('\LoginAttemptsModel', 'user_id');
    }

    public function token()
    {
        return $this->hasMany('\UsersTokensModel', 'user_id');
    }
}
