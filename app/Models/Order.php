<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='orders';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'number',
        'comment',
        'note',
        'delivery_status',
        'warehouse_id',
        'quotation_id',
        'uuid',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'order_date',
        'order_status',
        'status',
        'customer_id',
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
        'expected_delivery_date',
        'process_status',
        'subtotal_amount',
        'payment_status',
        'shipping_amount',
        'be_delivered',
        'delivery_with_invoice',
        'Delivery_address'
    ];

    public function customer()  {
        
        return $this->belongsTo(Customer::class, 'customer_id',  'id');
    }


    public function quotation()  {
        
        return $this->belongsTo(Quotation::class, 'quotation_id',  'id');
    }

    public function order_items()  {
        
        return $this->hasMany(OrderProduct::class, 'order_id',  'id');
    }

    public function warehouse()  {
        
        return $this->belongsTo(Warehouse::class, 'warehouse_id',  'id');
    }

    public function auteur()  {
        
        return $this->belongsTo(User::class, 'added_by',  'id');
    }
}
