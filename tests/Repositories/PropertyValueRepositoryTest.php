<?php namespace Tests\Repositories;

use App\Models\PropertyValue;
use Tests\TestCase;

class PropertyValueRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PropertyValueRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyValueRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $propertyValues = factory(PropertyValue::class, 3)->create();
        $propertyValueIds = $propertyValues->pluck('id')->toArray();

        /** @var  \App\Repositories\PropertyValueRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyValueRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyValuesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(PropertyValue::class, $propertyValuesCheck[0]);

        $propertyValuesCheck = $repository->getByIds($propertyValueIds);
        $this->assertEquals(3, count($propertyValuesCheck));
    }

    public function testFind()
    {
        $propertyValues = factory(PropertyValue::class, 3)->create();
        $propertyValueIds = $propertyValues->pluck('id')->toArray();

        /** @var  \App\Repositories\PropertyValueRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyValueRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyValueCheck = $repository->find($propertyValueIds[0]);
        $this->assertEquals($propertyValueIds[0], $propertyValueCheck->id);
    }

    public function testCreate()
    {
        $propertyValueData = factory(PropertyValue::class)->make();

        /** @var  \App\Repositories\PropertyValueRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyValueRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyValueCheck = $repository->create($propertyValueData->toArray());
        $this->assertNotNull($propertyValueCheck);
    }

    public function testUpdate()
    {
        $propertyValueData = factory(PropertyValue::class)->create();

        /** @var  \App\Repositories\PropertyValueRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyValueRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyValueCheck = $repository->update($propertyValueData, $propertyValueData->toArray());
        $this->assertNotNull($propertyValueCheck);
    }

    public function testDelete()
    {
        $propertyValueData = factory(PropertyValue::class)->create();

        /** @var  \App\Repositories\PropertyValueRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyValueRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($propertyValueData);

        $propertyValueCheck = $repository->find($propertyValueData->id);
        $this->assertNull($propertyValueCheck);
    }

}
