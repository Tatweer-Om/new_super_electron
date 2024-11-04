<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QoutProduct extends Model
{
    use HasFactory;

    public function qoutation()
    {
        return $this->belongsTo(Qoutation::class, 'qoute_id');
    }
}
