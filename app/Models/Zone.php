<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use Sluggable;


    protected $table='zones';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'amount',
        'status',
        'comment',
        'slug',
        'note',
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
        'created_at',
        'updated_at',
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
