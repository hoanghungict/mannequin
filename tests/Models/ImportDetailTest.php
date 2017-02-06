<?php namespace Tests\Models;

use App\Models\ImportDetail;
use Tests\TestCase;

class ImportDetailTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ImportDetail $importDetail */
        $importDetail = new ImportDetail();
        $this->assertNotNull($importDetail);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ImportDetail $importDetail */
        $importDetailModel = new ImportDetail();

        $importDetailData = factory(ImportDetail::class)->make();
        foreach( $importDetailData->toArray() as $key => $value ) {
            $importDetailModel->$key = $value;
        }
        $importDetailModel->save();

        $this->assertNotNull(ImportDetail::find($importDetailModel->id));
    }

}
