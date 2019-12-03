<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContinousAssessment extends Model
{
    protected $fillable = ['student_id', 'subject_id', 'classroom_id', 'score', 'session', 'term'];
}
