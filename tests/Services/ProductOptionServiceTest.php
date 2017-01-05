<?php namespace Tests\Services;

use Tests\TestCase;

class ProductOptionServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\ProductOptionServiceInterface $service */
        $service = \App::make(\App\Services\ProductOptionServiceInterface::class);
        $this->assertNotNull($service);
    }

}
