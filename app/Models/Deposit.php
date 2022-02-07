<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','amount','transaction_no','transaction_details','transaction_document','deposit_time','before_deposit_amount','current_balance','status','createdBy','responsedBy','status_change_message'
    ];
    protected $table = 'deposits';
}
