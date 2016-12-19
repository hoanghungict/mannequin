<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\EmployeeController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\EmployeeController::class);
        $this->assertNotNull($controller);
    }

    public function setUp()
    {
        parent::setUp();
        $authUser = \App\Models\AdminUser::first();
        $this->be($authUser, 'admins');
    }

    public function testGetList()
    {
        $response = $this->action('GET', 'Admin\EmployeeController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\EmployeeController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $employee = factory(\App\Models\Employee::class)->make();
        $this->action('POST', 'Admin\EmployeeController@store', [
                '_token' => csrf_token(),
            ] + $employee->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $employee = factory(\App\Models\Employee::class)->create();
        $this->action('GET', 'Admin\EmployeeController@show', [$employee->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $employee = factory(\App\Models\Employee::class)->create();

        $name = $faker->name;
        $id = $employee->id;

        $employee->name = $name;

        $this->action('PUT', 'Admin\EmployeeController@update', [$id], [
                '_token' => csrf_token(),
            ] + $employee->toArray());
        $this->assertResponseStatus(302);

        $newEmployee = \App\Models\Employee::find($id);
        $this->assertEquals($name, $newEmployee->name);
    }

    public function testDeleteModel()
    {
        $employee = factory(\App\Models\Employee::class)->create();

        $id = $employee->id;

        $this->action('DELETE', 'Admin\EmployeeController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkEmployee = \App\Models\Employee::find($id);
        $this->assertNull($checkEmployee);
    }

}
