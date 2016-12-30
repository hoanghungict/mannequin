<?php namespace Tests\Repositories;

use App\Models\Log;
use Tests\TestCase;

class LogRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\LogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\LogRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $logs = factory(Log::class, 3)->create();
        $logIds = $logs->pluck('id')->toArray();

        /** @var  \App\Repositories\LogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\LogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $logsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Log::class, $logsCheck[0]);

        $logsCheck = $repository->getByIds($logIds);
        $this->assertEquals(3, count($logsCheck));
    }

    public function testFind()
    {
        $logs = factory(Log::class, 3)->create();
        $logIds = $logs->pluck('id')->toArray();

        /** @var  \App\Repositories\LogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\LogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $logCheck = $repository->find($logIds[0]);
        $this->assertEquals($logIds[0], $logCheck->id);
    }

    public function testCreate()
    {
        $logData = factory(Log::class)->make();

        /** @var  \App\Repositories\LogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\LogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $logCheck = $repository->create($logData->toArray());
        $this->assertNotNull($logCheck);
    }

    public function testUpdate()
    {
        $logData = factory(Log::class)->create();

        /** @var  \App\Repositories\LogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\LogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $logCheck = $repository->update($logData, $logData->toArray());
        $this->assertNotNull($logCheck);
    }

    public function testDelete()
    {
        $logData = factory(Log::class)->create();

        /** @var  \App\Repositories\LogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\LogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($logData);

        $logCheck = $repository->find($logData->id);
        $this->assertNull($logCheck);
    }

}
