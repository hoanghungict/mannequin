<?php namespace Tests\Models;

use App\Models\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Employee $employee */
        $employee = new Employee();
        $this->assertNotNull($employee);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Employee $employee */
        $employeeModel = new Employee();

        $employeeData = factory(Employee::class)->make();
        foreach( $employeeData->toArray() as $key => $value ) {
            $employeeModel->$key = $value;
        }
        $employeeModel->save();

        $this->assertNotNull(Employee::find($employeeModel->id));
    }

}
