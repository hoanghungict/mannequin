<?php namespace Tests\Services;

use Tests\TestCase;

class ImportServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\ImportServiceInterface $service */
        $service = \App::make(\App\Services\ImportServiceInterface::class);
        $this->assertNotNull($service);
    }

}
