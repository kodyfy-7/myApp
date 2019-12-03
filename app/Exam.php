<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['student_id', 'subject_id', 'classroom_id', 'escore', 'esession', 'eterm'];
}
