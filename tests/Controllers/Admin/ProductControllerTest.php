<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ProductController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ProductController::class);
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
        $response = $this->action('GET', 'Admin\ProductController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ProductController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $product = factory(\App\Models\Product::class)->make();
        $this->action('POST', 'Admin\ProductController@store', [
                '_token' => csrf_token(),
            ] + $product->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $product = factory(\App\Models\Product::class)->create();
        $this->action('GET', 'Admin\ProductController@show', [$product->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $product = factory(\App\Models\Product::class)->create();

        $name = $faker->name;
        $id = $product->id;

        $product->name = $name;

        $this->action('PUT', 'Admin\ProductController@update', [$id], [
                '_token' => csrf_token(),
            ] + $product->toArray());
        $this->assertResponseStatus(302);

        $newProduct = \App\Models\Product::find($id);
        $this->assertEquals($name, $newProduct->name);
    }

    public function testDeleteModel()
    {
        $product = factory(\App\Models\Product::class)->create();

        $id = $product->id;

        $this->action('DELETE', 'Admin\ProductController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkProduct = \App\Models\Product::find($id);
        $this->assertNull($checkProduct);
    }

}
