<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLogin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $fillable = ['employee_id', 'username', 'password'];

    
}