<?php

namespace App\Core\Database;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['name', 'email', 'password'];
}
