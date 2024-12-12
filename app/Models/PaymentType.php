<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = ['name', 'is_active'];

    // In Payment.php model
    public function PaymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }
}
