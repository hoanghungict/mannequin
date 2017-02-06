<?php namespace Tests\Repositories;

use App\Models\ExportPriceHistory;
use Tests\TestCase;

class ExportPriceHistoryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ExportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $exportPriceHistories = factory(ExportPriceHistory::class, 3)->create();
        $exportPriceHistoryIds = $exportPriceHistories->pluck('id')->toArray();

        /** @var  \App\Repositories\ExportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportPriceHistoriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ExportPriceHistory::class, $exportPriceHistoriesCheck[0]);

        $exportPriceHistoriesCheck = $repository->getByIds($exportPriceHistoryIds);
        $this->assertEquals(3, count($exportPriceHistoriesCheck));
    }

    public function testFind()
    {
        $exportPriceHistories = factory(ExportPriceHistory::class, 3)->create();
        $exportPriceHistoryIds = $exportPriceHistories->pluck('id')->toArray();

        /** @var  \App\Repositories\ExportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportPriceHistoryCheck = $repository->find($exportPriceHistoryIds[0]);
        $this->assertEquals($exportPriceHistoryIds[0], $exportPriceHistoryCheck->id);
    }

    public function testCreate()
    {
        $exportPriceHistoryData = factory(ExportPriceHistory::class)->make();

        /** @var  \App\Repositories\ExportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportPriceHistoryCheck = $repository->create($exportPriceHistoryData->toArray());
        $this->assertNotNull($exportPriceHistoryCheck);
    }

    public function testUpdate()
    {
        $exportPriceHistoryData = factory(ExportPriceHistory::class)->create();

        /** @var  \App\Repositories\ExportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportPriceHistoryCheck = $repository->update($exportPriceHistoryData, $exportPriceHistoryData->toArray());
        $this->assertNotNull($exportPriceHistoryCheck);
    }

    public function testDelete()
    {
        $exportPriceHistoryData = factory(ExportPriceHistory::class)->create();

        /** @var  \App\Repositories\ExportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($exportPriceHistoryData);

        $exportPriceHistoryCheck = $repository->find($exportPriceHistoryData->id);
        $this->assertNull($exportPriceHistoryCheck);
    }

}
