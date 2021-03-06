<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'homeTeam','awayTeam','startTime','endTime','league','result','createdBy','updatedBy','home_percentage','draw_percentage','away_percentage'
    ];

    protected $table = 'match';
}
