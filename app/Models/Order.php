<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number', 'customer_id', 'customer_name', 'phone_number', 'order_date', 'delivery_date', 
        'sub_total', 'addon_total', 'discount', 'tax_percentage', 'tax_amount', 'total', 'note', 
        'status', 'order_type', 'created_by', 'financial_year_id', 'deleted_at', 'processed_on', 
        'delivered_on', 'returned_on'
    ];

    /* user relation */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }
}
