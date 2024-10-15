<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='sales';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'note',
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
        'customer_id',
        'warehouse_id',
        'discount_percentage',
        'discount_amount',
        'paid_amount',
        'due_amount',
        'payment_date',
        'status',
        'shipping_status',
        'payment_method',
        'shipping_amount',
        'uuid',
        'payment_status',
        'expected_delivery_date',
        'sale_date',
        'subtotal_amount',
        'total_amount',
        'number'
    ];


    public function customer()  {
        
        return $this->belongsTo(Customer::class, 'customer_id',  'id');
    }


    public function sale_items()  {
        
        return $this->hasMany(SaleProduct::class, 'sale_id',  'id');
    }
}
