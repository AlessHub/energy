<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumeExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'elecExpense',
        'waterExpense',
        
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'consume_expense_user')
            ->using(ConsumeExpenseUser::class)
            ->withPivot(['elecExpense', 'waterExpense', 'year', 'month']);
    }



}
