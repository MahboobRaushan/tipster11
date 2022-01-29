<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\League;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tims';
    public function league()
    {
        return $this->belongsTo(League::class);
    }
     protected $fillable = [
        'name', 'league_id','createdBy','updatedBy'
    ];
}
