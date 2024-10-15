<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use Sluggable;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='subcategory';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'category_id',
        'image_url',
        'slug',
        'uuid',
        'warehouse_id',
        'comment',
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

    public function auteur() {

        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function category() {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
