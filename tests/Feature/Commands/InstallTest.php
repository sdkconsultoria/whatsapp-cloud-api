<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Commands;

use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Sdkconsultoria\WhatsappCloudApi\Services\FileManager;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class InstallTest extends TestCase
{
    use WithFaker;

    public function test_install()
    {
        $this->partialMock(FileManager::class, function (MockInterface $mock) {
            $mock->shouldReceive('replace')->once();
        });

        $this->artisan('sdk:whatsapp-messenger-install')
            ->expectsOutput('Actualizando Node Packages...')
            ->expectsOutput('Copiando archivos de configuración...')
            ->expectsOutput('Habilitando BroadcastServiceProvider...')
            ->expectsOutput('SDK Whatsapp Messenger instalado correctamente.')
            ->expectsOutput('Ejecuta "npm install && npm run dev" para compilar tu frontend.')
            ->assertExitCode(0);
    }
}
