<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInfo extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table='user_infos';
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'user_id',
        'avatar',
        'identification_type',
        'identification_id',
        'date_birth',
        'personal_phone',
        'birth_place',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
