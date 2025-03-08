<?php

namespace App\Providers;

use App\Events\MensajeEnviado;
use App\Events\MessageSent;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

     /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        MensajeEnviado::class => [
            // 'App\Listeners\EnviarMensaje',
            // 'App\Listeners\EnviarNotificacion',
        ],
        MessageSent::class => [
            // 'App\Listeners\SendMessage',
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
