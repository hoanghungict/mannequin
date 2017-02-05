<?php namespace Tests\Models;

use App\Models\ProductOptionProperty;
use Tests\TestCase;

class ProductOptionPropertyTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ProductOptionProperty $productOptionProperty */
        $productOptionProperty = new ProductOptionProperty();
        $this->assertNotNull($productOptionProperty);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ProductOptionProperty $productOptionProperty */
        $productOptionPropertyModel = new ProductOptionProperty();

        $productOptionPropertyData = factory(ProductOptionProperty::class)->make();
        foreach( $productOptionPropertyData->toArray() as $key => $value ) {
            $productOptionPropertyModel->$key = $value;
        }
        $productOptionPropertyModel->save();

        $this->assertNotNull(ProductOptionProperty::find($productOptionPropertyModel->id));
    }

}
