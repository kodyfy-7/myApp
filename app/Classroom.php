<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //protected $fillable = ['title', 'category', 'employee_id'];
    protected $fillable = ['title', 'category'];
    public function subjects() {
        return $this->hasMany('App\ClassroomSubject');
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function employee() {
        return $this->hasOne(Employee::class);
    }
}
