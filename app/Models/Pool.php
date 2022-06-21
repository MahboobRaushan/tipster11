<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;
     protected $fillable = [
        'name','startTime','endTime','perBetAmount','basePrice','megaPercentage','poolPercentage','comPercentage','agentPercentage','group1Percentage','group2Percentage','group3Percentage','isJackpotPool','createdBy','updatedBy','group1TotalPlayer','group2TotalPlayer','group3TotalPlayer','group1TotalPrize','group2TotalPrize','group3TotalPrize','pool_status','status','currentStatus','icon_path'
    ];

    protected $table = 'pools';
}
