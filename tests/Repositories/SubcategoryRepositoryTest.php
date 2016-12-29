<?php namespace Tests\Repositories;

use App\Models\Subcategory;
use Tests\TestCase;

class SubcategoryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\SubcategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SubcategoryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $subcategories = factory(Subcategory::class, 3)->create();
        $subcategoryIds = $subcategories->pluck('id')->toArray();

        /** @var  \App\Repositories\SubcategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SubcategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $subcategoriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Subcategory::class, $subcategoriesCheck[0]);

        $subcategoriesCheck = $repository->getByIds($subcategoryIds);
        $this->assertEquals(3, count($subcategoriesCheck));
    }

    public function testFind()
    {
        $subcategories = factory(Subcategory::class, 3)->create();
        $subcategoryIds = $subcategories->pluck('id')->toArray();

        /** @var  \App\Repositories\SubcategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SubcategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $subcategoryCheck = $repository->find($subcategoryIds[0]);
        $this->assertEquals($subcategoryIds[0], $subcategoryCheck->id);
    }

    public function testCreate()
    {
        $subcategoryData = factory(Subcategory::class)->make();

        /** @var  \App\Repositories\SubcategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SubcategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $subcategoryCheck = $repository->create($subcategoryData->toArray());
        $this->assertNotNull($subcategoryCheck);
    }

    public function testUpdate()
    {
        $subcategoryData = factory(Subcategory::class)->create();

        /** @var  \App\Repositories\SubcategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SubcategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $subcategoryCheck = $repository->update($subcategoryData, $subcategoryData->toArray());
        $this->assertNotNull($subcategoryCheck);
    }

    public function testDelete()
    {
        $subcategoryData = factory(Subcategory::class)->create();

        /** @var  \App\Repositories\SubcategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SubcategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($subcategoryData);

        $subcategoryCheck = $repository->find($subcategoryData->id);
        $this->assertNull($subcategoryCheck);
    }

}
