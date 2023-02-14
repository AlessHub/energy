<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    use HasFactory;
    
    protected $fillable = [
        
        'date',
        'electricMoney',
        'electricEnergy',
        'waterMoney',
        'waterEnergy',
    ];

    //Relationship to User
    public function user() {
        return $this->belongsTo(User::class);
    }
}