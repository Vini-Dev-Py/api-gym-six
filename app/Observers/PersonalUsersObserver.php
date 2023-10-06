<?php

namespace App\Observers;

use App\Models\PersonalUsersModel;
use Ramsey\Uuid\Uuid;

class PersonalUsersObserver
{
    public function creating(PersonalUsersModel $model): void
    {
        $model->id = Uuid::uuid4();
    }
}
