<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'dob', 'gender', 'classroom_id'];
    public function payment() {
        return $this->hasMany(Payment::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function studentLog() {
        return $this->hasOne(StudentLogin::class);
    }

    public function results() {
        return $this->hasMany(Result::class);
    }

    public function details(){
        return $this->hasMany(AssignmentDetail::class);
    }
}
