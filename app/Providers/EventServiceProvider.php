<?php

namespace App\Providers;

use App\Models\PersonalModel;
use App\Models\PersonalUsersModel;
use App\Models\TrainingModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\UserModel;
use App\Observers\PersonalObserver;
use App\Observers\PersonalUsersObserver;
use App\Observers\TrainingObserver;
use App\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        UserModel::observe(UserObserver::class);
        TrainingModel::observe(TrainingObserver::class);
        PersonalModel::observe(PersonalObserver::class);
        PersonalUsersModel::observe(PersonalUsersObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
