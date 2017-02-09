<?php namespace Tests\Repositories;

use App\Models\ExportDetail;
use Tests\TestCase;

class ExportDetailRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ExportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $exportDetails = factory(ExportDetail::class, 3)->create();
        $exportDetailIds = $exportDetails->pluck('id')->toArray();

        /** @var  \App\Repositories\ExportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportDetailsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ExportDetail::class, $exportDetailsCheck[0]);

        $exportDetailsCheck = $repository->getByIds($exportDetailIds);
        $this->assertEquals(3, count($exportDetailsCheck));
    }

    public function testFind()
    {
        $exportDetails = factory(ExportDetail::class, 3)->create();
        $exportDetailIds = $exportDetails->pluck('id')->toArray();

        /** @var  \App\Repositories\ExportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportDetailCheck = $repository->find($exportDetailIds[0]);
        $this->assertEquals($exportDetailIds[0], $exportDetailCheck->id);
    }

    public function testCreate()
    {
        $exportDetailData = factory(ExportDetail::class)->make();

        /** @var  \App\Repositories\ExportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportDetailCheck = $repository->create($exportDetailData->toArray());
        $this->assertNotNull($exportDetailCheck);
    }

    public function testUpdate()
    {
        $exportDetailData = factory(ExportDetail::class)->create();

        /** @var  \App\Repositories\ExportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportDetailCheck = $repository->update($exportDetailData, $exportDetailData->toArray());
        $this->assertNotNull($exportDetailCheck);
    }

    public function testDelete()
    {
        $exportDetailData = factory(ExportDetail::class)->create();

        /** @var  \App\Repositories\ExportDetailRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportDetailRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($exportDetailData);

        $exportDetailCheck = $repository->find($exportDetailData->id);
        $this->assertNull($exportDetailCheck);
    }

}
