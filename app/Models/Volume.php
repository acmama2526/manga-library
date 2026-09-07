<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected $fillable=[
        'user_id',
        'series_id',
        'platform_id',
        'volume_number',
        'purchase_date',
        'is_read',
        'read_url',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function series(){
        return $this->belongsTo(Series::class);
    }

    public function platform(){
        return $this->belongsTo(Platform::class);
    }
}
