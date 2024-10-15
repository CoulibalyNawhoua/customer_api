<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='deliveries';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'note',
        'order_id',
        'total_amount',
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
        'tax_percentage',
        'tax_amount',
        'delivery_date',
        'warehouse_id',
        'shipping_amount',
        'discount_amount',
        'paid_amount',
        'due_amount',
        'payment_date',
        'status',
        'shipping_status',
        'payment_method',
        'shipping_amount',
        'uuid',
        'subtotal_amount',
        'expected_delivery_date',
        'delivery_person_id'
    ];


    public function deliveries_items()  {
        
        return $this->hasMany(DeliveryProduct::class, 'delivery_id',  'id');
    }

    public function order()  {
        
        return $this->belongsTo(Order::class, 'order_id',  'id');
    }

    public function warehouse()  {
        
        return $this->belongsTo(Warehouse::class, 'warehouse_id',  'id');
    }

}
