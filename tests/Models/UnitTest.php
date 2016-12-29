<?php namespace Tests\Models;

use App\Models\Unit;
use Tests\TestCase;

class UnitTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Unit $unit */
        $unit = new Unit();
        $this->assertNotNull($unit);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Unit $unit */
        $unitModel = new Unit();

        $unitData = factory(Unit::class)->make();
        foreach( $unitData->toArray() as $key => $value ) {
            $unitModel->$key = $value;
        }
        $unitModel->save();

        $this->assertNotNull(Unit::find($unitModel->id));
    }

}
