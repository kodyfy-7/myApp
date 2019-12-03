<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherLogin extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = ['employee_id', 'username', 'password'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}