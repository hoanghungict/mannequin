<?php namespace Tests\Models;

use App\Models\ProductOption;
use Tests\TestCase;

class ProductOptionTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ProductOption $productOption */
        $productOption = new ProductOption();
        $this->assertNotNull($productOption);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ProductOption $productOption */
        $productOptionModel = new ProductOption();

        $productOptionData = factory(ProductOption::class)->make();
        foreach( $productOptionData->toArray() as $key => $value ) {
            $productOptionModel->$key = $value;
        }
        $productOptionModel->save();

        $this->assertNotNull(ProductOption::find($productOptionModel->id));
    }

}
