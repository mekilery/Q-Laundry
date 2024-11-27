<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Addon extends Model
{
    use HasFactory;
    protected $fillable = [
        'addon_name',
        'addon_price',
        'is_active',
    ];
    // Relationships
    public function orderDetails() {
        return $this->belongsToMany(OrderDetail::class, 'order_addon_details', 'addon_id', 'order_detail_id');
       
        
    }
    
}
