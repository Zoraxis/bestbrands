<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function gallery(){
        return $this->hasOne(Gallery::class);
    }
}
