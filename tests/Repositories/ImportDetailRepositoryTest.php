<?php namespace Tests\Repositories;

use App\Models\ImportDetail;
use Tests\TestCase;

class ImportDetailRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ImportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $importDetails = factory(ImportDetail::class, 3)->create();
        $importDetailIds = $importDetails->pluck('id')->toArray();

        /** @var  \App\Repositories\ImportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importDetailsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ImportDetail::class, $importDetailsCheck[0]);

        $importDetailsCheck = $repository->getByIds($importDetailIds);
        $this->assertEquals(3, count($importDetailsCheck));
    }

    public function testFind()
    {
        $importDetails = factory(ImportDetail::class, 3)->create();
        $importDetailIds = $importDetails->pluck('id')->toArray();

        /** @var  \App\Repositories\ImportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importDetailCheck = $repository->find($importDetailIds[0]);
        $this->assertEquals($importDetailIds[0], $importDetailCheck->id);
    }

    public function testCreate()
    {
        $importDetailData = factory(ImportDetail::class)->make();

        /** @var  \App\Repositories\ImportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importDetailCheck = $repository->create($importDetailData->toArray());
        $this->assertNotNull($importDetailCheck);
    }

    public function testUpdate()
    {
        $importDetailData = factory(ImportDetail::class)->create();

        /** @var  \App\Repositories\ImportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importDetailCheck = $repository->update($importDetailData, $importDetailData->toArray());
        $this->assertNotNull($importDetailCheck);
    }

    public function testDelete()
    {
        $importDetailData = factory(ImportDetail::class)->create();

        /** @var  \App\Repositories\ImportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($importDetailData);

        $importDetailCheck = $repository->find($importDetailData->id);
        $this->assertNull($importDetailCheck);
    }

}
