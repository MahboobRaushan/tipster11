<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betdetails extends Model
{
    use HasFactory;
     protected $fillable = [
        'id','user_id','pool_id','match_id','bet_id','match_result','player_result','result','created_at','home_percentage','draw_percentage','away_percentage'

    protected $table = 'bet_details';
}
