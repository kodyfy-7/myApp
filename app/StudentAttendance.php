<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $table = 'student_attendance';
    protected $fillable = ['student_id', 'classroom_id', 'astatus', 'asession', 'aterm', 'attendance_date'];
}
