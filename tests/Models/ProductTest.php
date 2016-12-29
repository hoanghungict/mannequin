<?php namespace Tests\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Product $product */
        $product = new Product();
        $this->assertNotNull($product);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Product $product */
        $productModel = new Product();

        $productData = factory(Product::class)->make();
        foreach( $productData->toArray() as $key => $value ) {
            $productModel->$key = $value;
        }
        $productModel->save();

        $this->assertNotNull(Product::find($productModel->id));
    }

}
