<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryProduct extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='delivery_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'delivery_id',
        'product_id',
        'unit_price',
        'sub_total',
        'product_discount',
        'product_tax',
        'created_at',
        'updated_at',
    ];


    public function product() {
        
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
