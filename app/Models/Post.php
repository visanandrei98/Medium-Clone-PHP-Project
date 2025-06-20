<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function readTime() {
        $wordCount = str_word_count($this->content);
        $minutes = ceil($wordCount / 200);

        return max(1, $minutes); // Return at least 1 minute if the word count is less than 200 $minutes;
    }

    public function imageUrl(){
        if ($this->image) {
            return Storage::url($this->image);
        }

        return null;
    }

    
}
