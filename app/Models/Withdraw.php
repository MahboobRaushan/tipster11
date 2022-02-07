<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id','amount','withdraw_time','before_withdraw_amount','current_balance','bank_account_name','bank_country','bank_name','bank_account_number','bank_account_type','status','createdBy','responsedBy','status_change_message'
    ];
    protected $table = 'withdraws';
}
