<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id','before_deposit_withdraw_amount','amount','current_balance','type','reference_by','deposit_withdraw_id','createdBy'
    ];
    protected $table = 'credits';
}
