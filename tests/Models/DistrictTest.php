<?php namespace Tests\Models;

use App\Models\District;
use Tests\TestCase;

class DistrictTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\District $district */
        $district = new District();
        $this->assertNotNull($district);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\District $district */
        $districtModel = new District();

        $districtData = factory(District::class)->make();
        foreach( $districtData->toArray() as $key => $value ) {
            $districtModel->$key = $value;
        }
        $districtModel->save();

        $this->assertNotNull(District::find($districtModel->id));
    }

}
