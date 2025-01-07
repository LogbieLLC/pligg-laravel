<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->beginDatabaseTransaction();
    }

    protected function beginDatabaseTransaction(): void
    {
        $database = $this->app->make('db');
        foreach ($this->connectionsToTransact() as $name) {
            $connection = $database->connection($name);
            $connection->beginTransaction();
            $this->beforeApplicationDestroyed(function () use ($connection) {
                $connection->rollBack();
            });
        }
    }

    protected function connectionsToTransact(): array
    {
        return [null];
    }
}
