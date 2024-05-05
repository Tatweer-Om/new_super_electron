<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name',
        'account_branch',
        'account_no',
        'opening_balance',
        'commission',
        'account_type',
        'notes',
    ];

    public function expense_payment()
    {
        return $this->hasMany(Expense::class, 'payment_method');
    }
}
