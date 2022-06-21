<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bettransaction extends Model
{
    use HasFactory;
     protected $fillable = [
        'id','user_id','pool_id','bet_id','perBetAmount','megaAmount','poolAmount','comAmount','agentAmount','created_at'
    ];

    protected $table = 'bet_transactions';
}
