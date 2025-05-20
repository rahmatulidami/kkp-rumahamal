<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'parent_id',
        'author',
        'content', 
        'is_admin'
    ];

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->child()->with('children')->with('parent');

    }

    // app/Models/Comment.php
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($comment) {
            $comment->children()->each(function ($child) {
                $child->delete();
            });
        });
    }
}