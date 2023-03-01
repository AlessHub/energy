<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //Relationship to Forum
    public function forums (){
        return $this->hasMany(Forum::class);
    }
    //Relationship to Comments
    public function comments (){
        return $this->hasMany(Comment::class);       
    }

    //Relationship to Informs
    public function informs (){
        return $this->hasMany(Informs::class);
    }

    //Relationship to 
    public function notifications (){
        return $this->hasMany(Informs::class);
    }

    //Relationship to 
    public function electricityExpenses()
    {
        return $this->belongsToMany(ConsumeExpense::class, 'consume_expense_user')
            ->using(ConsumeExpenseUser::class)
            ->withPivot(['elecExpense', 'waterExpense', 'year', 'month']);
    }

    
}
