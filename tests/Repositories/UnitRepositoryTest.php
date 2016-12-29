<?php namespace Tests\Repositories;

use App\Models\Unit;
use Tests\TestCase;

class UnitRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\UnitRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\UnitRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $units = factory(Unit::class, 3)->create();
        $unitIds = $units->pluck('id')->toArray();

        /** @var  \App\Repositories\UnitRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\UnitRepositoryInterface::class);
        $this->assertNotNull($repository);

        $unitsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Unit::class, $unitsCheck[0]);

        $unitsCheck = $repository->getByIds($unitIds);
        $this->assertEquals(3, count($unitsCheck));
    }

    public function testFind()
    {
        $units = factory(Unit::class, 3)->create();
        $unitIds = $units->pluck('id')->toArray();

        /** @var  \App\Repositories\UnitRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\UnitRepositoryInterface::class);
        $this->assertNotNull($repository);

        $unitCheck = $repository->find($unitIds[0]);
        $this->assertEquals($unitIds[0], $unitCheck->id);
    }

    public function testCreate()
    {
        $unitData = factory(Unit::class)->make();

        /** @var  \App\Repositories\UnitRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\UnitRepositoryInterface::class);
        $this->assertNotNull($repository);

        $unitCheck = $repository->create($unitData->toArray());
        $this->assertNotNull($unitCheck);
    }

    public function testUpdate()
    {
        $unitData = factory(Unit::class)->create();

        /** @var  \App\Repositories\UnitRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\UnitRepositoryInterface::class);
        $this->assertNotNull($repository);

        $unitCheck = $repository->update($unitData, $unitData->toArray());
        $this->assertNotNull($unitCheck);
    }

    public function testDelete()
    {
        $unitData = factory(Unit::class)->create();

        /** @var  \App\Repositories\UnitRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\UnitRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($unitData);

        $unitCheck = $repository->find($unitData->id);
        $this->assertNull($unitCheck);
    }

}
