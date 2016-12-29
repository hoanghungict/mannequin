<?php namespace Tests\Repositories;

use App\Models\Product;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ProductRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $products = factory(Product::class, 3)->create();
        $productIds = $products->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Product::class, $productsCheck[0]);

        $productsCheck = $repository->getByIds($productIds);
        $this->assertEquals(3, count($productsCheck));
    }

    public function testFind()
    {
        $products = factory(Product::class, 3)->create();
        $productIds = $products->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productCheck = $repository->find($productIds[0]);
        $this->assertEquals($productIds[0], $productCheck->id);
    }

    public function testCreate()
    {
        $productData = factory(Product::class)->make();

        /** @var  \App\Repositories\ProductRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productCheck = $repository->create($productData->toArray());
        $this->assertNotNull($productCheck);
    }

    public function testUpdate()
    {
        $productData = factory(Product::class)->create();

        /** @var  \App\Repositories\ProductRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productCheck = $repository->update($productData, $productData->toArray());
        $this->assertNotNull($productCheck);
    }

    public function testDelete()
    {
        $productData = factory(Product::class)->create();

        /** @var  \App\Repositories\ProductRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($productData);

        $productCheck = $repository->find($productData->id);
        $this->assertNull($productCheck);
    }

}
