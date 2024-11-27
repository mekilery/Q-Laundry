<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'service_id',
        'service_name',
        'service_price',
        'service_quantity',
        'service_detail_total',
        'color_code',
        'deleted_at'
    ];
    public function order() 
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }   
    public function Service()
    {
        return $this->HasMany(Service::class,'Service_id', 'id');
    }

}