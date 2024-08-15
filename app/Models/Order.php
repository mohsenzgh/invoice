<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'customer_company', 'customer_phone'
    ];

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }
}
