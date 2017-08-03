<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class UnitControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\UnitController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\UnitController::class);
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
        $response = $this->action('GET', 'Admin\UnitController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\UnitController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $unit = factory(\App\Models\Unit::class)->make();
        $this->action('POST', 'Admin\UnitController@store', [
                '_token' => csrf_token(),
            ] + $unit->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $unit = factory(\App\Models\Unit::class)->create();
        $this->action('GET', 'Admin\UnitController@show', [$unit->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $unit = factory(\App\Models\Unit::class)->create();

        $name = $faker->name;
        $id = $unit->id;

        $unit->name = $name;

        $this->action('PUT', 'Admin\UnitController@update', [$id], [
                '_token' => csrf_token(),
            ] + $unit->toArray());
        $this->assertResponseStatus(302);

        $newUnit = \App\Models\Unit::find($id);
        $this->assertEquals($name, $newUnit->name);
    }

    public function testDeleteModel()
    {
        $unit = factory(\App\Models\Unit::class)->create();

        $id = $unit->id;

        $this->action('DELETE', 'Admin\UnitController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkUnit = \App\Models\Unit::find($id);
        $this->assertNull($checkUnit);
    }

}
