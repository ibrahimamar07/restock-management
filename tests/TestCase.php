<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\CreatesDatabaseSchema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use CreatesDatabaseSchema;

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabaseSchema();
    }
}
