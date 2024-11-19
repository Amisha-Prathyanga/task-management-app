<?php

namespace App\Providers;

use App\Events\TaskCompletedEvent;
use App\Listeners\SendTaskCompletionEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TaskCompletedEvent::class => [
            SendTaskCompletionEmail::class,
        ],
    ];
}