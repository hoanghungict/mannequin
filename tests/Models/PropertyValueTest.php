<?php namespace Tests\Models;

use App\Models\PropertyValue;
use Tests\TestCase;

class PropertyValueTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\PropertyValue $propertyValue */
        $propertyValue = new PropertyValue();
        $this->assertNotNull($propertyValue);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\PropertyValue $propertyValue */
        $propertyValueModel = new PropertyValue();

        $propertyValueData = factory(PropertyValue::class)->make();
        foreach( $propertyValueData->toArray() as $key => $value ) {
            $propertyValueModel->$key = $value;
        }
        $propertyValueModel->save();

        $this->assertNotNull(PropertyValue::find($propertyValueModel->id));
    }

}
