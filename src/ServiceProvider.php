<?php

namespace Sdkconsultoria\WhatsappCloudApi;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Str;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->registerBroadcasting();
        $this->registerMigrations();
        $this->registerCustomFactory();
    }

    private function registerBroadcasting()
    {
        Broadcast::routes();

        require __DIR__.'/../routes/channels.php';
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    private function registerCustomFactory()
    {
        Factory::guessFactoryNamesUsing(function (string $model_name) {
            $sdk = Str::startsWith($model_name, 'Sdkconsultoria');

            if ($sdk) {
                return Str::of($model_name)->replace('Models', 'Factories').'Factory';
            }

            $namespace = 'Database\\Factories\\';

            $model_name = str_replace('App\\Models\\', '', $model_name);

            return $namespace.$model_name.'Factory';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/cloudapi.php', 'meta'
        );
    }
}
