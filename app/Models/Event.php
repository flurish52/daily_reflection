<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{



    protected $fillable = [
        'title',
        'post_id',
        'description',
        'image',
        'location',
        'happening_date',
        'status',
    ];

    public function post()
    {
        return $this->belongsTo(Articles::class);
    }

}
