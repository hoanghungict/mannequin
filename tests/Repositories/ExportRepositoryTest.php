<?php namespace Tests\Repositories;

use App\Models\Export;
use Tests\TestCase;

class ExportRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ExportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $exports = factory(Export::class, 3)->create();
        $exportIds = $exports->pluck('id')->toArray();

        /** @var  \App\Repositories\ExportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Export::class, $exportsCheck[0]);

        $exportsCheck = $repository->getByIds($exportIds);
        $this->assertEquals(3, count($exportsCheck));
    }

    public function testFind()
    {
        $exports = factory(Export::class, 3)->create();
        $exportIds = $exports->pluck('id')->toArray();

        /** @var  \App\Repositories\ExportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportCheck = $repository->find($exportIds[0]);
        $this->assertEquals($exportIds[0], $exportCheck->id);
    }

    public function testCreate()
    {
        $exportData = factory(Export::class)->make();

        /** @var  \App\Repositories\ExportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportCheck = $repository->create($exportData->toArray());
        $this->assertNotNull($exportCheck);
    }

    public function testUpdate()
    {
        $exportData = factory(Export::class)->create();

        /** @var  \App\Repositories\ExportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $exportCheck = $repository->update($exportData, $exportData->toArray());
        $this->assertNotNull($exportCheck);
    }

    public function testDelete()
    {
        $exportData = factory(Export::class)->create();

        /** @var  \App\Repositories\ExportRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ExportRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($exportData);

        $exportCheck = $repository->find($exportData->id);
        $this->assertNull($exportCheck);
    }

}
