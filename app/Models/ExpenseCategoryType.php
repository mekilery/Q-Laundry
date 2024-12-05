<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategoryType extends Model
{
    use HasFactory;

    protected $table = 'expense_category_type';

    protected $fillable = ['name', 'sub_category'];
}
