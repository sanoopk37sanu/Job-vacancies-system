<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\JobVacancyCreated;
use App\Listeners\SendJobVacancyNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        JobVacancyCreated::class => [
            SendJobVacancyNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
