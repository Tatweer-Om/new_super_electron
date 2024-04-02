<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrderDetail extends Model
{
    use HasFactory;

    public function pendingOrder()
    {
        return $this->belongsTo(PendingOrder::class, 'pend_id', 'id');
    }
}
