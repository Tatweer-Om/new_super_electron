<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(Expense_Category::class, 'category_id');
    }

    public function payment()
    {
        return $this->belongsTo(Account::class, 'payment_method');
    }
}
