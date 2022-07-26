<?php

namespace Sdkconsultoria\WhatsappCloudApi;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'WhatsappCloudApi';
    }
}
