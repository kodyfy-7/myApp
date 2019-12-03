<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultDetail extends Model
{
    protected $fillable = ['result_id', 'subject_id', 'ca1', 'exam', 'total'];

    public function result() {
        return $this->belongsTo(Result::class);
    }
}
