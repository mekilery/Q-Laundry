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
    public function order() { 
        return $this->belongsTo(Order::class, 'order_id', 'id'); 
    } 
    public function user() { 
        return $this->belongsTo(User::class, 'created_by', 'id'); 
    }
    public function customer() { 
        return $this->belongsTo(Customer::class, 'customer_id','id'); 
    }   
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type', 'id');
    }
}