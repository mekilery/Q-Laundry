<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}