<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'tax_number', 'address', 'is_active', 'created_by'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'customer_id', 'id');
    }

    public function orderAddonDetails()
    {
        return $this->hasMany(OrderAddonDetail::class, 'customer_id', 'id');
    }
}
