<?php namespace Tests\Services;

use Tests\TestCase;

class ProductServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\ProductServiceInterface $service */
        $service = \App::make(\App\Services\ProductServiceInterface::class);
        $this->assertNotNull($service);
    }

}
