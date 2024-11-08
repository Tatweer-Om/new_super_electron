<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentExpense extends Model
{
    use HasFactory;

    public function posOrder() {
        return $this->belongsTo(PosOrder::class, 'order_id');
    }
}
