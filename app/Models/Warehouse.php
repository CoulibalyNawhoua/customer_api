<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='warehouses';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'user_id',
        'warehouse_logo',
        'warehouse_name',
        'warehouse_address',
        'warehouse_raison_sociale',
        'warehouse_email',
        'warehouse_postal_code',
        'warehouse_rccm',
        'warehouse_ncc',
        'num_Identification_fiscale',
        'warehouse_phone',
        'warehouse_zone_id',
        'activity_id',
        'created_at',
        'updated_at',
    ];


    public function assigned_user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function warehouse_zone() {

        return $this->belongsTo(Zone::class, 'warehouse_zone_id', 'id');
    }

    public function warehouse_activity() {
        
        return $this->belongsTo(ActivityArea::class, 'activity_id', 'id');
    }
}
