<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleProduct extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='sales_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'sale_id',
        'product_id',
        'unit_price',
        'price',
        'sub_total',
        'warehouse_id',
        'product_discount_amount',
        'created_at',
        'updated_at',
        'add_date',
        'added_by',
        'add_ip',
        'edited_by',
        'edit_date',
        'edit_ip',
        'is_deleted',
        'deleted_by',
        'delete_ip',
        'delete_date',
    ];

    public function product() {
        
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
