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
    protected $description = 'Instala el frontend de Whatsapp Messenger en tu proyecto.';

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
        $this->updateNode();
        $this->copyStubs();
        $this->addRoutes();
        $this->enableBroadcastServiceProvider();
        $this->finishMessage();
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

    private function copyStubs()
    {
        $this->info('Copiando archivos de configuración...');

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs', base_path());
    }

    private function addRoutes()
    {
        $this->info('Agregando rutas...');

        $file = base_path('routes').'/web.php';

        resolve(FileManager::class)::append($file, "Route::get('/messenger', fn() => view('messenger'));");
        resolve(FileManager::class)::append($file, "Route::get('/templates', fn() => view('template'));");
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
