<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SentFormat extends Model
{

   
    public function format(){
        return $this->belongsTo(Format::class,'formatId','id');
    }

}
