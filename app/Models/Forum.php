<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ForumFactory;


class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'autor',
        'user_id'
        'image',
    ];

    //Relationship to User
    public function user() {
        return $this->belongsTo(User::class);
    }

    //Relationship to comment
    public function comments (){
        return $this->hasMany(Comment::class);
    }

    protected static function newFactory()
    {
        return ForumFactory::new();
    }
}
