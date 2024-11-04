<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(Purchase_detail::class, 'purchase_id'); // Ensure 'purchase_id' is the foreign key
    }


}
