<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['student_id', 'classroom_id', 'psession', 'pstatus', 'pterm'];
    public function student() {
        return $this->belongsTo(Student::class);
    }
}
