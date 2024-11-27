<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HasMany;
use Illuminate\Database\Eloquent\Model;
class OrderAddonDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'order_detail_id',
        'addon_id',
        'addon_name',
        'addon_price',
        'is_active'   
    ];

public function Order() {
    return $this->belongsTo(Order::class , 'order_id', 'id');
}

public function OrderDetails() {
    return $this->belongsTo(OrderDetails::class , 'order_detail_id', 'id');
}


public function Addons(){  
    return $this->hasMany(Addon::class, 'id', 'addon_id');

}
}