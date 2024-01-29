<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'store_name',
        'store_phone',
        'store_address',
        'added_by',
        'updated_by',
        'user_id',
    ];
    public function stores()
    {
        return $this->hasMany(Store::class, 'store_id', 'store_id');
    }
}
