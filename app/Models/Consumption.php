<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'date',
        'electricMoney',
        'electricEnergy',
        'waterMoney',
        'waterEnergy',
    ];
}