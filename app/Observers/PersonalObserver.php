<?php

namespace App\Observers;

use App\Models\PersonalModel;
use Ramsey\Uuid\Uuid;

class PersonalObserver
{
    public function creating(PersonalModel $model): void
    {
        $model->id = Uuid::uuid4();
    }
}
