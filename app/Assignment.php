<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['classroom_id', 'employee_id', 'topic', 'description', 'session', 'term', 'afile', 'subject_id'];

    public function details() {
        return $this->hasMany(AssignmentDetail::class);
    }
}
