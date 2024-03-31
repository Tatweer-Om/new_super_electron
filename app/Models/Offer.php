<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;


    public function offer_brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function offer_categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function offer_products()
    {
        return $this->belongsToMany(Product::class);
    }
}
