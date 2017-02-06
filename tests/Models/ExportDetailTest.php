<?php namespace Tests\Models;

use App\Models\ExportDetail;
use Tests\TestCase;

class ExportDetailTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ExportDetail $exportDetail */
        $exportDetail = new ExportDetail();
        $this->assertNotNull($exportDetail);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ExportDetail $exportDetail */
        $exportDetailModel = new ExportDetail();

        $exportDetailData = factory(ExportDetail::class)->make();
        foreach( $exportDetailData->toArray() as $key => $value ) {
            $exportDetailModel->$key = $value;
        }
        $exportDetailModel->save();

        $this->assertNotNull(ExportDetail::find($exportDetailModel->id));
    }

}
