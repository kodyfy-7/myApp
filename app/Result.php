<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['student_id', 'classroom_id', 'session', 'term', 'rstatus', 'total', 'average'];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function resultDetails() {
        return $this->hasMany(ResultDetail::class);
    }
}
