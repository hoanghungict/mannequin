<?php namespace Tests\Repositories;

use App\Models\Employee;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\EmployeeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmployeeRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $employees = factory(Employee::class, 3)->create();
        $employeeIds = $employees->pluck('id')->toArray();

        /** @var  \App\Repositories\EmployeeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmployeeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $employeesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Employee::class, $employeesCheck[0]);

        $employeesCheck = $repository->getByIds($employeeIds);
        $this->assertEquals(3, count($employeesCheck));
    }

    public function testFind()
    {
        $employees = factory(Employee::class, 3)->create();
        $employeeIds = $employees->pluck('id')->toArray();

        /** @var  \App\Repositories\EmployeeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmployeeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $employeeCheck = $repository->find($employeeIds[0]);
        $this->assertEquals($employeeIds[0], $employeeCheck->id);
    }

    public function testCreate()
    {
        $employeeData = factory(Employee::class)->make();

        /** @var  \App\Repositories\EmployeeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmployeeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $employeeCheck = $repository->create($employeeData->toArray());
        $this->assertNotNull($employeeCheck);
    }

    public function testUpdate()
    {
        $employeeData = factory(Employee::class)->create();

        /** @var  \App\Repositories\EmployeeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmployeeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $employeeCheck = $repository->update($employeeData, $employeeData->toArray());
        $this->assertNotNull($employeeCheck);
    }

    public function testDelete()
    {
        $employeeData = factory(Employee::class)->create();

        /** @var  \App\Repositories\EmployeeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmployeeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($employeeData);

        $employeeCheck = $repository->find($employeeData->id);
        $this->assertNull($employeeCheck);
    }

}
