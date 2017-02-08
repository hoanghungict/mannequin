<?php namespace Tests\Services;

use Tests\TestCase;

class ExportServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\ExportServiceInterface $service */
        $service = \App::make(\App\Services\ExportServiceInterface::class);
        $this->assertNotNull($service);
    }

}
