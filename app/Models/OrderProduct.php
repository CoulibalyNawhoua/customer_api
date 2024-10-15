<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='orders_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'order_id',
        'product_id',
        'unit_price',
        'price',
        'sub_total',
        'warehouse_id',
        'product_discount',
        'quantity_received',
        'product_tax',
        'created_at',
        'updated_at',
    ];

    public function product() {
        
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
