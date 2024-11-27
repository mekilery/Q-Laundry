<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'tax_number',
        'address',
        'is_active',
        'created_by'
    ];
    
    public function Orders()
    {
        
            return $this->hasMany(Order::class, 'order_id', 'id');
        }
    public function user()
        {
            return $this->belongsTo(User::class, 'foreign_key', 'other_key');
        }
    
    public function Payments()
    {
        return $this->hasMany(Payments::class, 'customer_id', 'id');
    }
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'customer_id', 'id');
        
    }
    public function OrderAddonDetails()
    {
        return $this->hasMany(OrderAddonDetail::class, 'customer_id', 'id');
        
    }
    public function ServiceDetail()
    {
        return $this->hasMany(ServiceDetail::class, 'customer_id', 'id');
        
    }

}