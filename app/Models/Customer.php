<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='customers';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'first_name',
        'last_name',
        'address',
        'phone',
        'full_name',
        'uuid',
        'address',
        'warehouse_id',
        'email',
        'created_at',
        'code',
        'commentaire',
        'avatar',
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
