<?php namespace Tests\Repositories;

use App\Models\ProductImage;
use Tests\TestCase;

class ProductImageRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ProductImageRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductImageRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $productImages = factory(ProductImage::class, 3)->create();
        $productImageIds = $productImages->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductImageRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductImageRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productImagesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ProductImage::class, $productImagesCheck[0]);

        $productImagesCheck = $repository->getByIds($productImageIds);
        $this->assertEquals(3, count($productImagesCheck));
    }

    public function testFind()
    {
        $productImages = factory(ProductImage::class, 3)->create();
        $productImageIds = $productImages->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductImageRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductImageRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productImageCheck = $repository->find($productImageIds[0]);
        $this->assertEquals($productImageIds[0], $productImageCheck->id);
    }

    public function testCreate()
    {
        $productImageData = factory(ProductImage::class)->make();

        /** @var  \App\Repositories\ProductImageRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductImageRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productImageCheck = $repository->create($productImageData->toArray());
        $this->assertNotNull($productImageCheck);
    }

    public function testUpdate()
    {
        $productImageData = factory(ProductImage::class)->create();

        /** @var  \App\Repositories\ProductImageRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductImageRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productImageCheck = $repository->update($productImageData, $productImageData->toArray());
        $this->assertNotNull($productImageCheck);
    }

    public function testDelete()
    {
        $productImageData = factory(ProductImage::class)->create();

        /** @var  \App\Repositories\ProductImageRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductImageRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($productImageData);

        $productImageCheck = $repository->find($productImageData->id);
        $this->assertNull($productImageCheck);
    }

}
