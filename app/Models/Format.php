<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{


    use SoftDeletes;
    // public function type(){
    //     return $this->belongsTo(ProductType::class,'productTypeId','id');
    // }
   
    public function categories(){
        return $this->hasMany(Category::class,'formatId','id');
    }

}
