<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='purchases';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'note',
        'number',
        'total_amount',
        'due_date',
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
        'supplier_id',
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
        'payment_status',
        'delivery_status',
        'uuid',
        'purchase_date',
        'subtotal_amount',
        'expected_delivery_date'
    ];

    public function supplier()  {
        
        return $this->belongsTo(Supplier::class, 'supplier_id',  'id');
    }


    public function purchase_items()  {
        
        return $this->hasMany(PurchaseProduct::class, 'purchase_id',  'id');
    }

    public function warehouse()  {
        
        return $this->belongsTo(Warehouse::class, 'warehouse_id',  'id');
    }

    public function auteur()  {
        
        return $this->belongsTo(User::class, 'added_by',  'id');
    }
}
