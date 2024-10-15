<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReceptionProduct extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='receptions_products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'reception_id',
        'product_id',
        'unit_price',
        'sub_total',
        'warehouse_id',
        'created_at',
        'updated_at',
        'unit_id'
    ];

    public function product() {
        
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
