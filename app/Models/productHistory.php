<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class productHistory extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='products_histories';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'note',
        'quantity',
        'product_id',
        'purchase_id',
        'sale_id',
        'order_id',
        'quantity_before',
        'quantity_after',
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
