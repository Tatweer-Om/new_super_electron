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

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
