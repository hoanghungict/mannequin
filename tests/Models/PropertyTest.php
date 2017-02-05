<?php namespace Tests\Models;

use App\Models\Property;
use Tests\TestCase;

class PropertyTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Property $property */
        $property = new Property();
        $this->assertNotNull($property);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Property $property */
        $propertyModel = new Property();

        $propertyData = factory(Property::class)->make();
        foreach( $propertyData->toArray() as $key => $value ) {
            $propertyModel->$key = $value;
        }
        $propertyModel->save();

        $this->assertNotNull(Property::find($propertyModel->id));
    }

}
