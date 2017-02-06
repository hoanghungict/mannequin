<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ImportControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ImportController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ImportController::class);
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
        $response = $this->action('GET', 'Admin\ImportController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ImportController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $import = factory(\App\Models\Import::class)->make();
        $this->action('POST', 'Admin\ImportController@store', [
                '_token' => csrf_token(),
            ] + $import->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $import = factory(\App\Models\Import::class)->create();
        $this->action('GET', 'Admin\ImportController@show', [$import->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $import = factory(\App\Models\Import::class)->create();

        $name = $faker->name;
        $id = $import->id;

        $import->name = $name;

        $this->action('PUT', 'Admin\ImportController@update', [$id], [
                '_token' => csrf_token(),
            ] + $import->toArray());
        $this->assertResponseStatus(302);

        $newImport = \App\Models\Import::find($id);
        $this->assertEquals($name, $newImport->name);
    }

    public function testDeleteModel()
    {
        $import = factory(\App\Models\Import::class)->create();

        $id = $import->id;

        $this->action('DELETE', 'Admin\ImportController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkImport = \App\Models\Import::find($id);
        $this->assertNull($checkImport);
    }

}
