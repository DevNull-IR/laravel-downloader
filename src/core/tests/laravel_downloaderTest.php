<?php

namespace DevNullIr\LaravelDownloader\core\tests;
use PHPUnit\Framework\TestCase;

class laravel_downloaderTest extends TestCase
{

    /**
     * @test
     */
    public function test_route_dl(): void
    {
        $response = $this->get(route("laravelDownloaderDl"));
        $response->assertStatus(200);
    }
}
