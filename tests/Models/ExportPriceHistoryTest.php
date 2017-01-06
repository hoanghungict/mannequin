<?php namespace Tests\Models;

use App\Models\ExportPriceHistory;
use Tests\TestCase;

class ExportPriceHistoryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ExportPriceHistory $exportPriceHistory */
        $exportPriceHistory = new ExportPriceHistory();
        $this->assertNotNull($exportPriceHistory);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ExportPriceHistory $exportPriceHistory */
        $exportPriceHistoryModel = new ExportPriceHistory();

        $exportPriceHistoryData = factory(ExportPriceHistory::class)->make();
        foreach( $exportPriceHistoryData->toArray() as $key => $value ) {
            $exportPriceHistoryModel->$key = $value;
        }
        $exportPriceHistoryModel->save();

        $this->assertNotNull(ExportPriceHistory::find($exportPriceHistoryModel->id));
    }

}
