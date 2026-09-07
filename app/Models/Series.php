<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable=['title','author','genre','cover_image_url'];

    public function volumes(){
        return $this->hasMany(Volume::class);
    }
}
