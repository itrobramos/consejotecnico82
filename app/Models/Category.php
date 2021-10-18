<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    public function questions(){
        return $this->hasMany(Question::class,'categoryId','id');
    }

}
