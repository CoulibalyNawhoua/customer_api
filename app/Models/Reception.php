<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reception extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='receptions';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'warehouse_id',
        'order_id',
        'uuid',
        'total_amount',
        'status',
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
}
