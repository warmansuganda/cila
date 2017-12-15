<?php

class UsersTokensModel extends BaseModel {

    protected $table = 'users_tokens'; // Table name
    protected $fillable = ['user_id', 'token']; // Defining Fillable Attributes On A Model

}
