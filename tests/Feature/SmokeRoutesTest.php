<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class SmokeRoutesTest extends TestCase
{
    public function test_root_route_exists_in_routes_file()
    {
        $routesPath = __DIR__.'/../../routes/web.php';
        $this->assertFileExists($routesPath, 'routes/web.php must exist for the smoke test');

        $contents = file_get_contents($routesPath);

        $this->assertStringContainsString("Route::get('/', function () {", $contents, 'Root route should be defined');
        $this->assertStringContainsString("return view('Main.welcome')", $contents, 'Root route should return the welcome view');
    }
}
