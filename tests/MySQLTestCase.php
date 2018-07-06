<?php

namespace FHusquinet\ModelOptions\Tests;

use FHusquinet\ModelOptions\Models\CampaignActivity;
use FHusquinet\ModelOptions\Tests\Models\User;
use Illuminate\Database\Schema\Blueprint;
use FHusquinet\ModelOptions\Tests\Models\Article;
use FHusquinet\ModelOptions\ModelOptionsServiceProvider;

abstract class MySQLTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql');

        $app['config']->set('database.connections.mysql.database', 'laravel-model-json-options');
        $app['config']->set('database.connections.mysql.username', 'root');
        $app['config']->set('database.connections.mysql.password', 'root');

        $app['config']->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');
    }

    protected function resetDatabase()
    {        
        if ( $this->app['db']->connection()->getSchemaBuilder()->hasTable('users') ) { 
            $this->app['db']->connection()->getSchemaBuilder()->drop('users');
        }
    }
}