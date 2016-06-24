<?php

namespace Infinety\Notifications;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Infinety\Notifications\Commands\NotificationsCommands;

class NotificationsServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfigs();
        $this->handleMigrations();
        $this->handleViews();
        $this->handleRoutes();

        $this->registerCommands();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Bind any implementations.
        $this->app->register('Yajra\Datatables\DatatablesServiceProvider');
    }

    /**
     * Publish config file.
     */
    private function handleConfigs()
    {
        $configPath = __DIR__.'/../config/notifications-config.php';

        $this->publishes([$configPath => config_path('notifications.php')], 'config');

        $this->mergeConfigFrom($configPath, 'notifications');
    }

    /**
     * Publish migration file.
     */
    private function handleMigrations()
    {
        $this->publishes([__DIR__.'/../migrations/' => database_path('migrations')], 'migrations');
    }

    /**
     * Load and publish views.
     */
    private function handleViews()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'notifications');

        $this->publishes([__DIR__.'/../views' => base_path('resources/views/vendor/infinety/notifications')], 'views');
    }

    /**
     * Load routes.
     */
    private function handleRoutes()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/../routes.php';
        }
    }

    /**
     * Register commands.
     */
    private function registerCommands()
    {
        $this->commands(NotificationsCommands::class);
    }
}
