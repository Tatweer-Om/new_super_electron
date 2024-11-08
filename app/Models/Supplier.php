<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [

        'supplier_name',
        'supplier_phone',
        'supplier_email',
        'supplier_image',
        'supplier_detail',

    ];

    public function purchase_detail()
    {

        return $this->hasMany(Purchase_detail::class, 'supplier_id');

        return $this->hasMany(Supplier::class);

    }
}
