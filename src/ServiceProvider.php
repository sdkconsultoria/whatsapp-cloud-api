<?php

namespace Sdkconsultoria\WhatsappCloudApi;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/whatsappcloudapi.php', 'whatsappcloudapi'
        );
    }
}
