<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentDetail extends Model
{
    protected $fillable = ['student_id', 'assignment_id', 'ascore', 'adfile', 'student_status'];
    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }
    public function students(){
        return $this->belongsTo(Student::class);
    }
}
