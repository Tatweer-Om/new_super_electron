<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand_name',
        'brand_image',


    ];
    public function brands()
    {
        return $this->hasMany(Brand::class, 'brand_id', 'brand_id');
    }
}
