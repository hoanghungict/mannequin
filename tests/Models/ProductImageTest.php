<?php namespace Tests\Models;

use App\Models\ProductImage;
use Tests\TestCase;

class ProductImageTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ProductImage $productImage */
        $productImage = new ProductImage();
        $this->assertNotNull($productImage);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ProductImage $productImage */
        $productImageModel = new ProductImage();

        $productImageData = factory(ProductImage::class)->make();
        foreach( $productImageData->toArray() as $key => $value ) {
            $productImageModel->$key = $value;
        }
        $productImageModel->save();

        $this->assertNotNull(ProductImage::find($productImageModel->id));
    }

}
