<?php

class LoginAttemptsModel extends BaseModel {

    protected $table = 'login_attempts'; // Table name
    protected $fillable = ['user_id', 'ip_address', 'status', 'user_agent']; // Defining Fillable Attributes On A Model

}
