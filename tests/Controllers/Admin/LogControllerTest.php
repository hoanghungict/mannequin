<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class LogControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\LogController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\LogController::class);
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
        $response = $this->action('GET', 'Admin\LogController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\LogController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $log = factory(\App\Models\Log::class)->make();
        $this->action('POST', 'Admin\LogController@store', [
                '_token' => csrf_token(),
            ] + $log->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $log = factory(\App\Models\Log::class)->create();
        $this->action('GET', 'Admin\LogController@show', [$log->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $log = factory(\App\Models\Log::class)->create();

        $name = $faker->name;
        $id = $log->id;

        $log->name = $name;

        $this->action('PUT', 'Admin\LogController@update', [$id], [
                '_token' => csrf_token(),
            ] + $log->toArray());
        $this->assertResponseStatus(302);

        $newLog = \App\Models\Log::find($id);
        $this->assertEquals($name, $newLog->name);
    }

    public function testDeleteModel()
    {
        $log = factory(\App\Models\Log::class)->create();

        $id = $log->id;

        $this->action('DELETE', 'Admin\LogController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkLog = \App\Models\Log::find($id);
        $this->assertNull($checkLog);
    }

}
