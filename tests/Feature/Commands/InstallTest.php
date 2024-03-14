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
            ->expectsConfirmation('¿Deseas instalar la interfaz, grafica?', 'yes')
            ->expectsOutput('Instalando interfaz...')
            ->expectsOutput('Actualizando Node Packages...')
            ->expectsOutput('Copiando archivos de configuración de la interface...')
            ->expectsOutput('Instalando librería...')
            ->expectsOutput('Habilitando BroadcastServiceProvider...')
            ->expectsOutput('Copiando archivos de configuración de la libreria...')
            ->expectsOutput('Copiando archivos de configuración para laravel 11...')
            ->expectsOutput('SDK Whatsapp Messenger instalado correctamente.')
            ->expectsOutput('Ejecuta "npm install && npm run dev" para compilar tu frontend.')
            ->assertExitCode(0);
    }

    public function test_install_without_interface()
    {
        $this->partialMock(FileManager::class, function (MockInterface $mock) {
            $mock->shouldReceive('replace')->once();
        });

        $this->artisan('sdk:whatsapp-messenger-install')
            ->expectsConfirmation('¿Deseas instalar la interfaz, grafica?', 'no')
            ->doesntExpectOutput('Instalando interfaz...')
            ->doesntExpectOutput('Actualizando Node Packages...')
            ->doesntExpectOutput('Copiando archivos de configuración de la interface...')
            ->expectsOutput('Instalando librería...')
            ->expectsOutput('Habilitando BroadcastServiceProvider...')
            ->expectsOutput('Copiando archivos de configuración de la libreria...')
            ->expectsOutput('Copiando archivos de configuración para laravel 11...')
            ->expectsOutput('SDK Whatsapp Messenger instalado correctamente.')
            ->expectsOutput('Ejecuta "npm install && npm run dev" para compilar tu frontend.')
            ->assertExitCode(0);
    }
}
