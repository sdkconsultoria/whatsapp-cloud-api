<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests;


use Orchestra\Testbench\TestCase as Orchestra;
use Sdkconsultoria\WhatsappCloudApi\ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected static $migration;

    protected static $customMigration;

    public function setUp(): void
    {
        parent::setUp();

        if (! self::$migration) {
            $this->loadLaravelMigrations();
            $this->artisan('migrate')->run();

            self::$customMigration = true;
        }
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('logging.default', 'single');
        $app['config']->set('logging.channels.single', [
            'driver' => 'single',
            'path' => __DIR__.'/logs/test.log',
            'level' => 'debug',
        ]);
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Ignore package discovery from.
     *
     * @return array
     */
    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }
}