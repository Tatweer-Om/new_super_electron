<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferAmount extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_no',
        'acc_from',
        'acc_to',
        'transaction_date',
        'amount',
        'notes',
    ];

     
}
