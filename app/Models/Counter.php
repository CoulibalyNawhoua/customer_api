<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $table='counters';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'prefix',
        'value',
        'code',
        'created_at',
        'updated_at',
    ];
}
