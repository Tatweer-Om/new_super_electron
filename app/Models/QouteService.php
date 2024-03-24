<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QouteService extends Model
{
    use HasFactory;

    public function quotation()
    {
        return $this->belongsTo(Qoutation::class);
    }


}

