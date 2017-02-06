<?php namespace Tests\Models;

use App\Models\Store;
use Tests\TestCase;

class StoreTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Store $store */
        $store = new Store();
        $this->assertNotNull($store);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Store $store */
        $storeModel = new Store();

        $storeData = factory(Store::class)->make();
        foreach( $storeData->toArray() as $key => $value ) {
            $storeModel->$key = $value;
        }
        $storeModel->save();

        $this->assertNotNull(Store::find($storeModel->id));
    }

}
