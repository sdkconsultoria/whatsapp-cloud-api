<?php

namespace Sdkconsultoria\WhatsappCloudApi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Sdkconsultoria\WhatsappCloudApi\Services\FileManager;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:whatsapp-messenger-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala Whatsapp Messenger en tu proyecto.';

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
        $this->installInterface();
        $this->installLibrary();
        $this->finishMessage();
    }

    private function installInterface(): void
    {
        if ($this->confirm('¿Deseas instalar la interfaz, grafica?', true)) {
            $this->info('Instalando interfaz...');
            $this->updateNode();
            $this->addRoutes();
            $this->info('Copiando archivos de configuración de la interface...');
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/interface', base_path());
        }
    }

    /**
     * @codeCoverageIgnore
     */
    private function installLibrary(): void
    {
        $this->info('Instalando librería...');
        $this->enableBroadcastServiceProvider();
        $this->info('Copiando archivos de configuración de la libreria...');
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/common', base_path());

        switch ($this->getLaravelVersion()) {
            case 10:
                $this->copyConfigurationFileForLaravel10();
                break;
            case 11:
                $this->copyConfigurationFileForLaravel11();
                break;
            default:
                $this->error('No se encontró una versión de Laravel compatible.');
                break;
        }
    }

    private function getLaravelVersion()
    {
        $laravel = app();

        return intval($laravel::VERSION);
    }

    /**
     * @codeCoverageIgnore
     */
    private function copyConfigurationFileForLaravel10()
    {
        $this->info('Copiando archivos de configuración para laravel 10...');

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/10', base_path());
    }

    private function copyConfigurationFileForLaravel11()
    {
        $this->info('Copiando archivos de configuración para laravel 11...');

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/11', base_path());
    }

    /**
     * @codeCoverageIgnore
     */
    private function updateNode()
    {
        $this->info('Actualizando Node Packages...');

        $this->updateNodePackages(function ($packages) {
            return [
                'autoprefixer' => '^10.4.17',
                'postcss' => '^8.4.35',
                'tailwindcss' => '^3.4.1',
                'postcss-import' => '^15.1.0',
                'vue' => '^3.4.19',
                '@vitejs/plugin-vue' => '^5.0.4',
                'daisyui' => '^4.7.2',
                'laravel-echo' => '^1.15.3',
                'pusher-js' => '^8.3.0',
                '@heroicons/vue' => '^2.1.1',
                'sweetalert2' => '^11.10.5',
            ] + $packages;
        });
    }

    /**
     * @codeCoverageIgnore
     * Update the "package.json" file.
     *
     * @param  bool  $dev
     * @return void
     */
    private function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    private function addRoutes()
    {
        $this->info('Agregando rutas...');

        $file = base_path('routes').'/web.php';

        resolve(FileManager::class)::append($file, "Route::get('/messenger', fn() => view('messenger'));");
        resolve(FileManager::class)::append($file, "Route::ResourceView('template');");
    }

    private function enableBroadcastServiceProvider()
    {
        $this->info('Habilitando BroadcastServiceProvider...');

        $file = base_path('config').'/app.php';

        resolve(FileManager::class)::replace(
            "// App\Providers\BroadcastServiceProvider::class",
            "App\Providers\BroadcastServiceProvider::class",
            $file
        );
    }

    private function finishMessage()
    {
        $this->info('SDK Whatsapp Messenger instalado correctamente.');
        $this->comment('Ejecuta "npm install && npm run dev" para compilar tu frontend.');
    }
}
