<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseProduct extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='purchase_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'purchase_id',
        'product_id',
        'unit_price',
        'warehouse_id',
        'price',
        'sub_total',
        'product_tax',
        'product_discount',
        'quantity_received',
        'quantity_entered',
        'is_delivered',
        'created_at',
        'updated_at',
    ];


    public function product() {
        
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
