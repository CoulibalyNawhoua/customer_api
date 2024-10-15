<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductWarehouse extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='product_warehouse';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'quantity',
        'product_id',
        'warehouse_id',
        'price',
        'cost',
        'created_at',
        'updated_at',
        'uuid',
    ];
}
