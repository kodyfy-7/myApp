<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tbl_sample';
    protected $fillable = ['first_name', 'last_name'];
}
