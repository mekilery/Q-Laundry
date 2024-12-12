<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['order_number', 'customer_id', 'customer_name', 'phone_number', 'order_date', 'delivery_date', 'sub_total', 'addon_total', 'discount', 'tax_percentage', 'tax_amount', 'total', 'note', 'status', 'order_type', 'created_by', 'financial_year_id', 'deleted_at'];

    /* user relation */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'addon_total', 'id');
    }
}
