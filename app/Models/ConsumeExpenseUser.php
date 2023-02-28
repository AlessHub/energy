<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumeExpenseUser extends Model
{
    use HasFactory;

    protected $table = 'consume_expense_user';
    
    protected $fillable = ['user_id', 'consume_expense_id','elecExpense', 'waterExpense', 'year', 'month'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function consumeExpense()
    {
        return $this->belongsTo(ConsumeExpense::class);
    }
}
