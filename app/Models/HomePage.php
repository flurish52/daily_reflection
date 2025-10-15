<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $table = 'homes';


    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'content',
        'image',
        'background_type',
        'background_value',
        'layout_type',
        'button_text',
        'button_link',
        'order',
        'is_active'
    ];

}
