<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingModel extends Model
{
    use HasFactory;

    protected $table  = 'training';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'exercise_name',
        'url_video_img',
        'sets',
        'repes',
        'rest_time',
        'day',
        'id_user',
        'id_personal_code',
        'position'
    ];

    public function personal()
    {
        return $this->hasOne(PersonalModel::class, 'id_personal_code');
    }
}
