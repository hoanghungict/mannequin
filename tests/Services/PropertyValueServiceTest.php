<?php namespace Tests\Services;

use Tests\TestCase;

class PropertyValueServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\PropertyValueServiceInterface $service */
        $service = \App::make(\App\Services\PropertyValueServiceInterface::class);
        $this->assertNotNull($service);
    }

}
