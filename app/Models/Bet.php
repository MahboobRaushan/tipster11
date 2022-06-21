<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;
     protected $fillable = [
        'id','user_id','pool_id','bet_amount','total_match','total_win','created_at','isGroup1','isGroup2','isGroup3','losswinType','losswinValue'
    ];

    protected $table = 'bets';
}
