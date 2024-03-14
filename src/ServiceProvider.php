<?php

namespace Sdkconsultoria\WhatsappCloudApi;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->registerBroadcasting();
        $this->registerMigrations();
        $this->registerCustomFactory();
        $this->registerCommands();
        $this->registerRouteMacro();
    }

    private function registerBroadcasting(): void
    {
        Broadcast::routes();

        require __DIR__.'/../routes/channels.php';
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * @codeCoverageIgnore
     */
    private function registerCustomFactory(): void
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

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Sdkconsultoria\WhatsappCloudApi\Console\Commands\InstallCommand::class,
                \Sdkconsultoria\WhatsappCloudApi\Console\Commands\CopyMessengerCommand::class,
            ]);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    private function registerRouteMacro(): void
    {
        Route::macro('ResourceView', function ($uri) {
            Route::get("{$uri}", fn () => view("{$uri}.index"))->name("{$uri}_view.index");
            Route::get("{$uri}/create", fn () => view("{$uri}.create"))->name("{$uri}_view.create");
            Route::get("{$uri}/update/{id}", fn () => view("{$uri}.edit"))->name("{$uri}_view.edit");
            Route::get("{$uri}/{id}", fn () => view("{$uri}.show"))->name("{$uri}_view.show");
        });

        Route::macro('ApiResource', function ($uri, $controller) {
            Route::get("{$uri}", "{$controller}@index")->name("{$uri}.index");
            Route::post("{$uri}/create", "{$controller}@storage")->name("{$uri}.storage");
            Route::put("{$uri}/update/{id}", "{$controller}@update")->name("{$uri}.update");
            Route::get("{$uri}/{id}", "{$controller}@show")->name("{$uri}.show");
            Route::delete("{$uri}/{id}", "{$controller}@destroy")->name("{$uri}.destroy");
        });
    }

    /**
     * Register any application services.
     *
     * @codeCoverageIgnore
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/cloudapi.php', 'meta'
        );

        $this->app->bind('WhatsappCloudApi', function () {
            return new WhatsappCloudApi();
        });
    }
}
