<?php

namespace App\Models;

use App\Core\Traits\UuidGenerator;
use App\Core\Traits\GetModelByUuid;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SpatieLogsActivity;
    use Sluggable;
    use UuidGenerator;
    use GetModelByUuid;

    protected $table='products';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'designation',
        'brand_id',
        'subcategory_id',
        'category_id',
        'sku',
        'tax_type',
        'unit_id',
        'warehouse_id',
        'barcode',
        'cost',
        'price',
        'stock_alert',
        'order_tax',
        'uuid',
        'note',
        'slug',
        'quantity',
        'status',
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
        'supplier_id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['designation','id']
            ]
        ];
    }

    public function auteur() {

        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function brand() {

        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function unit() {

        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function category() {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory() {

        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function getImageAttribute()
    {
        return Storage::url("products/". $this->image);
    }

    // public function getImageAttribute() {
    //     return asset('storage/'.$this->image_url);
    // }

    protected $casts = [
        'add_date' => 'date',
        'edit_date' => 'date',
    ];
}
