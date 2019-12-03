<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassroomSubject extends Model
{
    protected $table = 'classroom_subjects';
    protected $fillable = ['classroom_id', 'subject_id'];

    public function classroom() {
        return $this->belongsTo('App\Classroom');
    }
}
