<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawWinner extends Model
{
    use HasFactory;
    public function draw()
    {
        return $this->belongsTo(Draw::class, 'draw_id', 'id');
    }
}
