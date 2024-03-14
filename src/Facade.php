<?php

namespace Sdkconsultoria\WhatsappCloudApi;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'WhatsappCloudApi';
    }
}
