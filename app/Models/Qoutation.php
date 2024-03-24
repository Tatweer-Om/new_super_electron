<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qoutation extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(QouteService::class);
    }
     public function products()
    {
        return $this->hasMany(QouteProduct::class);
    }
}
