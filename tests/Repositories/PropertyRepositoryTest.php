<?php namespace Tests\Repositories;

use App\Models\Property;
use Tests\TestCase;

class PropertyRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $properties = factory(Property::class, 3)->create();
        $propertyIds = $properties->pluck('id')->toArray();

        /** @var  \App\Repositories\PropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertiesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Property::class, $propertiesCheck[0]);

        $propertiesCheck = $repository->getByIds($propertyIds);
        $this->assertEquals(3, count($propertiesCheck));
    }

    public function testFind()
    {
        $properties = factory(Property::class, 3)->create();
        $propertyIds = $properties->pluck('id')->toArray();

        /** @var  \App\Repositories\PropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyCheck = $repository->find($propertyIds[0]);
        $this->assertEquals($propertyIds[0], $propertyCheck->id);
    }

    public function testCreate()
    {
        $propertyData = factory(Property::class)->make();

        /** @var  \App\Repositories\PropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyCheck = $repository->create($propertyData->toArray());
        $this->assertNotNull($propertyCheck);
    }

    public function testUpdate()
    {
        $propertyData = factory(Property::class)->create();

        /** @var  \App\Repositories\PropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $propertyCheck = $repository->update($propertyData, $propertyData->toArray());
        $this->assertNotNull($propertyCheck);
    }

    public function testDelete()
    {
        $propertyData = factory(Property::class)->create();

        /** @var  \App\Repositories\PropertyRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PropertyRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($propertyData);

        $propertyCheck = $repository->find($propertyData->id);
        $this->assertNull($propertyCheck);
    }

}
