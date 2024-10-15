<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='transaction';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'reference',
        'amount',
        'payment_method',
        'note',
        'order_id',
        'purchase_id',
        'transaction_date',
        'payer',
        'sale_id',
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
