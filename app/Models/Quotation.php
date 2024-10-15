<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='quotations';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'number',
        'validate_date',
        'warehouse_id',
        'uuid',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'quotation_date',
        'payment_method',
        'status',
        'customer_id',
        'created_at',
        'updated_at',
        'add_date',
        'added_by',
        'note',
        'add_ip',
        'edited_by',
        'edit_date',
        'edit_ip',
        'is_deleted',
        'deleted_by',
        'delete_ip',
        'delete_date',
        'subtotal_amount',
    ];

    public function customer()  {
        
        return $this->belongsTo(Customer::class, 'customer_id',  'id');
    }

    public function quotation_items()  {
        
        return $this->hasMany(QuotationProduct::class, 'quotation_id',  'id');
    }

    public function warehouse()  {
        
        return $this->belongsTo(Warehouse::class, 'warehouse_id',  'id');
    }

    public function auteur()  {
        
        return $this->belongsTo(User::class, 'added_by',  'id');
    }
}
