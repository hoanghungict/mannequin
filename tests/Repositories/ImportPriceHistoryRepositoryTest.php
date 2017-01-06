<?php namespace Tests\Repositories;

use App\Models\ImportPriceHistory;
use Tests\TestCase;

class ImportPriceHistoryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ImportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $importPriceHistories = factory(ImportPriceHistory::class, 3)->create();
        $importPriceHistoryIds = $importPriceHistories->pluck('id')->toArray();

        /** @var  \App\Repositories\ImportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importPriceHistoriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(ImportPriceHistory::class, $importPriceHistoriesCheck[0]);

        $importPriceHistoriesCheck = $repository->getByIds($importPriceHistoryIds);
        $this->assertEquals(3, count($importPriceHistoriesCheck));
    }

    public function testFind()
    {
        $importPriceHistories = factory(ImportPriceHistory::class, 3)->create();
        $importPriceHistoryIds = $importPriceHistories->pluck('id')->toArray();

        /** @var  \App\Repositories\ImportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importPriceHistoryCheck = $repository->find($importPriceHistoryIds[0]);
        $this->assertEquals($importPriceHistoryIds[0], $importPriceHistoryCheck->id);
    }

    public function testCreate()
    {
        $importPriceHistoryData = factory(ImportPriceHistory::class)->make();

        /** @var  \App\Repositories\ImportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importPriceHistoryCheck = $repository->create($importPriceHistoryData->toArray());
        $this->assertNotNull($importPriceHistoryCheck);
    }

    public function testUpdate()
    {
        $importPriceHistoryData = factory(ImportPriceHistory::class)->create();

        /** @var  \App\Repositories\ImportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $importPriceHistoryCheck = $repository->update($importPriceHistoryData, $importPriceHistoryData->toArray());
        $this->assertNotNull($importPriceHistoryCheck);
    }

    public function testDelete()
    {
        $importPriceHistoryData = factory(ImportPriceHistory::class)->create();

        /** @var  \App\Repositories\ImportPriceHistoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ImportPriceHistoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($importPriceHistoryData);

        $importPriceHistoryCheck = $repository->find($importPriceHistoryData->id);
        $this->assertNull($importPriceHistoryCheck);
    }

}
