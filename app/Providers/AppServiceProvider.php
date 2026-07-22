<?php

namespace App\Providers;

use App\Application\Ports\In\SendNotificationUseCase;
use App\Application\Ports\Out\NotificationSender;
use App\Application\SendNotification\SendNotificationHandler;
use App\Infrastructure\Notification\FakeNotificationSender;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            SendNotificationUseCase::class,
            SendNotificationHandler::class
        );

        $this->app->bind(
            NotificationSender::class,
            FakeNotificationSender::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
