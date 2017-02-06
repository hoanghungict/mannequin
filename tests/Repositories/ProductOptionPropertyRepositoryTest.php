<?php namespace Tests\Repositories;

use App\Models\ProductOptionProperty;
use Tests\TestCase;

class ProductOptionPropertyRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ProductOptionPropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionPropertyRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $productOptionProperties = factory(ProductOptionProperty::class, 3)->create();
        $productOptionPropertyIds = $productOptionProperties->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductOptionPropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionPropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionPropertiesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ProductOptionProperty::class, $productOptionPropertiesCheck[0]);

        $productOptionPropertiesCheck = $repository->getByIds($productOptionPropertyIds);
        $this->assertEquals(3, count($productOptionPropertiesCheck));
    }

    public function testFind()
    {
        $productOptionProperties = factory(ProductOptionProperty::class, 3)->create();
        $productOptionPropertyIds = $productOptionProperties->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductOptionPropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionPropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionPropertyCheck = $repository->find($productOptionPropertyIds[0]);
        $this->assertEquals($productOptionPropertyIds[0], $productOptionPropertyCheck->id);
    }

    public function testCreate()
    {
        $productOptionPropertyData = factory(ProductOptionProperty::class)->make();

        /** @var  \App\Repositories\ProductOptionPropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionPropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionPropertyCheck = $repository->create($productOptionPropertyData->toArray());
        $this->assertNotNull($productOptionPropertyCheck);
    }

    public function testUpdate()
    {
        $productOptionPropertyData = factory(ProductOptionProperty::class)->create();

        /** @var  \App\Repositories\ProductOptionPropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionPropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionPropertyCheck = $repository->update($productOptionPropertyData, $productOptionPropertyData->toArray());
        $this->assertNotNull($productOptionPropertyCheck);
    }

    public function testDelete()
    {
        $productOptionPropertyData = factory(ProductOptionProperty::class)->create();

        /** @var  \App\Repositories\ProductOptionPropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionPropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($productOptionPropertyData);

        $productOptionPropertyCheck = $repository->find($productOptionPropertyData->id);
        $this->assertNull($productOptionPropertyCheck);
    }

}
