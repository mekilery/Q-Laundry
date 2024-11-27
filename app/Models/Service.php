<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_name',
        'icon',
        'is_active'
    ];
    // Add relationship with ServiceType model
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    }
}