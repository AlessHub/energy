<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'autor',
    ];

    protected $attributes = [
        'user_id' => null,
    ];

    //Relationship to User
    public function user() {
        return $this->belongsTo(User::class);
    }
    //Relationship to Forum
    public function forum() {
        return $this->belongsTo(Forum::class);
    }
}
