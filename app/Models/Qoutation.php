<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qoutation extends Model
{
    use HasFactory;


    public function products()
    {
        return $this->hasMany(QoutProduct::class, 'qoute_id');
    }

    public function services()
    {
        return $this->hasMany(QoutService::class, 'qoute_id');
    }

    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}
}
