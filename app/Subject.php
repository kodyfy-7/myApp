<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subject_title', 'level', 'employee_id'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
