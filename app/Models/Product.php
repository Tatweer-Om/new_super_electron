<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function brand()
    {

        return $this->belongsTo(Brand::class) ;

        return $this->belongsTo(Brand::class);

    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }




    public function product_qty_histories()
    {
        return $this->belongsTo(Product_qty_history::class);
    }

    public function purchase_detail()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product_imei()
{
    return $this->hasMany(Product_imei::class);
}

public function categoryo()
{
    return $this->belongsTo(Category::class, 'category_id');
}


    }

