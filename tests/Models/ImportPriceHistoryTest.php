<?php namespace Tests\Models;

use App\Models\ImportPriceHistory;
use Tests\TestCase;

class ImportPriceHistoryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ImportPriceHistory $importPriceHistory */
        $importPriceHistory = new ImportPriceHistory();
        $this->assertNotNull($importPriceHistory);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ImportPriceHistory $importPriceHistory */
        $importPriceHistoryModel = new ImportPriceHistory();

        $importPriceHistoryData = factory(ImportPriceHistory::class)->make();
        foreach( $importPriceHistoryData->toArray() as $key => $value ) {
            $importPriceHistoryModel->$key = $value;
        }
        $importPriceHistoryModel->save();

        $this->assertNotNull(ImportPriceHistory::find($importPriceHistoryModel->id));
    }

}
