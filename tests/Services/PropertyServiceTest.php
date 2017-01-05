<?php namespace Tests\Services;

use Tests\TestCase;

class PropertyServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\PropertyServiceInterface $service */
        $service = \App::make(\App\Services\PropertyServiceInterface::class);
        $this->assertNotNull($service);
    }

}
