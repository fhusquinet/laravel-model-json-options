<?php

namespace FHusquinet\ModelOptions\Tests;

use FHusquinet\ModelOptions\Models\CampaignActivity;
use FHusquinet\ModelOptions\Tests\Models\User;
use Illuminate\Database\Schema\Blueprint;
use FHusquinet\ModelOptions\Tests\Models\Article;
use FHusquinet\ModelOptions\ModelOptionsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function checkRequirements()
    {
        parent::checkRequirements();

        collect($this->getAnnotations())->filter(function ($location) {
            return in_array('!Travis', array_get($location, 'requires', []));
        })->each(function ($location) {
            getenv('TRAVIS') && $this->markTestSkipped('Travis will not run this test.');
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            ModelOptionsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => $this->getTempDirectory().'/database.sqlite',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');
    }

    protected function changeDatabaseConnection($connection)
    {
        $this->app['config']->set('database.connections.default', $connection);
    }

    protected function setUpDatabase()
    {
        $this->resetDatabase();

        $this->createUsersTable();
    }

    protected function resetDatabase()
    {
        //
    }

    public function getTempDirectory(): string
    {
        return __DIR__.'/temp';
    }

    protected function createUsersTable()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table)  {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function doNotMarkAsRisky()
    {
        $this->assertTrue(true);
    }
}