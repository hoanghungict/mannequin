<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ExportControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ExportController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ExportController::class);
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
        $response = $this->action('GET', 'Admin\ExportController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ExportController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $export = factory(\App\Models\Export::class)->make();
        $this->action('POST', 'Admin\ExportController@store', [
                '_token' => csrf_token(),
            ] + $export->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $export = factory(\App\Models\Export::class)->create();
        $this->action('GET', 'Admin\ExportController@show', [$export->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $export = factory(\App\Models\Export::class)->create();

        $name = $faker->name;
        $id = $export->id;

        $export->notes = $name;

        $this->action('PUT', 'Admin\ExportController@update', [$id], [
                '_token' => csrf_token(),
            ] + $export->toArray());
        $this->assertResponseStatus(302);

        $newExport = \App\Models\Export::find($id);
        $this->assertEquals($name, $newExport->notes);
    }
}
