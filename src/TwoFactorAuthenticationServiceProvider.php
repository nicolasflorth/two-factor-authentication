<?php

namespace Thecodework\TwoFactorAuthentication;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     * Loading Routes, Views and Migrations.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', '2fa');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publishing configuration file
        $this->publishes([
            __DIR__ . '/../config/2fa-config.php' => config_path('2fa-config.php'),
        ], 'config');

        // Publishing migration
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Publishing views
        $this->publishes([
            __DIR__ . '/../resources/views/' => resource_path('views/vendor/2fa'),
        ], 'views');
    }

    /**
     * Get User moded defined in config file
     *
     * @return string
     */
    public static function determineUserModel(): string
    {
        return $userModel = config('2fa-config.model');
    }

    /**
     * Get User Model Instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getUserModelInstance(): Model {
        $userModelClassName = self::determineUserModel();
        return new $userModelClassName();
    }
}
