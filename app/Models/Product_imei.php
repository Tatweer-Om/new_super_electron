<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_imei extends Model
{
    use HasFactory;

    public function product()
{
    return $this->belongsTo(Product::class);
}
}
