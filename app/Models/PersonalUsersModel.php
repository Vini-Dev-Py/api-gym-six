<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalUsersModel extends Model
{
    use HasFactory;

    protected $table = 'personal_user';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'id_user',
        'id_personal_code'
    ];

    public function user()
    {
        return $this->hasOne(UserModel::class, "id", "id_user");
    }
}
