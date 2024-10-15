<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use UuidGenerator;
    use GetModelByUuid;
    use Sluggable;

    protected $table='currency';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'slug',
        'symbol',
        'code',
        'comment',
        'uuid',
        'status',
        'statut',
        'image_url',
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name','id']
            ]
        ];
    }
}
