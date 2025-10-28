<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    /** @use HasFactory<\Database\Factories\ArticlesFactory> */
    use HasFactory, SoftDeletes;

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'allow_comments' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $fillable = [
        'title', 'author', 'content', 'excerpt', 'status', 'reading_time',
        'category_id', 'archive_id', 'tags', 'slug', 'meta_title',
        'meta_description', 'focus_keyword', 'visibility',
        'allow_comments', 'is_featured', 'featured_image', 'published_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }


}
