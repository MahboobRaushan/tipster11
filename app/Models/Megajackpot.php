<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Megajackpot extends Model
{
    use HasFactory;
     protected $fillable = [
        'id','name','basePrize','accumulatedPrize','startTime','endTime','status','created_at','updated_at'
    ];

    protected $table = 'mega_jackpot';
}
