<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tim;

class League extends Model
{
    use HasFactory;

    protected $table = 'leagues';
    public function tims()
    {
        return $this->hasMany(Tim::class);
    }
    protected $fillable = [
        'name','game_id','createdBy','updatedBy'
    ];
}
