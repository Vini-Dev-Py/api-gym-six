<?php

namespace App\Observers;

use App\Models\TrainingModel;
use Ramsey\Uuid\Uuid;

class TrainingObserver
{
    public function creating(TrainingModel $model): void
    {
        $model->id = Uuid::uuid4();
    }
}
