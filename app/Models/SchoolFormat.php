<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolFormat extends Model
{
    protected $table = 'schools_formats';

    public function format(){
        return $this->belongsTo(Format::class,'formatId','id');
    }

    public function school(){
        return $this->belongsTo(School::class,'schoolId','id');
    }

}
