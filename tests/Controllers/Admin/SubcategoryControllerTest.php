<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class SubcategoryControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\SubcategoryController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\SubcategoryController::class);
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
        $response = $this->action('GET', 'Admin\SubcategoryController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\SubcategoryController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $subcategory = factory(\App\Models\Subcategory::class)->make();
        $this->action('POST', 'Admin\SubcategoryController@store', [
                '_token' => csrf_token(),
            ] + $subcategory->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $subcategory = factory(\App\Models\Subcategory::class)->create();
        $this->action('GET', 'Admin\SubcategoryController@show', [$subcategory->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $subcategory = factory(\App\Models\Subcategory::class)->create();

        $name = $faker->name;
        $id = $subcategory->id;

        $subcategory->name = $name;

        $this->action('PUT', 'Admin\SubcategoryController@update', [$id], [
                '_token' => csrf_token(),
            ] + $subcategory->toArray());
        $this->assertResponseStatus(302);

        $newSubcategory = \App\Models\Subcategory::find($id);
        $this->assertEquals($name, $newSubcategory->name);
    }

    public function testDeleteModel()
    {
        $subcategory = factory(\App\Models\Subcategory::class)->create();

        $id = $subcategory->id;

        $this->action('DELETE', 'Admin\SubcategoryController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkSubcategory = \App\Models\Subcategory::find($id);
        $this->assertNull($checkSubcategory);
    }

}
