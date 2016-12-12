<?php namespace Tests\Repositories;

use App\Models\customer;
use Tests\TestCase;

class customerRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\customerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\customerRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $customers = factory(customer::class, 3)->create();
        $customerIds = $customers->pluck('id')->toArray();

        /** @var  \App\Repositories\customerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\customerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(customer::class, $customersCheck[0]);

        $customersCheck = $repository->getByIds($customerIds);
        $this->assertEquals(3, count($customersCheck));
    }

    public function testFind()
    {
        $customers = factory(customer::class, 3)->create();
        $customerIds = $customers->pluck('id')->toArray();

        /** @var  \App\Repositories\customerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\customerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customerCheck = $repository->find($customerIds[0]);
        $this->assertEquals($customerIds[0], $customerCheck->id);
    }

    public function testCreate()
    {
        $customerData = factory(customer::class)->make();

        /** @var  \App\Repositories\customerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\customerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customerCheck = $repository->create($customerData->toArray());
        $this->assertNotNull($customerCheck);
    }

    public function testUpdate()
    {
        $customerData = factory(customer::class)->create();

        /** @var  \App\Repositories\customerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\customerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customerCheck = $repository->update($customerData, $customerData->toArray());
        $this->assertNotNull($customerCheck);
    }

    public function testDelete()
    {
        $customerData = factory(customer::class)->create();

        /** @var  \App\Repositories\customerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\customerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($customerData);

        $customerCheck = $repository->find($customerData->id);
        $this->assertNull($customerCheck);
    }

}
