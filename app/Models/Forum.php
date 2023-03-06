<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'autor',
        'image',

    ];

    //Relationship to User
    public function user() {
        return $this->belongsTo(User::class);
    }

    //Relationship to comment
    public function commemts (){
        return $this->hasMany(Comment::class);
    }
}
