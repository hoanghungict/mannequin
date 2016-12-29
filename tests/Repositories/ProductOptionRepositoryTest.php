<?php namespace Tests\Repositories;

use App\Models\ProductOption;
use Tests\TestCase;

class ProductOptionRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ProductOptionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $productOptions = factory(ProductOption::class, 3)->create();
        $productOptionIds = $productOptions->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductOptionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ProductOption::class, $productOptionsCheck[0]);

        $productOptionsCheck = $repository->getByIds($productOptionIds);
        $this->assertEquals(3, count($productOptionsCheck));
    }

    public function testFind()
    {
        $productOptions = factory(ProductOption::class, 3)->create();
        $productOptionIds = $productOptions->pluck('id')->toArray();

        /** @var  \App\Repositories\ProductOptionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionCheck = $repository->find($productOptionIds[0]);
        $this->assertEquals($productOptionIds[0], $productOptionCheck->id);
    }

    public function testCreate()
    {
        $productOptionData = factory(ProductOption::class)->make();

        /** @var  \App\Repositories\ProductOptionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionCheck = $repository->create($productOptionData->toArray());
        $this->assertNotNull($productOptionCheck);
    }

    public function testUpdate()
    {
        $productOptionData = factory(ProductOption::class)->create();

        /** @var  \App\Repositories\ProductOptionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $productOptionCheck = $repository->update($productOptionData, $productOptionData->toArray());
        $this->assertNotNull($productOptionCheck);
    }

    public function testDelete()
    {
        $productOptionData = factory(ProductOption::class)->create();

        /** @var  \App\Repositories\ProductOptionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProductOptionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($productOptionData);

        $productOptionCheck = $repository->find($productOptionData->id);
        $this->assertNull($productOptionCheck);
    }

}
