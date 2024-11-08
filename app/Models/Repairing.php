<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repairing extends Model
{
    use HasFactory;

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }
}
