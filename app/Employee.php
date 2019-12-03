<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'designation'];

    public function teacherLogin() {
        return $this->hasOne(TeacherLogin::class);
    }

    public function subjects() {
        return $this->hasMany(Subject::class);
    }

    public function subject() {
        return $this->hasOne('App\Subject');
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

}
