<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Megajackpotdetails extends Model
{
    use HasFactory;
     protected $fillable = [
        'id','mega_jackpot_id','pool_id','accumulatedPrize','created_at'

    protected $table = 'mega_jackpot_details';
}
