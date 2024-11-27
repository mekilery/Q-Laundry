<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ServiceType extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_type_name',
        'is_active'
    ];
    public function services()
    {
        return $this->belongsTo(service::class);
        }
    }
    