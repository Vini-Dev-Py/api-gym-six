<?php

namespace App\Observers;

use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class UserObserver
{
    public function creating(UserModel $model): void
    {
        $model->id = Uuid::uuid4();
    }
}
