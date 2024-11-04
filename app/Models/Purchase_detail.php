<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_detail extends Model
{
    use HasFactory;


    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id'); // Ensure 'purchase_id' is the foreign key
    }
}
