<?php namespace Tests\Models;

use App\Models\Export;
use Tests\TestCase;

class ExportTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Export $export */
        $export = new Export();
        $this->assertNotNull($export);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Export $export */
        $exportModel = new Export();

        $exportData = factory(Export::class)->make();
        foreach( $exportData->toArray() as $key => $value ) {
            $exportModel->$key = $value;
        }
        $exportModel->save();

        $this->assertNotNull(Export::find($exportModel->id));
    }

}
