<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalModel extends Model
{
    use HasFactory;

    protected $table = 'personal_code';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'personal_code',
        'id_user'
    ];

    public function personal()
    {
        return $this->belongsTo(UserModel::class, 'id_personal_code');
    }
}
