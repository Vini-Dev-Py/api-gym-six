<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'role',
        'days',
        'phone',
        'RG',
        'CPF'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function getDaysOfWeekStructure()
    {
        $daysOfWeek = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        ];

        $daysStructure = [];

        foreach ($daysOfWeek as $day) {
            $daysStructure[$day] = [];
        }

        return $daysStructure;
    }

    public function personal()
    {
        return $this->hasOne(PersonalModel::class, 'id_user');
    }

    public function personalUser()
    {
        return $this->hasOne(PersonalUsersModel::class, 'id_user');
    }
}
