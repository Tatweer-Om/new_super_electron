<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    use HasFactory;

    public function pendingOrderDetail()
    {
        return $this->hasOne(PendingOrderDetail::class, 'pend_id', 'id');
    }
}
