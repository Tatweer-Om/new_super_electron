<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_Category extends Model
{
    use HasFactory;
    protected $table = 'expense_categories';

    public function expense_category()
    {
        return $this->hasMany(expense_category::class);
    }
}
