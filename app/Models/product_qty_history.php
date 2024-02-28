<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_qty_history extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
