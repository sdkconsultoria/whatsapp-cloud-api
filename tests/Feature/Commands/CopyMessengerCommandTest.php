<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Commands;

use Illuminate\Foundation\Testing\WithFaker;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class CopyMessengerCommandTest extends TestCase
{
    use WithFaker;

    public function test_copy_messenger_to_package()
    {
        $this->artisan('sdk:copy-messenger-to-package')
            ->expectsConfirmation('Esto sobrescribira el messenger del paquete usando el messenger del proyecto principal, estas seguro de continuar?', 'yes')
            ->expectsOutput('Copiando messenger a los stubs del packate...')
            ->expectsOutput('SDK Whatsapp Messenger se copio correctamente.')
            ->assertExitCode(0);
    }
}
