<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_date',
        'customer_id',
        'customer_name',
        'order_id',
        'received_amount',
        'payment_type',
        'payment_note',
        'financial_year_id',
        'created_by'
    ];
}