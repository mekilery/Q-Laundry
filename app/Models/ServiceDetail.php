<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ServiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'service_type_id',
        'service_price'
    ];

    public function class orderDetails()
    {
        return $this->belongsTo(OrderDetails::class, 'service_id, service_type_id, service_price,service_name');
        $this->belongsTo->('orderDetails, service_id, service_type_id)->onDelete('cascade');
    
    }

}