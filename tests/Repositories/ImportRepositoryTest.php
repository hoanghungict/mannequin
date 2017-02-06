<?php namespace Tests\Repositories;

use App\Models\Import;
use Tests\TestCase;

class ImportRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ImportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $imports = factory(Import::class, 3)->create();
        $importIds = $imports->pluck('id')->toArray();

        /** @var  \App\Repositories\ImportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Import::class, $importsCheck[0]);

        $importsCheck = $repository->getByIds($importIds);
        $this->assertEquals(3, count($importsCheck));
    }

    public function testFind()
    {
        $imports = factory(Import::class, 3)->create();
        $importIds = $imports->pluck('id')->toArray();

        /** @var  \App\Repositories\ImportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importCheck = $repository->find($importIds[0]);
        $this->assertEquals($importIds[0], $importCheck->id);
    }

    public function testCreate()
    {
        $importData = factory(Import::class)->make();

        /** @var  \App\Repositories\ImportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importCheck = $repository->create($importData->toArray());
        $this->assertNotNull($importCheck);
    }

    public function testUpdate()
    {
        $importData = factory(Import::class)->create();

        /** @var  \App\Repositories\ImportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importCheck = $repository->update($importData, $importData->toArray());
        $this->assertNotNull($importCheck);
    }

    public function testDelete()
    {
        $importData = factory(Import::class)->create();

        /** @var  \App\Repositories\ImportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($importData);

        $importCheck = $repository->find($importData->id);
        $this->assertNull($importCheck);
    }

}
