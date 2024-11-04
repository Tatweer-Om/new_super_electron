<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    use HasFactory;
    public function winners()
    {
        return $this->hasMany(DrawWinner::class, 'draw_id', 'id');
    }
}
