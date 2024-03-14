<?php

namespace Sdkconsultoria\WhatsappCloudApi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CopyMessengerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:copy-messenger-to-package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copia el messenger al paquete.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Esto sobrescribira el messenger del paquete usando el messenger del proyecto principal, estas seguro de continuar?')) {
            $this->copyMessenger();
            $this->comment('SDK Whatsapp Messenger se copio correctamente.');
        }
    }

    /**
     * Cuando estamos desarrollando nueva funcionalidad en el messenger, necesitamos copiar el messenger del proyecto principal al paquete.
     */
    private function copyMessenger(): void
    {
        $this->info('Copiando messenger a los stubs del packate...');
        $proyectPath = base_path('resources/js/components/Messenger');
        $packagePath = __DIR__.'/../../../stubs/interface/resources/js/components/Messenger';
        resolve(Filesystem::class)->deleteDirectory($packagePath);
        resolve(Filesystem::class)->copyDirectory($proyectPath, $packagePath);
    }
}
